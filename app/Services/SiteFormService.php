<?php namespace App\Services;

use App\Services\Service;

use DB;
use Config;

use App\Models\User\User;
use App\Models\SiteForm;

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
     * @return bool|\App\Models\SiteForm
     */
    public function createSiteForm($data, $user)
    {
        DB::beginTransaction();

        try {
            $data['parsed_text'] = parse($data['text']);
            $data['user_id'] = $user->id;
            if(!isset($data['is_visible'])) $data['is_visible'] = 0;

            $form = SiteForm::create($data);

            return $this->commitReturn($form);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Updates a form post.
     *
     * @param  \App\Models\SiteForm       $form
     * @param  array                  $data 
     * @param  \App\Models\User\User  $user
     * @return bool|\App\Models\SiteForm
     */
    public function updateSiteForm($form, $data, $user)
    {
        DB::beginTransaction();

        try {
            $data['parsed_text'] = parse($data['text']);
            $data['user_id'] = $user->id;
            if(!isset($data['is_visible'])) $data['is_visible'] = 0;

            $form->update($data);

            return $this->commitReturn($form);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Deletes a form post.
     *
     * @param  \App\Models\SiteForm  $form
     * @return bool
     */
    public function deleteSiteForm($form)
    {
        DB::beginTransaction();

        try {
            $form->delete();

            return $this->commitReturn(true);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

}