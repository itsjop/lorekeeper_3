<?php

namespace App\Models\Profession;

use DB;
use Auth;
use Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User\User;
use App\Models\Profession\ProfessionCategory;
use App\Models\Item\Item;

class Profession extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','description', 'parsed_description', 'image_extension', 'icon_extension',
        'category_id', 'subcategory_id', 'is_active', 'sort'
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'professions';

    public $timestamps = true;

    /**
     * Validation rules for creation.
     *
     * @var array
     */
    public static $createRules = [
        'name' => 'required|unique:professions|between:3,25',
        'description' => 'nullable',
        'image' => 'mimes:png,gif,jpg,jpeg',
        'image_icon' => 'mimes:png,gif,jpg,jpeg',
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
        'image_icon' => 'mimes:png,gif,jpg,jpeg',
    ];


    /**********************************************************************************************

        RELATIONS

    **********************************************************************************************/

    /**
     * Get the category attached to this profession.
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Profession\ProfessionCategory', 'category_id');
    }

    /**
     * Get the subcategory attached to this profession.
     */
    public function subcategory()
    {
        return $this->belongsTo('App\Models\Profession\ProfessionSubCategory', 'subcategory_id');
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
        if(!Auth::check() || !(Auth::check() && Auth::user()->isStaff)) return $query->where('is_active', 1)->orderBy('sort', 'DESC');
        else return $query;
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
        if($this->is_active) {return $this->name;}
        else {return '<s>'.$this->name.'</s>';}
    }

    /**
     * Gets the file directory containing the model's image.
     *
     * @return string
     */
    public function getImageDirectoryAttribute()
    {
        return 'images/data/profession';
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
     * Gets the file name of the model's icon image.
     *
     * @return string
     */
    public function getIconFileNameAttribute()
    {
        return $this->id . '-th.'. $this->icon_extension;
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
     * Gets the URL of the model's icon image.
     *
     * @return string
     */
    public function getIconUrlAttribute()
    {
        if (!$this->icon_extension) return null;
        return asset($this->imageDirectory . '/' . $this->iconFileName);
    }

    /**
     * Gets the URL of the model's encyclopedia page.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url('world/professions/'.$this->id);
    }



    /**********************************************************************************************

        SCOPES

    **********************************************************************************************/



    /**
     * Scope a query to sort items in category order.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortCategory($query)
    {
        $ids = ProfessionCategory::orderBy('sort', 'DESC')->pluck('id')->toArray();
        return count($ids) ? $query->orderByRaw(DB::raw('FIELD(category_id, '.implode(',', $ids).')')) : $query;
    }
    /**
     * Scope a query to sort items in alphabetical order.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  bool                                   $reverse
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortAlphabetical($query, $reverse = false)
    {
        return $query->orderBy('name', $reverse ? 'DESC' : 'ASC');
    }

    /**
     * Scope a query to sort items by newest first.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortNewest($query)
    {
        return $query->orderBy('id', 'DESC');
    }

    /**
     * Scope a query to sort features oldest first.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortOldest($query)
    {
        return $query->orderBy('id');
    }


    public static function getProfessionsByCategory()
    {
        $sorted_profession_categories = collect(ProfessionCategory::all()->sortBy('name')->pluck('name')->toArray());
        $grouped = self::select('name', 'id', 'category_id')->with('category')->orderBy('name')->get()->keyBy('id')->groupBy('category.name', $preserveKeys = true)->toArray();
        if (isset($grouped[''])) {
            if (!$sorted_profession_categories->contains('Miscellaneous')) {
                $sorted_profession_categories->push('Miscellaneous');
            }
            $grouped['Miscellaneous'] = $grouped['Miscellaneous'] ?? [] + $grouped[''];
        }
        $sorted_profession_categories = $sorted_profession_categories->filter(function ($value, $key) use ($grouped) {
            return in_array($value, array_keys($grouped), true);
        });
        foreach ($grouped as $category => $professions) {
            foreach ($professions as $id => $profession) {
                $grouped[$category][$id] = $profession['name'];
            }
        }
        $professions_by_category = $sorted_profession_categories->map(function ($type) use ($grouped) {
            return $grouped;
        });
        unset($grouped['']);
        ksort($grouped);

        return $grouped;
    }

    public static function getProfessionsByCategoryAndActive()
    {
        $sorted_profession_categories = collect(ProfessionCategory::all()->sortBy('name')->pluck('name')->toArray());
        $grouped = self::select('name', 'id', 'category_id')->with('category')->where('is_active', 1)->orderBy('name')->get()->keyBy('id')->groupBy('category.name', $preserveKeys = true)->toArray();
        if (isset($grouped[''])) {
            if (!$sorted_profession_categories->contains('Miscellaneous')) {
                $sorted_profession_categories->push('Miscellaneous');
            }
            $grouped['Miscellaneous'] = $grouped['Miscellaneous'] ?? [] + $grouped[''];
        }
        $sorted_profession_categories = $sorted_profession_categories->filter(function ($value, $key) use ($grouped) {
            return in_array($value, array_keys($grouped), true);
        });
        foreach ($grouped as $category => $professions) {
            foreach ($professions as $id => $profession) {
                $grouped[$category][$id] = $profession['name'];
            }
        }
        $professions_by_category = $sorted_profession_categories->map(function ($type) use ($grouped) {
            return $grouped;
        });
        unset($grouped['']);
        ksort($grouped);

        return $grouped;
    }


}
