<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Forms\SiteForm;
use App\Services\SiteFormService;

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
        if(Auth::user() && Auth::user()->isStaff){
            return view('forms.index', ['forms' => SiteForm::orderBy('updated_at', 'DESC')->paginate(10)]);
        } else {
            return view('forms.index', ['forms' => SiteForm::visible()->orderBy('updated_at', 'DESC')->paginate(10)]);
        }
    }
    
    /**
     * Shows a form post.
     *
     * @param  int          $id
     * @param  string|null  $slug
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getSiteForm(Request $request, $id, $slug = null)
    {
        $form = SiteForm::where('id', $id)->visible()->first();
        if(!$form) abort(404);
        return view('forms.site_form', [
            'form' => $form, 
            'user' => Auth::user(),
            'edit' => isset($request['edit']) ? $request['edit'] : null
        ]);
    }

        
    /**
     * Posts a form and saves the response of the user.
     *
     * @param  int          $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postSiteForm(Request $request, SiteFormService $service, $id)
    {
        $form = SiteForm::where('id', $id)->first();
        if(!$form) abort(404);
        if(!Auth::user()) abort(403);

        if($service->postSiteForm( $form , $request->all(), Auth::user())) {
            flash('Form posted successfully.')->success();
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        $back = strtok(redirect()->back()->getTargetUrl(), '?');
        return redirect($back);
    }
}
