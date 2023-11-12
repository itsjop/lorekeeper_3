<?php

namespace App\Models\Forms;

use App\Models\Model;
use Illuminate\Support\Str;

class SiteForm extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'start_at', 'end_at', 'is_active', 'is_timed', 'is_anonymous'
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
     * Get the questions related to this form.
     */
    public function questions() 
    {
        return $this->hasMany('App\Models\Forms\SiteFormQuestion', 'form_id');
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
        return $query->where('is_active', 1);
    }

    /**********************************************************************************************
    
        ACCESSORS

    **********************************************************************************************/

    /**
     * Get the news slug.
     *
     * @return bool
     */
    public function getSlugAttribute()
    {
        return $this->id . '.' . Str::slug($this->title);
    }

    /**
     * Displays the news post title, linked to the news post itself.
     *
     * @return string
     */
    public function getDisplayNameAttribute()
    {
        return '<a href="'.$this->url.'">'.$this->title.'</a>';
    }

    /**
     * Gets the news post URL.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url('forms/'.$this->slug);
    }
}
