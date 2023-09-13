<?php
namespace App\Models\Profession;

use Config;
use DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User\User;
use App\Models\Profession\Profession;

class ProfessionSubcategory extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',  'description', 'parsed_description', 'sort', 'image_extension', 'category_id'
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profession_subcategories';

    public $timestamps = true;

    /**
     * Validation rules for creation.
     *
     * @var array
     */
    public static $createRules = [
        'name' => 'required|unique:profession_subcategories|between:3,25',
        'description' => 'nullable',
        'image' => 'mimes:png,gif,jpg,jpeg',
        'category_id' => 'required',

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
        'category_id' => 'required',
    ];


    /**********************************************************************************************

        RELATIONS
    **********************************************************************************************/

    /**
     * Get the professions attached to this subcategory.
     */
    public function professions()
    {
        return $this->hasMany('App\Models\Profession\Profession', 'subcategory_id')->visible();
    }


    /**
     * Get the category attached to this subcategory.
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Profession\ProfessionCategory', 'category_id');
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
        return 'images/data/profession_subcategories';
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
        return url('world/profession-subcategories/'.$this->id);
    }

    /**
     * Gets the URL of the model's encyclopedia page.
     *
     * @return string
     */
    public function getSearchUrlAttribute()
    {
        return url('world/professions?subcategory_id='.$this->id.'&sort=subcategory');
    }


}
