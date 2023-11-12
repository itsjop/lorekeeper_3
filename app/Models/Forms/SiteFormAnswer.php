<?php

namespace App\Models\Forms;

use App\Models\Model;

class SiteFormAnswer extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'form_id', 'question_id', 'option_id', 'user_id', 'answer'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'site_form_answers';

    /**
     * Whether the model contains timestamps to be saved and updated.
     *
     * @var string
     */
    public $timestamps = false;

    /**
     * Validation rules for creation.
     *
     * @var array
     */
    public static $createRules = [
        'form_id' => 'required',
        'question_id' => 'required'
    ];
    
    /**
     * Validation rules for updating.
     *
     * @var array
     */
    public static $updateRules = [
        'form_id' => 'required',
        'question_id' => 'required'    
    ];

    /**********************************************************************************************
    
        RELATIONS

    **********************************************************************************************/
    
    /**
     * Get the form this answer belongs to.
     */
    public function form() 
    {
        return $this->belongsTo('App\Models\Forms\SiteForm', 'form_id');
    }

    /**
     * Get the question this answer belongs to.
     */
    public function question() 
    {
        return $this->belongsTo('App\Models\Forms\SiteQuestion', 'question_id');
    }

    /**
     * Get the option this answer picked (if not free text answer)
     */
    public function option() 
    {
        return $this->belongsTo('App\Models\Forms\SiteFormOption', 'option_id');
    }

}
