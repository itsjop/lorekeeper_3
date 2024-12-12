<?php namespace App\Services;

use App\Services\Service;

use DB;
use Config;

use App\Models\Profession\ProfessionSubcategory;
use App\Models\Profession\ProfessionCategory;
use App\Models\Profession\Profession;
use App\Models\Species\Species;
use App\Models\Species\Subtype;

class ProfessionService extends Service
{
    /*
    |--------------------------------------------------------------------------
    | Profession Service
    |--------------------------------------------------------------------------
    |
    | Handles the creation and editing of profession categories and professions.
    |
    */

    /**********************************************************************************************
     
        PROFESSION CATEGORIES

    **********************************************************************************************/

    /**
     * Create a category.
     *
     * @param  array                 $data
     * @param  \App\Models\User\User $user
     * @return \App\Models\Profession\ProfessionCategory|bool
     */
    public function createProfessionCategory($data, $user)
    {
        DB::beginTransaction();

        try {
            $data = $this->populateCategoryData($data);

            $image = null;
            if(isset($data['image']) && $data['image']) {
                $image = $data['image'];
                unset($data['image']);
            }
           
            $category = ProfessionCategory::create($data);

            if ($image) {
                $category->image_extension = $image->getClientOriginalExtension();
                $category->update();
                $this->handleImage($image, $category->imagePath, $category->imageFileName, null);
            }

            return $this->commitReturn($category);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Update a category.
     *
     * @param  \App\Models\Profession\ProfessionCategory  $category
     * @param  array                                $data
     * @param  \App\Models\User\User                $user
     * @return \App\Models\Profession\ProfessionCategory|bool
     */
    public function updateProfessionCategory($category, $data, $user)
    {
        DB::beginTransaction();

        try {
            // More specific validation
            if(ProfessionCategory::where('name', $data['name'])->where('id', '!=', $category->id)->exists()) throw new \Exception("The name has already been taken.");

            $data = $this->populateCategoryData($data, $category);

            $image = null;
            if(isset($data['image']) && $data['image']) {
                if(isset($category->image_extension)) $old = $category->imageFileName;
                else $old = null;
                $image = $data['image'];
                unset($data['image']);
            }
            if ($image) {
                $category->image_extension = $image->getClientOriginalExtension();
                $category->update();
                $this->handleImage($image, $category->imagePath, $category->imageFileName, $old);
            }

            $category->update($data);

            return $this->commitReturn($category);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Handle category data.
     *
     * @param  array                                     $data
     * @param  \App\Models\Profession\ProfessionCategory|null  $category
     * @return array
     */
    private function populateCategoryData($data, $category = null)
    {
        if(isset($data['description']) && $data['description']) $data['parsed_description'] = parse($data['description']);
        if(!isset($data['species_id']) || $data['species_id'] == 'none') $data['species_id'] = null;

        if(isset($data['remove_image']))
        {
            if($category && $category->image_extension && $data['remove_image']) 
            { 
                $data['image_extension'] = null; 
                $this->deleteImage($category->imagePath, $category->imageFileName); 
            }
            unset($data['remove_image']);
        }

        return $data;
    }

    /**
     * Delete a category.
     *
     * @param  \App\Models\Profession\ProfessionCategory  $category
     * @return bool
     */
    public function deleteProfessionCategory($category)
    {
        DB::beginTransaction();

        try {
            // Check first if the category is currently in use
            if(Profession::where('category_id', $category->id)->exists()) throw new \Exception("A profession with this category exists. Please change its category first.");
            
            if($category->has_image) $this->deleteImage($category->categoryImagePath, $category->categoryImageFileName); 
            $category->delete();

            return $this->commitReturn(true);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Sorts category order.
     *
     * @param  array  $data
     * @return bool
     */
    public function sortProfessionCategory($data)
    {
        DB::beginTransaction();

        try {
            // explode the sort array and reverse it since the order is inverted
            $sort = array_reverse(explode(',', $data));

            foreach($sort as $key => $s) {
                ProfessionCategory::where('id', $s)->update(['sort' => $key]);
            }

            return $this->commitReturn(true);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**********************************************************************************************
     
        PROFESSION SUBCATEGORIES

    **********************************************************************************************/

    /**
     * Create a category.
     *
     * @param  array                 $data
     * @param  \App\Models\User\User $user
     * @return \App\Models\Profession\ProfessionSubcategory|bool
     */
    public function createProfessionSubcategory($data, $user)
    {
        DB::beginTransaction();

        try {
            $data = $this->populateSubcategoryData($data);

            $image = null;
            if(isset($data['image']) && $data['image']) {
                $image = $data['image'];
                unset($data['image']);
            }
           
            $category = ProfessionSubcategory::create($data);

            if ($image) {
                $category->image_extension = $image->getClientOriginalExtension();
                $category->update();
                $this->handleImage($image, $category->imagePath, $category->imageFileName, null);
            }

            return $this->commitReturn($category);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Update a category.
     *
     * @param  \App\Models\Profession\ProfessionSubcategory  $category
     * @param  array                                $data
     * @param  \App\Models\User\User                $user
     * @return \App\Models\Profession\ProfessionSubcategory|bool
     */
    public function updateProfessionSubcategory($category, $data, $user)
    {
        DB::beginTransaction();

        try {
            // More specific validation
            if(ProfessionSubcategory::where('name', $data['name'])->where('id', '!=', $category->id)->exists()) throw new \Exception("The name has already been taken.");

            $data = $this->populateSubcategoryData($data, $category);

            $image = null;
            if(isset($data['image']) && $data['image']) {
                if(isset($category->image_extension)) $old = $category->imageFileName;
                else $old = null;
                $image = $data['image'];
                unset($data['image']);
            }
            if ($image) {
                $category->image_extension = $image->getClientOriginalExtension();
                $category->update();
                $this->handleImage($image, $category->imagePath, $category->imageFileName, $old);
            }
            $category->update($data);

            return $this->commitReturn($category);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Handle category data.
     *
     * @param  array                                     $data
     * @param  \App\Models\Profession\ProfessionSubcategory|null  $category
     * @return array
     */
    private function populateSubcategoryData($data, $category = null)
    {
        if(isset($data['description']) && $data['description']) $data['parsed_description'] = parse($data['description']);
        if(!isset($data['category_id']) || $data['category_id'] == 'none') throw new \Exception("A subcategory must be linked to a category.");

        if(isset($data['remove_image']))
        {
            if($category && $category->image_extension && $data['remove_image']) 
            { 
                $data['image_extension'] = null; 
                $this->deleteImage($category->imagePath, $category->imageFileName); 
            }
            unset($data['remove_image']);
        }

        return $data;
    }

    /**
     * Delete a category.
     *
     * @param  \App\Models\Profession\ProfessionSubcategory  $category
     * @return bool
     */
    public function deleteProfessionSubcategory($category)
    {
        DB::beginTransaction();

        try {
            // Check first if the category is currently in use
            if(Profession::where('subcategory_id', $category->id)->exists()) throw new \Exception("A profession with this subcategory exists. Please change its subcategory first.");
            
            if($category->has_image) $this->deleteImage($category->categoryImagePath, $category->categoryImageFileName); 
            $category->delete();

            return $this->commitReturn(true);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Sorts category order.
     *
     * @param  array  $data
     * @return bool
     */
    public function sortProfessionSubcategory($data)
    {
        DB::beginTransaction();

        try {
            // explode the sort array and reverse it since the order is inverted
            $sort = array_reverse(explode(',', $data));

            foreach($sort as $key => $s) {
                ProfessionSubcategory::where('id', $s)->update(['sort' => $key]);
            }

            return $this->commitReturn(true);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }
    
    /**********************************************************************************************
     
        PROFESSIONS

    **********************************************************************************************/

    /**
     * Creates a new profession.
     *
     * @param  array                  $data 
     * @param  \App\Models\User\User  $user
     * @return bool|\App\Models\Profession\Profession
     */
    public function createProfession($data, $user)
    {
        DB::beginTransaction();

        try {
            if(Profession::where('name', $data['name'])->exists()) throw new \Exception("The name has already been taken.");

            if(isset($data['category_id']) && $data['category_id'] == 'none') $data['category_id'] = null;
            if(isset($data['subcategory_id']) && $data['subcategory_id'] == 'none') $data['subcategory_id'] = null;
            if(isset($data['species_id']) && $data['species_id'] == 'none') $data['species_id'] = null;

            if((isset($data['category_id']) && $data['category_id']) && !ProfessionCategory::where('id', $data['category_id'])->exists()) throw new \Exception("The selected profession category is invalid.");
            if((isset($data['subcategory_id']) && $data['subcategory_id']) && !ProfessionSubcategory::where('id', $data['subcategory_id'])->exists()) throw new \Exception("The selected profession subcategory is invalid.");
            if((isset($data['species_id']) && $data['species_id']) && !Species::where('id', $data['species_id'])->exists()) throw new \Exception("The selected species is invalid.");


            $data = $this->populateData($data);

            $image = null;
            if(isset($data['image']) && $data['image']) {
                $data['has_image'] = 1;
                $image = $data['image'];
                unset($data['image']);
            }
            $image_icon = null;
            if(isset($data['image_icon']) && $data['image_icon']) {
                $image_icon = $data['image_icon'];
                unset($data['image_icon']);
            }

            $profession = Profession::create($data);

            if ($image) {
                $profession->image_extension = $image->getClientOriginalExtension();
                $profession->update();
                $this->handleImage($image, $profession->imagePath, $profession->imageFileName, null);
            }
            if ($image_icon) {
                $profession->icon_extension = $image_icon->getClientOriginalExtension();
                $profession->update();
                $this->handleImage($image_icon, $profession->imagePath, $profession->iconFileName, null);
            }

            return $this->commitReturn($profession);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Updates a profession.
     *
     * @param  \App\Models\Profession\Profession  $profession
     * @param  array                        $data 
     * @param  \App\Models\User\User        $user
     * @return bool|\App\Models\Profession\Profession
     */
    public function updateProfession($profession, $data, $user)
    {
        DB::beginTransaction();

        try {

            // More specific validation
            if(Profession::where('name', $data['name'])->where('id', '!=', $profession->id)->exists()) throw new \Exception("The name has already been taken.");

            if(isset($data['category_id']) && $data['category_id'] == 'none') $data['category_id'] = null;
            if(isset($data['subcategory_id']) && $data['subcategory_id'] == 'none') $data['subcategory_id'] = null;
            if(isset($data['species_id']) && $data['species_id'] == 'none') $data['species_id'] = null;

            if((isset($data['category_id']) && $data['category_id']) && !ProfessionCategory::where('id', $data['category_id'])->exists()) throw new \Exception("The selected profession category is invalid.");
            if((isset($data['subcategory_id']) && $data['subcategory_id']) && !ProfessionSubcategory::where('id', $data['subcategory_id'])->exists()) throw new \Exception("The selected profession subcategory is invalid.");
            if((isset($data['species_id']) && $data['species_id']) && !Species::where('id', $data['species_id'])->exists()) throw new \Exception("The selected species is invalid.");


            $data = $this->populateData($data);

            
            $image = null;
            if(isset($data['image']) && $data['image']) {
                if(isset($profession->image_extension)) $old = $profession->imageFileName;
                else $old = null;
                $image = $data['image'];
                unset($data['image']);
            }
            if ($image) {
                $profession->image_extension = $image->getClientOriginalExtension();
                $profession->update();
                $this->handleImage($image, $profession->imagePath, $profession->imageFileName, $old);
            }

            $image_icon = null;
            if(isset($data['image_icon']) && $data['image_icon']) {
                if(isset($profession->icon_extension)) $old_th = $profession->iconFileName;
                else $old_th = null;
                $image_icon = $data['image_icon'];
                unset($data['image_icon']);
            }

            if ($image_icon) {
                $profession->icon_extension = $image_icon->getClientOriginalExtension();
                $profession->update();
                $this->handleImage($image_icon, $profession->imagePath, $profession->iconFileName, $old_th);
            }

            $profession->update($data);

            return $this->commitReturn($profession);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Processes user input for creating/updating a profession.
     *
     * @param  array                        $data 
     * @param  \App\Models\Profession\Profession  $profession
     * @return array
     */
    private function populateData($data, $profession = null)
    {

        if(!isset($data['category_id'])) throw new \Exception("A profession must have a category.");

        if(isset($data['description']) && $data['description']) $data['parsed_description'] = parse($data['description']);
        if(isset($data['species_id']) && $data['species_id'] == 'none') $data['species_id'] = null;
        if(isset($data['category_id']) && $data['category_id'] == 'none') $data['category_id'] = null;
        if(isset($data['subcategory_id']) && $data['subcategory_id'] == 'none') $data['subcategory_id'] = null;
        $data['is_active'] = isset($data['is_active']);
        $data['is_choosable'] = isset($data['is_choosable']);

        if(isset($data['remove_image']))
        {
            if($profession && $profession->image_extension && $data['remove_image']) 
            { 
                $data['image_extension'] = null; 
                $this->deleteImage($profession->imagePath, $profession->imageFileName); 
            }
            unset($data['remove_image']);
        }

        if(isset($data['remove_image_icon']))
        {
            if($profession && $profession->icon_extension && $data['remove_image_icon']) 
            { 
                $data['icon_extension'] = null; 
                $this->deleteImage($profession->imagePath, $profession->iconFileName); 
            }
            unset($data['remove_image_icon']);
        }

        return $data;
    }
    
    /**
     * Deletes a profession.
     *
     * @param  \App\Models\Profession\Profession  $profession
     * @return bool
     */
    public function deleteProfession($profession)
    {
        DB::beginTransaction();

        try {
            // Check first if the profession is currently in use
            if(DB::table('character_profiles')->where('profession_id', $profession->id)->exists()) throw new \Exception("A character with this profession exists. Please remove the profession from all characters first.");
            
            if($profession->has_image) $this->deleteImage($profession->imagePath, $profession->imageFileName); 
            $profession->delete();

            return $this->commitReturn(true);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Sorts profession order.
     *
     * @param  array  $data
     * @return bool
     */
    public function sortProfession($data)
    {
        DB::beginTransaction();

        try {
            // explode the sort array and reverse it since the order is inverted
            $sort = array_reverse(explode(',', $data));

            foreach($sort as $key => $s) {
                Profession::where('id', $s)->update(['sort' => $key]);
            }

            return $this->commitReturn(true);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }
}