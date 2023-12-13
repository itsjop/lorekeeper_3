<?php

namespace App\Services;

use App\Services\Service;

use DB;
use Config;

use App\Models\User\User;
use App\Models\Forms\SiteForm;
use App\Models\Forms\SiteFormOption;
use App\Models\Forms\SiteFormQuestion;
use App\Models\Forms\SiteFormAnswer;

class SiteFormManager extends Service
{
    /*
    |--------------------------------------------------------------------------
    | SiteForm Manager
    |--------------------------------------------------------------------------
    |
    | Handles the editing of forms, as well as posting answers from user side.
    |
    */
    public function postSiteForm($form, $data, $user)
    {
        DB::beginTransaction();
        try {
            // check editable when edit is set
            if(isset($data['action']) && $data['action'] == 'edit' && !$form->is_editable) throw new \Exception ("This form cannot be edited.");
            // check if submission is valid
            if(isset($data['action']) && $data['action'] == 'submit' && !$form->canSubmit()) throw new \Exception ("This form cannot be submitted at the time.");

            $nextNumber = $form->latestSubmissionNumber() + 1;
            foreach ($form->questions as $question) {
                if(isset($data['action']) && $data['action'] == 'edit'){
                    //update existing answer
                    $existingAnswer = SiteFormAnswer::where('user_id', $user->id)->where('question_id', $question->id)->where('submission_number', $data['submission_number'])->first();
                    $answer = $data[$question->id];
                    if (isset($data[$question->id])) {
                        if ($question->has_options) {
                            $existingAnswer->update([
                                'option_id' => $answer,
                            ]);
                        } else {
                            $existingAnswer->update([
                                'answer' => $answer,
                            ]);
                        }
                    }
                } else {
                    //dd($data);
                    //save new answer
                    if (isset($data[$question->id])) {
                        $answer = $data[$question->id];
                        if ($question->has_options) {
                            SiteFormAnswer::create([
                                'form_id' => $form->id,
                                'question_id' => $question->id,
                                'option_id' => $answer,
                                'user_id' => $user->id,
                                'submission_number' => $nextNumber 
                            ]);
                        } else {
                            SiteFormAnswer::create([
                                'form_id' => $form->id,
                                'question_id' => $question->id,
                                'answer' => $answer,
                                'user_id' => $user->id,
                                'submission_number' => $nextNumber 
                            ]);
                        }
                    } else {
                        SiteFormAnswer::create([
                            'form_id' => $form->id,
                            'question_id' => $question->id,
                            'user_id' => $user->id,
                            'submission_number' => $nextNumber 
                        ]);
                    }
                }
            }
            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }
}
