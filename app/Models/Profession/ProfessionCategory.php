<?php
namespace App\Models\Profession;

use Config;
use DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User\User;
use App\Models\Profession\Profession;

class ProfessionCategory extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',  'description', 'parsed_description', 'sort', 'image_extension', 'species_id'
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profession_categories';

    public $timestamps = true;

    /**
     * Validation rules for creation.
     *
     * @var array
     */
    public static $createRules = [
        'name' => 'required|unique:profession_categories|between:3,25',
        'description' => 'nullable',
        'image' => 'mimes:png,gif,jpg,jpeg',
    ];

    /**
     * Validation rules for updating.
     *
     * @var array
     */
    public static $updateRules = [
        'name' => 'required|between:3,25',
        'description' => 'nullable',
        'image' => 'mimes:png,gif,jpg,jpeg',
    ];


    /**********************************************************************************************

        RELATIONS
    **********************************************************************************************/

    /**
     * Get the location attached to this type.
     */
    public function professions()
    {
        return $this->hasMany('App\Models\Profession\Profession', 'category_id')->visible();
    }

    /**
     * Get the species of the character image.
     */
    public function species()
    {
        return $this->belongsTo('App\Models\Species\Species', 'species_id');
    }


    /**********************************************************************************************

        ACCESSORS
    **********************************************************************************************/

    /**
     * Displays linked name.
     *
     * @return string
     */
    public function getDisplayNameAttribute()
    {
        return $this->name;
    }

    /**
     * Gets the file directory containing the model's image.
     *
     * @return string
     */
    public function getImageDirectoryAttribute()
    {
        return 'images/data/profession_categories';
    }

    /**
     * Gets the path to the file directory containing the model's image.
     *
     * @return string
     */
    public function getImagePathAttribute()
    {
        return public_path($this->imageDirectory);
    }


    /**
     * Gets the file name of the model's image.
     *
     * @return string
     */
    public function getImageFileNameAttribute()
    {
        return $this->id . '-image.' . $this->image_extension;
    }


    /**
     * Gets the URL of the model's image.
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image_extension) return null;
        return asset($this->imageDirectory . '/' . $this->imageFileName);
    }

    /**
     * Gets the URL of the model's encyclopedia page.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url('world/profession-categories/'.$this->id);
    }

    /**
     * Gets the URL of the model's encyclopedia page.
     *
     * @return string
     */
    public function getSearchUrlAttribute()
    {
        return url('world/professions?category_id='.$this->id.'&sort=category');
    }


}
