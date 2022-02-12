<?php

namespace App\Http\Controllers\Users;

use Auth;

use App\Models\User\User;
use App\Models\ModMail;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class ModMailController extends Controller
{
    /**
     * Shows the mod mail index
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getIndex()
    {
        if(!Auth::check()) abort(404);

        return view('home.mail_index', [
            'mails' => ModMail::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get()
        ]);
    }

    /**
     * Shows a specific mail
     * 
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getMail($id)
    {
        if(!Auth::check()) abort(404);
        $mail = ModMail::findOrFail($id);

        if(!$mail->seen) $mail->update(['seen' => 1]);

        return view('home.mail', [
            'mail' => $mail
        ]);
    }
}
