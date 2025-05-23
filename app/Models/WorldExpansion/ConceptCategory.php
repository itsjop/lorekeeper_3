<?php

namespace App\Models\WorldExpansion;

use Illuminate\Database\Eloquent\Model;

class ConceptCategory extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',  'description', 'summary', 'parsed_description', 'sort', 'image_extension', 'thumb_extension',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'concept_categories';

    public $timestamps = true;

    /**
     * Validation rules for creation.
     *
     * @var array
     */
    public static $createRules = [
        'name'        => 'required|unique:concept_categories|between:3,25',
        'description' => 'nullable',
        'summary'     => 'nullable|max:300',
        'image'       => 'mimes:png,gif,jpg,jpeg',
        'image_th'    => 'mimes:png,gif,jpg,jpeg',
    ];

    /**
     * Validation rules for updating.
     *
     * @var array
     */
    public static $updateRules = [
        'name'        => 'required|between:3,25',
        'description' => 'nullable',
        'summary'     => 'nullable|max:300',
        'image'       => 'mimes:png,gif,jpg,jpeg',
        'image_th'    => 'mimes:png,gif,jpg,jpeg',
    ];

    /**********************************************************************************************

        RELATIONS
    **********************************************************************************************/

    /**
     * Get the concepts attached to this type.
     */
    public function concepts() {
        return $this->hasMany(Concept::class, 'category_id')->visible();
    }

    /**********************************************************************************************

        ACCESSORS
    **********************************************************************************************/

    /**
     * Displays the location type's name, linked to its purchase page.
     *
     * @return string
     */
    public function getDisplayNameAttribute() {
        return '<a href="'.$this->url.'" class="display-type">'.$this->name.'</a>';
    }

    /**
     * Gets the file directory containing the model's image.
     *
     * @return string
     */
    public function getImageDirectoryAttribute() {
        return 'images/data/concept_categories';
    }

    /**
     * Gets the path to the file directory containing the model's image.
     *
     * @return string
     */
    public function getImagePathAttribute() {
        return public_path($this->imageDirectory);
    }

    /**
     * Gets the file name of the model's image.
     *
     * @return string
     */
    public function getImageFileNameAttribute() {
        return $this->id.'-image.'.$this->image_extension;
    }

    /**
     * Gets the file name of the model's thumbnail image.
     *
     * @return string
     */
    public function getThumbFileNameAttribute() {
        return $this->id.'-th.'.$this->thumb_extension;
    }

    /**
     * Gets the URL of the model's image.
     *
     * @return string
     */
    public function getImageUrlAttribute() {
        if (!$this->image_extension) {
            return null;
        }

        return asset($this->imageDirectory.'/'.$this->imageFileName);
    }

    /**
     * Gets the URL of the model's thumbnail image.
     *
     * @return string
     */
    public function getThumbUrlAttribute() {
        if (!$this->thumb_extension) {
            return null;
        }

        return asset($this->imageDirectory.'/'.$this->thumbFileName);
    }

    /**
     * Gets the URL of the model's encyclopedia page.
     *
     * @return string
     */
    public function getUrlAttribute() {
        return url('world/concept-categories/'.$this->id);
    }

    /**
     * Gets the URL of the model's encyclopedia page.
     *
     * @return string
     */
    public function getSearchUrlAttribute() {
        return url('world/concepts?category_id='.$this->id.'&sort=category');
    }
}
