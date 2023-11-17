<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Forms\SiteForm;

class SiteFormController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SiteForm Controller
    |--------------------------------------------------------------------------
    |
    | Displays form and poll posts.
    |
    */

    /**
     * Shows the form index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getIndex()
    {
        return view('forms.index', ['forms' => SiteForm::visible()->orderBy('updated_at', 'DESC')->paginate(10)]);
    }
    
    /**
     * Shows a form post.
     *
     * @param  int          $id
     * @param  string|null  $slug
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getSiteForm($id, $slug = null)
    {
        $form = SiteForm::where('id', $id)->visible()->first();
        if(!$form) abort(404);
        return view('forms.site_form', ['form' => $form]);
    }
}
