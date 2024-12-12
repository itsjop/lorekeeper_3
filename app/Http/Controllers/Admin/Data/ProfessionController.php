<?php

namespace App\Http\Controllers\Admin\Data;

use Illuminate\Http\Request;

use Auth;

use App\Models\Profession\ProfessionCategory;
use App\Models\Profession\ProfessionSubcategory;
use App\Models\Profession\Profession;
use App\Models\Rarity;
use App\Models\Species\Species;
use App\Models\Species\Subtype;

use App\Services\ProfessionService;

use App\Http\Controllers\Controller;

class ProfessionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin / Profession Controller
    |--------------------------------------------------------------------------
    |
    | Handles creation/editing of character profession categories and professions 
    | 
    |
    */

    /**********************************************************************************************
    
        PROFESSION CATEGORIES

    **********************************************************************************************/

    /**
     * Shows the profession category index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCategoryIndex()
    {
        return view('admin.professions.profession_categories', [
            'categories' => ProfessionCategory::orderBy('sort', 'DESC')->get()
        ]);
    }
    
    /**
     * Shows the create profession category page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCreateProfessionCategory()
    {
        return view('admin.professions.create_edit_profession_category', [
            'category' => new ProfessionCategory,
            'specieses' => ['none' => 'Any Species'] + Species::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
        ]);
    }
    
    /**
     * Shows the edit profession category page.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getEditProfessionCategory($id)
    {
        $category = ProfessionCategory::find($id);
        if(!$category) abort(404);
        return view('admin.professions.create_edit_profession_category', [
            'category' => $category,
            'specieses' => ['none' => 'No restriction'] + Species::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),

        ]);
    }

    /**
     * Creates or edits a profession category.
     *
     * @param  \Illuminate\Http\Request     $request
     * @param  App\Services\ProfessionService  $service
     * @param  int|null                     $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreateEditProfessionCategory(Request $request, ProfessionService $service, $id = null)
    {
        $id ? $request->validate(ProfessionCategory::$updateRules) : $request->validate(ProfessionCategory::$createRules);
        $data = $request->only([
            'name', 'description', 'image', 'remove_image', 'species_id'
        ]);
        if($id && $service->updateProfessionCategory(ProfessionCategory::find($id), $data, Auth::user())) {
            flash('Category updated successfully.')->success();
        }
        else if (!$id && $category = $service->createProfessionCategory($data, Auth::user())) {
            flash('Category created successfully.')->success();
            return redirect()->to('admin/data/profession-categories/edit/'.$category->id);
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }
    
    /**
     * Gets the profession category deletion modal.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getDeleteProfessionCategory($id)
    {
        $category = ProfessionCategory::find($id);
        return view('admin.professions._delete_profession_category', [
            'category' => $category,
        ]);
    }

    /**
     * Creates or edits a profession category.
     *
     * @param  \Illuminate\Http\Request     $request
     * @param  App\Services\ProfessionService  $service
     * @param  int|null                     $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeleteProfessionCategory(Request $request, ProfessionService $service, $id)
    {
        if($id && $service->deleteProfessionCategory(ProfessionCategory::find($id))) {
            flash('Category deleted successfully.')->success();
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->to('admin/data/profession-categories');
    }

    /**
     * Sorts profession categories.
     *
     * @param  \Illuminate\Http\Request     $request
     * @param  App\Services\ProfessionService  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSortProfessionCategory(Request $request, ProfessionService $service)
    {
        if($service->sortProfessionCategory($request->get('sort'))) {
            flash('Category order updated successfully.')->success();
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }

    /**********************************************************************************************
    
        PROFESSION SUBCATEGORIES

    **********************************************************************************************/

    /**
     * Shows the profession subcategories index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getSubcategoryIndex()
    {
        return view('admin.professions.profession_subcategories', [
            'subcategories' => ProfessionSubcategory::orderBy('sort', 'DESC')->get()
        ]);
    }
    
    /**
     * Shows the create profession subcategories page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCreateProfessionSubcategory()
    {
        return view('admin.professions.create_edit_profession_subcategory', [
            'subcategory' => new ProfessionSubcategory,
            'subcategories' => ['none' => 'No category'] + ProfessionSubcategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
            'categories' => ['none' => 'No category'] + ProfessionCategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray()
        ]);
    }
    
    /**
     * Shows the edit profession subcategories page.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getEditProfessionSubcategory($id)
    {
        $category = ProfessionSubcategory::find($id);
        if(!$category) abort(404);
        return view('admin.professions.create_edit_profession_subcategory', [
            'subcategory' => $category,
            'categories' => ['none' => 'No category'] + ProfessionCategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray()
        ]);
    }

    /**
     * Creates or edits a profession subcategories.
     *
     * @param  \Illuminate\Http\Request     $request
     * @param  App\Services\ProfessionService  $service
     * @param  int|null                     $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreateEditProfessionSubcategory(Request $request, ProfessionService $service, $id = null)
    {
        $id ? $request->validate(ProfessionSubcategory::$updateRules) : $request->validate(ProfessionSubcategory::$createRules);
        $data = $request->only([
            'name', 'description', 'image', 'remove_image', 'category_id'
        ]);
        if($id && $service->updateProfessionSubcategory(ProfessionSubcategory::find($id), $data, Auth::user())) {
            flash('Category updated successfully.')->success();
        }
        else if (!$id && $category = $service->createProfessionSubcategory($data, Auth::user())) {
            flash('Category created successfully.')->success();
            return redirect()->to('admin/data/profession-subcategories/edit/'.$category->id);
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }
    
    /**
     * Gets the profession subcategories deletion modal.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getDeleteProfessionSubcategory($id)
    {
        $category = ProfessionSubcategory::find($id);
        return view('admin.professions._delete_profession_subcategory', [
            'subcategory' => $category,
        ]);
    }

    /**
     * Creates or edits a profession subcategories.
     *
     * @param  \Illuminate\Http\Request     $request
     * @param  App\Services\ProfessionService  $service
     * @param  int|null                     $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeleteProfessionSubcategory(Request $request, ProfessionService $service, $id)
    {
        if($id && $service->deleteProfessionSubcategory(ProfessionSubcategory::find($id))) {
            flash('Category deleted successfully.')->success();
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->to('admin/data/profession-subcategories');
    }

    /**
     * Sorts profession subcategories.
     *
     * @param  \Illuminate\Http\Request     $request
     * @param  App\Services\ProfessionService  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSortProfessionSubcategory(Request $request, ProfessionService $service)
    {
        if($service->sortProfessionSubcategory($request->get('sort'))) {
            flash('Category order updated successfully.')->success();
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }

    /**********************************************************************************************
    
        PROFESSIONS

    **********************************************************************************************/

    /**
     * Shows the profession index.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getProfessionIndex(Request $request)
    {
        $query = Profession::query();
        $data = $request->only(['subcategory_id', 'category_id', 'name']);
        if(isset($data['subcategory_id']) && $data['subcategory_id'] != 'none') 
            $query->where('subcategory_id', $data['subcategory_id']);
        if(isset($data['category_id']) && $data['category_id'] != 'none') 
            $query->where('category_id', $data['category_id']);
        if(isset($data['name'])) 
            $query->where('name', 'LIKE', '%'.$data['name'].'%');
        return view('admin.professions.professions', [
            'professions' => $query->orderBy('category_id', 'ASC')->orderBy('sort', 'DESC')->get(),
            'categories' => ['none' => 'Any Category'] + ProfessionCategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
            'subcategories' => ['none' => 'Any subcategory'] + ProfessionSubcategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray()
        ]);
    }
    
    /**
     * Shows the create profession page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCreateProfession()
    {
        return view('admin.professions.create_edit_profession', [
            'profession' => new Profession,
            'categories' => ['none' => 'No category'] + ProfessionCategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
            'subcategories' => ['none' => 'No subcategory'] + ProfessionSubcategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray()
        ]);
    }
    
    /**
     * Shows the edit profession page.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getEditProfession($id)
    {
        $profession = Profession::find($id);
        if(!$profession) abort(404);
        return view('admin.professions.create_edit_profession', [
            'profession' => $profession,
            'categories' => ['none' => 'No category'] + ProfessionCategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
            'subcategories' => ['none' => 'No category'] + ProfessionSubcategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray()
        ]);
    }

    /**
     * Creates or edits a profession.
     *
     * @param  \Illuminate\Http\Request     $request
     * @param  App\Services\ProfessionService  $service
     * @param  int|null                     $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreateEditProfession(Request $request, ProfessionService $service, $id = null)
    {
        $id ? $request->validate(Profession::$updateRules) : $request->validate(Profession::$createRules);
        $data = $request->only([
            'name', 'category_id','subcategory_id', 'description', 'image', 'image_icon', 'remove_image', 'remove_image_icon', 'is_active', 'is_choosable'
        ]);
        if($id && $service->updateProfession(Profession::find($id), $data, Auth::user())) {
            flash('Profession updated successfully.')->success();
        }
        else if (!$id && $profession = $service->createProfession($data, Auth::user())) {
            flash('Profession created successfully.')->success();
            return redirect()->to('admin/data/professions/edit/'.$profession->id);
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }
    
    /**
     * Gets the profession deletion modal.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getDeleteProfession($id)
    {
        $profession = Profession::find($id);
        return view('admin.professions._delete_profession', [
            'profession' => $profession,
        ]);
    }


    /**
     * Deletes a profession.
     *
     * @param  \Illuminate\Http\Request     $request
     * @param  App\Services\ProfessionService  $service
     * @param  int                          $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeleteProfession(Request $request, ProfessionService $service, $id)
    {
        if($id && $service->deleteProfession(Profession::find($id))) {
            flash('Profession deleted successfully.')->success();
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->to('admin/data/professions');
    }

    /**
     * Sorts profession.
     *
     * @param  \Illuminate\Http\Request     $request
     * @param  App\Services\ProfessionService  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSortProfession(Request $request, ProfessionService $service)
    {
        if($service->sortProfession($request->get('sort'))) {
            flash('Profession order updated successfully.')->success();
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }
}
