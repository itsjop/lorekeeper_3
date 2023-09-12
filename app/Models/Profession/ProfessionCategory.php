<?php
namespace App\Models\Profession;

use Config;
use DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User\User;
use App\Models\Profession\Profession;
use App\Models\Profession\ProfessionSubcategory;

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
     * Get the professions attached to this type.
     */
    public function professions()
    {
        return $this->hasMany('App\Models\Profession\Profession', 'category_id')->visible();
    }

    public function subcategories()
    {
        return $this->hasMany('App\Models\Profession\ProfessionSubCategory', 'category_id');
    }

    /**
     * Get the species of the category.
     */
    public function species()
    {
        return $this->belongsTo('App\Models\Species\Species', 'species_id');
    }


    /**********************************************************************************************

        ACCESSORS
    **********************************************************************************************/
    
    /**
     * Get professions by subcategory and put those without one into the general category.
     */
    public function getProfessionsBySubcategoryAttribute()
    {
        //get professions sort by subcategory sort
        $professions = Profession::where('professions.category_id', $this->id)->where('is_active', 1)->with('subcategory')
        ->join('profession_subcategories', 'profession_subcategories.id', '=', 'professions.subcategory_id')
        ->select('professions.*') 
        ->orderBy('profession_subcategories.sort', 'DESC')
        ->get()->groupBy('subcategory_id');

        //add all empty ones under general/empty id
        $noCatprofessions = Profession::where('category_id', $this->id)->where('is_active', 1)->where('subcategory_id', null)->get();
        $professions->put('', $noCatprofessions);
        //
        return $professions;
    }

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
