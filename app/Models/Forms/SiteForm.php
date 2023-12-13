<?php

namespace App\Models\Forms;

use App\Models\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Traits\Commentable;

class SiteForm extends Model
{
    use Commentable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'title', 'description', 'parsed_description', 'start_at', 'end_at', 'is_active', 'is_timed', 'is_anonymous',
        'timeframe', 'is_public', 'is_editable',  'allow_likes'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'site_forms';

    /**
     * Whether the model contains timestamps to be saved and updated.
     *
     * @var string
     */
    public $timestamps = true;

    /**
     * Validation rules for creation.
     *
     * @var array
     */
    public static $createRules = [
        'title' => 'required|between:3,100',
    ];
    
    /**
     * Validation rules for updating.
     *
     * @var array
     */
    public static $updateRules = [
        'title' => 'required|between:3,100',
    ];

    /**********************************************************************************************
    
        RELATIONS

    **********************************************************************************************/
    
    /**
     * Get the user who created the news post.
     */
    public function user() 
    {
        return $this->belongsTo('App\Models\User\User');
    }

    /**
     * Get the questions related to this form.
     */
    public function questions() 
    {
        return $this->hasMany('App\Models\Forms\SiteFormQuestion', 'form_id');
    }

    
    /**
     * Get the questions related to this form.
     */
    public function answers() 
    {
        return $this->hasMany('App\Models\Forms\SiteFormAnswer', 'form_id');
    }

    /**********************************************************************************************
    
        SCOPES

    **********************************************************************************************/

    /**
     * Scope a query to only include visible posts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisible($query)
    {
        return $query->where('is_active', 1)->where('is_timed', '<=', 0)->orWhere('is_timed', '>=', 1)->where('start_at', '<=', Carbon::now())->where('is_active', 1);
    }

    /**********************************************************************************************
    
        ACCESSORS

    **********************************************************************************************/

    /**
     * Get the form slug.
     *
     * @return bool
     */
    public function getSlugAttribute()
    {
        return $this->id . '.' . Str::slug($this->title);
    }

    /**
     * Displays the form post title, linked to the form post itself.
     *
     * @return string
     */
    public function getDisplayNameAttribute()
    {
        return '<a href="'.$this->url.'">'.$this->title.'</a>';
    }

    /**
     * Gets the form post URL.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url('forms/'.$this->slug);
    }

    public function getStartDateAttribute(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->start_at);
    }

    public function getEndDateAttribute(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->end_at);
    }
    
    /**********************************************************************************************
    
        OTHER

    **********************************************************************************************/

    /*
     * Gets the current date associated to the forms's timeframe
     */
    public function getTimeframeDateAttribute() {
        switch($this->timeframe) {
            case "yearly":
                $date = date("Y-m-d H:i:s", strtotime('January 1st')); 
                break;
            case "monthly":
                $date = date("Y-m-d H:i:s", strtotime('midnight first day of this month')); 
                break;
            case "weekly":
                $date = date("Y-m-d H:i:s", strtotime('last sunday')); 
                break;
            case "daily":
                $date = date("Y-m-d H:i:s", strtotime('midnight'));
                break;
            default:
                $date = null;
        }
        return $date;
    }

    public function canSubmit()
    {
        //if form is closed by time, we dont allow submissions
        if($this->is_timed && $this->end_at < Carbon::now()) return false;

        //if form is open check timeframe
        $lastSubmission = $this->answers()->orderBy('created_at', 'DESC')->first();
        if ($lastSubmission) {
            // if a timer exists we cannot submit again if the time is right
            if ($lastSubmission->created_at >= $this->timeframeDate) return false;
        }
        return true;
    }

    public function latestSubmissionNumber(){
        $answers = $this->answers()->get()->groupBy('submission_number');
        return max( array_keys( $answers->toArray() ) );
    }

}
