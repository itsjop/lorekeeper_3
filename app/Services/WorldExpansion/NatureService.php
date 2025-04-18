<?php

namespace App\Services\WorldExpansion;

use App\Models\WorldExpansion\Fauna;
use App\Models\WorldExpansion\FaunaCategory;
use App\Models\WorldExpansion\Flora;
use App\Models\WorldExpansion\FloraCategory;
use App\Services\Service;
use DB;

class NatureService extends Service {
    /*
    |--------------------------------------------------------------------------
    | Nature Service
    |--------------------------------------------------------------------------
    |
    | Handles the creation and editing of natural things like flora and fauna.
    |
    */

    /**
     * Creates a new fauna category.
     *
     * @param array                 $data
     * @param \App\Models\User\User $user
     *
     * @return \App\Models\Fauna\Category|bool
     */
    public function createFaunaCategory($data, $user) {
        DB::beginTransaction();

        try {
            $data = $this->populateFaunaCategoryData($data);

            $image = null;
            if (isset($data['image']) && $data['image']) {
                $image = $data['image'];
                unset($data['image']);
            }
            $image_th = null;
            if (isset($data['image_th']) && $data['image_th']) {
                $image_th = $data['image_th'];
                unset($data['image_th']);
            }

            $category = FaunaCategory::create($data);

            if ($image) {
                $category->image_extension = $image->getClientOriginalExtension();
                $category->update();
                $this->handleImage($image, $category->imagePath, $category->imageFileName, null);
            }
            if ($image_th) {
                $category->thumb_extension = $image_th->getClientOriginalExtension();
                $category->update();
                $this->handleImage($image_th, $category->imagePath, $category->thumbFileName, null);
            }

            return $this->commitReturn($category);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /**
     * Updates a category.
     *
     * @param \App\Models\Category\Category $category
     * @param array                         $data
     * @param \App\Models\User\User         $user
     *
     * @return \App\Models\Category\Category|bool
     */
    public function updateFaunaCategory($category, $data, $user) {
        DB::beginTransaction();

        try {
            // More specific validation
            if (FaunaCategory::where('name', $data['name'])->where('id', '!=', $category->id)->exists()) {
                throw new \Exception('The name has already been taken.');
            }

            $data = $this->populateFaunaCategoryData($data, $category);

            $image = null;
            if (isset($data['image']) && $data['image']) {
                if (isset($category->image_extension)) {
                    $old = $category->imageFileName;
                } else {
                    $old = null;
                }
                $image = $data['image'];
                unset($data['image']);
            }
            if ($image) {
                $category->image_extension = $image->getClientOriginalExtension();
                $category->update();
                $this->handleImage($image, $category->imagePath, $category->imageFileName, $old);
            }

            $image_th = null;
            if (isset($data['image_th']) && $data['image_th']) {
                if (isset($category->thumb_extension)) {
                    $old_th = $category->thumbFileName;
                } else {
                    $old_th = null;
                }
                $image_th = $data['image_th'];
                unset($data['image_th']);
            }

            if ($image_th) {
                $category->thumb_extension = $image_th->getClientOriginalExtension();
                $category->update();
                $this->handleImage($image_th, $category->imagePath, $category->thumbFileName, $old_th);
            }
            $category->update($data);

            return $this->commitReturn($category);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /**
     * Deletes a category.
     *
     * @param \App\Models\Category\Category $category
     *
     * @return bool
     */
    public function deleteFaunaCategory($category) {
        DB::beginTransaction();

        try {
            if (isset($category->image_extension)) {
                $this->deleteImage($category->imagePath, $category->imageFileName);
            }
            if (isset($category->thumb_extension)) {
                $this->deleteImage($category->imagePath, $category->thumbFileName);
            }

            if (count($category->faunas)) {
                foreach ($category->faunas as $fauna) {
                    if (isset($fauna->image_extension)) {
                        $this->deleteImage($fauna->imagePath, $fauna->imageFileName);
                    }
                    if (isset($fauna->thumb_extension)) {
                        $this->deleteImage($fauna->imagePath, $fauna->thumbFileName);
                    }
                }
            }

            $category->delete();

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /**
     * Sorts category order.
     *
     * @param array $data
     *
     * @return bool
     */
    public function sortFaunaCategory($data) {
        DB::beginTransaction();

        try {
            // explode the sort array and reverse it since the order is inverted
            $sort = array_reverse(explode(',', $data));

            foreach ($sort as $key => $s) {
                FaunaCategory::where('id', $s)->update(['sort' => $key]);
            }

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /*
    |--------------------------------------------------------------------------
    | Faunas
    |--------------------------------------------------------------------------
    |
    */

    /**
     * Creates a new fauna.
     *
     * @param array                 $data
     * @param \App\Models\User\User $user
     *
     * @return \App\Models\Fauna\Category|bool
     */
    public function createFauna($data, $user) {
        DB::beginTransaction();

        try {
            $data = $this->populateFaunaData($data);

            $image = null;
            if (isset($data['image']) && $data['image']) {
                $image = $data['image'];
                unset($data['image']);
            }
            $image_th = null;
            if (isset($data['image_th']) && $data['image_th']) {
                $image_th = $data['image_th'];
                unset($data['image_th']);
            }

            $fauna = Fauna::create($data);

            if ($image) {
                $fauna->image_extension = $image->getClientOriginalExtension();
                $fauna->update();
                $this->handleImage($image, $fauna->imagePath, $fauna->imageFileName, null);
            }
            if ($image_th) {
                $fauna->thumb_extension = $image_th->getClientOriginalExtension();
                $fauna->update();
                $this->handleImage($image_th, $fauna->imagePath, $fauna->thumbFileName, null);
            }

            return $this->commitReturn($fauna);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /**
     * Updates a fauna.
     *
     * @param Fauna                 $fauna
     * @param array                 $data
     * @param \App\Models\User\User $user
     *
     * @return bool|Fauna
     */
    public function updateFauna($fauna, $data, $user) {
        DB::beginTransaction();

        try {
            // More specific validation
            if (Fauna::where('name', $data['name'])->where('id', '!=', $fauna->id)->exists()) {
                throw new \Exception('The name has already been taken.');
            }

            (new WorldExpansionService)->updateAttachments($fauna, $data);

            $data = $this->populateFaunaData($data, $fauna);

            $image = null;
            if (isset($data['image']) && $data['image']) {
                if (isset($fauna->image_extension)) {
                    $old = $fauna->imageFileName;
                } else {
                    $old = null;
                }
                $image = $data['image'];
                unset($data['image']);
            }
            if ($image) {
                $fauna->image_extension = $image->getClientOriginalExtension();
                $fauna->update();
                $this->handleImage($image, $fauna->imagePath, $fauna->imageFileName, $old);
            }

            $image_th = null;
            if (isset($data['image_th']) && $data['image_th']) {
                if (isset($fauna->thumb_extension)) {
                    $old_th = $fauna->thumbFileName;
                } else {
                    $old_th = null;
                }
                $image_th = $data['image_th'];
                unset($data['image_th']);
            }

            if ($image_th) {
                $fauna->thumb_extension = $image_th->getClientOriginalExtension();
                $fauna->update();
                $this->handleImage($image_th, $fauna->imagePath, $fauna->thumbFileName, $old_th);
            }

            $fauna->update($data);

            return $this->commitReturn($fauna);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /**
     * Deletes a fauna.
     *
     * @param Fauna $fauna
     *
     * @return bool
     */
    public function deleteFauna($fauna) {
        DB::beginTransaction();

        try {
            if (isset($fauna->image_extension)) {
                $this->deleteImage($fauna->imagePath, $fauna->imageFileName);
            }
            if (isset($fauna->thumb_extension)) {
                $this->deleteImage($fauna->imagePath, $fauna->thumbFileName);
            }
            $fauna->delete();

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /**
     * Sorts category order.
     *
     * @param array $data
     *
     * @return bool
     */
    public function sortFauna($data) {
        DB::beginTransaction();

        try {
            // explode the sort array and reverse it since the order is inverted
            $sort = array_reverse(explode(',', $data));

            foreach ($sort as $key => $s) {
                Fauna::where('id', $s)->update(['sort' => $key]);
            }

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /**
     * Creates a new flora category.
     *
     * @param array                 $data
     * @param \App\Models\User\User $user
     *
     * @return \App\Models\Flora\Category|bool
     */
    public function createFloraCategory($data, $user) {
        DB::beginTransaction();

        try {
            $data = $this->populateFloraCategoryData($data);

            $image = null;
            if (isset($data['image']) && $data['image']) {
                $image = $data['image'];
                unset($data['image']);
            }
            $image_th = null;
            if (isset($data['image_th']) && $data['image_th']) {
                $image_th = $data['image_th'];
                unset($data['image_th']);
            }

            $category = FloraCategory::create($data);

            if ($image) {
                $category->image_extension = $image->getClientOriginalExtension();
                $category->update();
                $this->handleImage($image, $category->imagePath, $category->imageFileName, null);
            }
            if ($image_th) {
                $category->thumb_extension = $image_th->getClientOriginalExtension();
                $category->update();
                $this->handleImage($image_th, $category->imagePath, $category->thumbFileName, null);
            }

            return $this->commitReturn($category);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /**
     * Updates a category.
     *
     * @param \App\Models\Category\Category $category
     * @param array                         $data
     * @param \App\Models\User\User         $user
     *
     * @return \App\Models\Category\Category|bool
     */
    public function updateFloraCategory($category, $data, $user) {
        DB::beginTransaction();

        try {
            // More specific validation
            if (FloraCategory::where('name', $data['name'])->where('id', '!=', $category->id)->exists()) {
                throw new \Exception('The name has already been taken.');
            }

            $data = $this->populateFloraCategoryData($data, $category);

            $image = null;
            if (isset($data['image']) && $data['image']) {
                if (isset($category->image_extension)) {
                    $old = $category->imageFileName;
                } else {
                    $old = null;
                }
                $image = $data['image'];
                unset($data['image']);
            }
            if ($image) {
                $category->image_extension = $image->getClientOriginalExtension();
                $category->update();
                $this->handleImage($image, $category->imagePath, $category->imageFileName, $old);
            }

            $image_th = null;
            if (isset($data['image_th']) && $data['image_th']) {
                if (isset($category->thumb_extension)) {
                    $old_th = $category->thumbFileName;
                } else {
                    $old_th = null;
                }
                $image_th = $data['image_th'];
                unset($data['image_th']);
            }

            if ($image_th) {
                $category->thumb_extension = $image_th->getClientOriginalExtension();
                $category->update();
                $this->handleImage($image_th, $category->imagePath, $category->thumbFileName, $old_th);
            }
            $category->update($data);

            return $this->commitReturn($category);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /**
     * Deletes a category.
     *
     * @param \App\Models\Category\Category $category
     *
     * @return bool
     */
    public function deleteFloraCategory($category) {
        DB::beginTransaction();

        try {
            if (isset($category->image_extension)) {
                $this->deleteImage($category->imagePath, $category->imageFileName);
            }
            if (isset($category->thumb_extension)) {
                $this->deleteImage($category->imagePath, $category->thumbFileName);
            }
            if (count($category->floras)) {
                foreach ($category->floras as $flora) {
                    if (isset($flora->image_extension)) {
                        $this->deleteImage($flora->imagePath, $flora->imageFileName);
                    }
                    if (isset($flora->thumb_extension)) {
                        $this->deleteImage($flora->imagePath, $flora->thumbFileName);
                    }
                }
            }
            $category->delete();

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /**
     * Sorts category order.
     *
     * @param array $data
     *
     * @return bool
     */
    public function sortFloraCategory($data) {
        DB::beginTransaction();

        try {
            // explode the sort array and reverse it since the order is inverted
            $sort = array_reverse(explode(',', $data));

            foreach ($sort as $key => $s) {
                FloraCategory::where('id', $s)->update(['sort' => $key]);
            }

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /*
    |--------------------------------------------------------------------------
    | Floras
    |--------------------------------------------------------------------------
    |
    */

    /**
     * Creates a new flora.
     *
     * @param array                 $data
     * @param \App\Models\User\User $user
     *
     * @return \App\Models\Flora\Category|bool
     */
    public function createFlora($data, $user) {
        DB::beginTransaction();

        try {
            $data = $this->populateFloraData($data);

            $image = null;
            if (isset($data['image']) && $data['image']) {
                $image = $data['image'];
                unset($data['image']);
            }
            $image_th = null;
            if (isset($data['image_th']) && $data['image_th']) {
                $image_th = $data['image_th'];
                unset($data['image_th']);
            }

            $flora = Flora::create($data);

            if ($image) {
                $flora->image_extension = $image->getClientOriginalExtension();
                $flora->update();
                $this->handleImage($image, $flora->imagePath, $flora->imageFileName, null);
            }
            if ($image_th) {
                $flora->thumb_extension = $image_th->getClientOriginalExtension();
                $flora->update();
                $this->handleImage($image_th, $flora->imagePath, $flora->thumbFileName, null);
            }

            return $this->commitReturn($flora);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /**
     * Updates a flora.
     *
     * @param Flora                 $flora
     * @param array                 $data
     * @param \App\Models\User\User $user
     *
     * @return bool|Flora
     */
    public function updateFlora($flora, $data, $user) {
        DB::beginTransaction();

        try {
            // More specific validation
            if (Flora::where('name', $data['name'])->where('id', '!=', $flora->id)->exists()) {
                throw new \Exception('The name has already been taken.');
            }

            (new WorldExpansionService)->updateAttachments($flora, $data);

            $data = $this->populateFloraData($data, $flora);

            $image = null;
            if (isset($data['image']) && $data['image']) {
                if (isset($flora->image_extension)) {
                    $old = $flora->imageFileName;
                } else {
                    $old = null;
                }
                $image = $data['image'];
                unset($data['image']);
            }
            if ($image) {
                $flora->image_extension = $image->getClientOriginalExtension();
                $flora->update();
                $this->handleImage($image, $flora->imagePath, $flora->imageFileName, $old);
            }

            $image_th = null;
            if (isset($data['image_th']) && $data['image_th']) {
                if (isset($flora->thumb_extension)) {
                    $old_th = $flora->thumbFileName;
                } else {
                    $old_th = null;
                }
                $image_th = $data['image_th'];
                unset($data['image_th']);
            }

            if ($image_th) {
                $flora->thumb_extension = $image_th->getClientOriginalExtension();
                $flora->update();
                $this->handleImage($image_th, $flora->imagePath, $flora->thumbFileName, $old_th);
            }

            $flora->update($data);

            return $this->commitReturn($flora);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /**
     * Deletes a flora.
     *
     * @param Flora $flora
     *
     * @return bool
     */
    public function deleteFlora($flora) {
        DB::beginTransaction();

        try {
            if (isset($flora->image_extension)) {
                $this->deleteImage($flora->imagePath, $flora->imageFileName);
            }
            if (isset($flora->thumb_extension)) {
                $this->deleteImage($flora->imagePath, $flora->thumbFileName);
            }
            $flora->delete();

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /**
     * Sorts category order.
     *
     * @param array $data
     *
     * @return bool
     */
    public function sortFlora($data) {
        DB::beginTransaction();

        try {
            // explode the sort array and reverse it since the order is inverted
            $sort = array_reverse(explode(',', $data));

            foreach ($sort as $key => $s) {
                Flora::where('id', $s)->update(['sort' => $key]);
            }

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /**
     * Processes user input for creating/updating a category.
     *
     * @param array                         $data
     * @param \App\Models\Category\Category $category
     *
     * @return array
     */
    private function populateFaunaCategoryData($data, $category = null) {
        if (isset($data['description']) && $data['description']) {
            $data['parsed_description'] = parse($data['description']);
        }
        if (isset($data['name']) && $data['name']) {
            $data['name'] = parse($data['name']);
        }

        if (isset($data['remove_image'])) {
            if ($category && isset($category->image_extension) && $data['remove_image']) {
                $data['image_extension'] = null;
                $this->deleteImage($category->imagePath, $category->imageFileName);
            }
            unset($data['remove_image']);
        }

        if (isset($data['remove_image_th']) && $data['remove_image_th']) {
            if ($category && isset($category->thumb_extension) && $data['remove_image_th']) {
                $data['thumb_extension'] = null;
                $this->deleteImage($category->imagePath, $category->thumbFileName);
            }
            unset($data['remove_image_th']);
        }

        return $data;
    }

    /**
     * Processes user input for creating/updating a fauna.
     *
     * @param array $data
     * @param Fauna $fauna
     *
     * @return array
     */
    private function populateFaunaData($data, $fauna = null) {
        $saveData['description'] = $data['description'] ?? null;
        if (isset($data['description']) && $data['description']) {
            $saveData['parsed_description'] = parse($data['description']);
        }
        $saveData['summary'] = $data['summary'] ?? null;

        if (isset($data['name']) && $data['name']) {
            $saveData['name'] = parse($data['name']);
        }
        if (isset($data['scientific_name']) && $data['scientific_name']) {
            $saveData['scientific_name'] = parse($data['scientific_name']);
        }

        $saveData['is_active'] = isset($data['is_active']);
        $saveData['category_id'] = isset($data['category_id']) && $data['category_id'] ? $data['category_id'] : null;

        $saveData['image'] = $data['image'] ?? null;
        $saveData['image_th'] = $data['image_th'] ?? null;

        if (isset($data['remove_image'])) {
            if ($fauna && isset($fauna->image_extension) && $data['remove_image']) {
                $saveData['image_extension'] = null;
                $this->deleteImage($fauna->imagePath, $fauna->imageFileName);
            }
            unset($data['remove_image']);
        }

        if (isset($data['remove_image_th']) && $data['remove_image_th']) {
            if ($fauna && isset($fauna->thumb_extension) && $data['remove_image_th']) {
                $saveData['thumb_extension'] = null;
                $this->deleteImage($fauna->imagePath, $fauna->thumbFileName);
            }
            unset($data['remove_image_th']);
        }

        return $saveData;
    }

    /**
     * Processes user input for creating/updating a category.
     *
     * @param array                         $data
     * @param \App\Models\Category\Category $category
     *
     * @return array
     */
    private function populateFloraCategoryData($data, $category = null) {
        if (isset($data['description']) && $data['description']) {
            $data['parsed_description'] = parse($data['description']);
        }
        if (isset($data['name']) && $data['name']) {
            $data['name'] = parse($data['name']);
        }

        if (isset($data['remove_image'])) {
            if ($category && isset($category->image_extension) && $data['remove_image']) {
                $data['image_extension'] = null;
                $this->deleteImage($category->imagePath, $category->imageFileName);
            }
            unset($data['remove_image']);
        }

        if (isset($data['remove_image_th']) && $data['remove_image_th']) {
            if ($category && isset($category->thumb_extension) && $data['remove_image_th']) {
                $data['thumb_extension'] = null;
                $this->deleteImage($category->imagePath, $category->thumbFileName);
            }
            unset($data['remove_image_th']);
        }

        return $data;
    }

    /**
     * Processes user input for creating/updating a flora.
     *
     * @param array $data
     * @param Flora $flora
     *
     * @return array
     */
    private function populateFloraData($data, $flora = null) {
        $saveData['description'] = $data['description'] ?? null;
        if (isset($data['description']) && $data['description']) {
            $saveData['parsed_description'] = parse($data['description']);
        }
        $saveData['summary'] = $data['summary'] ?? null;

        if (isset($data['scientific_name']) && $data['scientific_name']) {
            $saveData['scientific_name'] = parse($data['scientific_name']);
        }
        if (isset($data['name']) && $data['name']) {
            $saveData['name'] = parse($data['name']);
        }

        $saveData['is_active'] = isset($data['is_active']);
        $saveData['category_id'] = isset($data['category_id']) && $data['category_id'] ? $data['category_id'] : null;

        $saveData['image'] = $data['image'] ?? null;
        $saveData['image_th'] = $data['image_th'] ?? null;

        if (isset($data['remove_image'])) {
            if ($flora && isset($flora->image_extension) && $data['remove_image']) {
                $saveData['image_extension'] = null;
                $this->deleteImage($flora->imagePath, $flora->imageFileName);
            }
            unset($data['remove_image']);
        }

        if (isset($data['remove_image_th']) && $data['remove_image_th']) {
            if ($flora && isset($flora->thumb_extension) && $data['remove_image_th']) {
                $saveData['thumb_extension'] = null;
                $this->deleteImage($flora->imagePath, $flora->thumbFileName);
            }
            unset($data['remove_image_th']);
        }

        return $saveData;
    }
}
