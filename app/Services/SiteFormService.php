<?php

namespace App\Services;

use App\Services\Service;

use DB;
use Config;

use App\Models\User\User;
use App\Models\Forms\SiteForm;
use App\Models\Forms\SiteFormOption;
use App\Models\Forms\SiteFormQuestion;

class SiteFormService extends Service
{
    /*
    |--------------------------------------------------------------------------
    | SiteForm Service
    |--------------------------------------------------------------------------
    |
    | Handles the creation and editing of forms.
    |
    */

    /**
     * Creates a form post.
     *
     * @param  array                  $data
     * @param  \App\Models\User\User  $user
     * @param  App\Models\Forms\SiteForm  $form
     */
    public function createSiteForm($data, $user)
    {
        DB::beginTransaction();
        try {
            $data = $this->populateFormData($data);
            $data['user_id'] = $user->id;
            $form = SiteForm::create($data);

            $this->createFormQuestions($data['questions'], $data['options'], $form);

            return $this->commitReturn($form);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Updates a form post.
     *
     * @param  App\Models\Forms\SiteForm  $form
     * @param  array                  $data 
     * @param  \App\Models\User\User  $user
     * @return bool|\App\Models\SiteForm
     */
    public function updateSiteForm($form, $data, $user)
    {
        DB::beginTransaction();

        try {
            $data = $this->populateFormData($data);
            $data['user_id'] = $user->id;
            $form->update($data);
            $this->updateFormQuestions($data['questions'], $data['options'], $form);

            return $this->commitReturn($form);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Deletes a form post and all related answers.
     *
     * @param  App\Models\Forms\SiteForm  $form
     * @return bool
     */
    public function deleteSiteForm($form)
    {
        DB::beginTransaction();

        try {
            if ($form->questions->count() > 0) {
                foreach ($form->questions as $question) {
                    if ($question->options()->count() > 0) $question->options()->delete();
                    if ($question->answers()->count() > 0) $question->answers()->delete();
                    $question->delete();
                }
            }
            $form->delete();

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Processes user input for creating/updating a form.
     *
     * @param  array                  $data
     * @param  App\Models\Forms\SiteForm  $form
     * @return array
     */
    private function populateFormData($data)
    {
        if (isset($data['description']) && $data['description']) $data['parsed_description'] = parse($data['description']);
        $data['is_active'] = isset($data['is_active']);
        $data['is_timed'] = isset($data['is_timed']);
        $data['is_anonymous'] = isset($data['is_anonymous']);
        return $data;
    }

    /**
     * Creates the question and option rows for the form.
     *
     * @param  array                  $questions array of questions by question id [dhfshfs] => "hello how are you?"
     * @param  array                  $options array of options by question id [dhfshfs][1] => "Good!"
     * @param  App\Models\Forms\SiteForm  $form
     * @return array
     */
    private function createFormQuestions($questions, $options, $form)
    {
        $questions = array_filter($questions);
        foreach ($questions as $id => $question) {
            if ($id != 'default') { // ignore empty default
                $op = array_filter($options[$id]); //filter to remove null values
                // save question
                $questionEntry = SiteFormQuestion::create([
                    'form_id' => $form->id,
                    'question' => $question,
                    'has_options' => count($op) > 0
                ]);

                //save options
                foreach ($op as $option) {
                    SiteFormOption::create([
                        'question_id' => $questionEntry->id,
                        'option' => $option,
                    ]);
                }
            }
        }
    }

    /**
     * Updates the question and option rows for the form.
     *
     * @param  array                  $questions array of questions by question id [dhfshfs] => "hello how are you?"
     * @param  array                  $options array of options by question id [dhfshfs][1] => "Good!"
     * @param  App\Models\Forms\SiteForm  $form
     * @return array
     */
    private function updateFormQuestions($questions, $options, $form)
    {
        //update exisiting questions...
        foreach ($form->questions as $question) {
            if (isset($questions[$question->id])) {
                $questionData = $questions[$question->id];
                (isset($options[$question->id])) ? $optionsData = array_filter($options[$question->id]) : []; //filter to remove null values

                // update question
                $question->update([
                    'question' => $questionData,
                    'has_options' => count($optionsData) > 0
                ]);


                //remove question from array so we dont re-create it later
                unset($questions[$question->id]);

                foreach ($question->options as $option) {

                    if (isset($optionsData[$option->id])) {
                        //update option
                        $option->update([
                            'option' => $optionsData[$option->id],
                        ]);
                    } else {
                        //if option wasnt passed it was removed so we delete it.
                        $option->delete();
                    }

                    //remove option from array so we dont re-create it later
                    unset($options[$question->id][$option->id]);
                }
            } else {
                // if question wasnt passed it was removed so we delete it and the related options/answers.
                if ($question->options()->count() > 0) $question->options->each->delete();
                if ($question->answers()->count() > 0) $question->answers->each->delete();
                $question->delete();
            }
        }
        //then just create the rest anew.
        $this->createFormQuestions($questions, $options, $form);
    }
}
