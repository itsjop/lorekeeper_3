<?php

namespace App\Http\Controllers\Users;

// use Auth;
use Illuminate\Support\Facades\Auth;

use File;
use Image;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use App\Models\User\UserAlias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Notification;
use App\Services\UserService;
use App\Services\LinkService;
use App\Models\Border\Border;
use App\Models\WorldExpansion\Faction;
use App\Models\WorldExpansion\Location;
use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Collection;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;
use Laravel\Fortify\RecoveryCode;
use Settings;

class AccountController extends Controller {
  /*
    |--------------------------------------------------------------------------
    | Account Controller
    |--------------------------------------------------------------------------
    |
    | Handles the user's account management.
    |
     */

  /**
   * Shows the banned page, or redirects the user to the home page if they aren't banned.
   *
   * @return \Illuminate\Contracts\Support\Renderable|\Illuminate\Http\RedirectResponse
   */
  public function getBanned() {
    if (Auth::user()->is_banned)
      return view('account.banned');
    else
      return redirect()->to('/');
  }



  /**
   * Shows the user settings page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getSettings() {
    $interval = array(
      0 => 'whenever',
      1 => 'yearly',
      2 => 'quarterly',
      3 => 'monthly',
      4 => 'weekly',
      5 => 'daily'
    );

    if (Auth::user()->isStaff) {
      $borderOptions =
        ['0' => 'Select Border'] + Border::base()->active(Auth::user() ?? null)
        ->where('is_default', 1)->get()->pluck('settingsName', 'id')->toArray() + Border::base()
        ->where('admin_only', 1)->get()->pluck('settingsName', 'id')->toArray();
    } else {
      $borderOptions =
        ['0' => 'Select Border'] + Border::base()->active(Auth::user() ?? null)
        ->where('is_default', 1)
        ->where('admin_only', 0)->get()->pluck('settingsName', 'id')->toArray();
    }

    $default = Border::base()->active(Auth::user() ?? null)->where('is_default', 1)->get();
    $admin = Border::base()->where('admin_only', 1)->get();

    return view('account.settings', [
      'user_enabled' => Settings::get('WE_user_factions'),
      'user_faction_enabled' => Settings::get('WE_user_factions'),
      'borders' => $borderOptions + Auth::user()->borders()->get()->pluck('settingsName', 'id')->toArray(),
      'default' => $default,
      'admin' => $admin,
      'border_variants' => ['0' => 'Pick a Border First'],
      'bottom_layers' => ['0' => 'Pick a Border First'],
    ]);
  }

  /**
   * Edits the user's profile.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postProfile(Request $request) {
    Auth::user()->profile->update([
      'text' => $request->get('text'),
      'parsed_text' => parse($request->get('text'))
    ]);
    flash('Profile updated successfully.')->success();
    return redirect()->back();
  }

  /**
   * Edits the user's avatar.
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postAvatar(Request $request, UserService $service) {
    if ($service->updateAvatar($request->file('avatar'), Auth::user())) {
      flash('Avatar updated successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) flash($error)->error();
    }
    return redirect()->back();
  }

  /**
   * Changes the user's password.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  App\Services\UserService  $service
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postPassword(Request $request, UserService $service) {
    $request->validate([
      'old_password' => 'required|string',
      'new_password' => 'required|string|min:8|confirmed'
    ]);
    if ($service->updatePassword($request->only(['old_password', 'new_password', 'new_password_confirmation']), Auth::user())) {
      flash('Password updated successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) flash($error)->error();
    }
    return redirect()->back();
  }

  /**
   * Changes the user's email address and sends a verification email.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  App\Services\UserService  $service
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postEmail(Request $request, UserService $service) {
    $request->validate([
      'email' => 'required|string|email|max:255|unique:users'
    ]);
    if ($service->updateEmail($request->only(['email']), Auth::user())) {
      flash('Email updated successfully. A verification email has been sent to your new email address.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) flash($error)->error();
    }
    return redirect()->back();
  }

  /**
   * Changes user character warning visibility setting.
   *
   * @param App\Services\UserService $service
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postWarningVisibility(Request $request, UserService $service) {
    if ($service->updateContentWarningVisibility($request->input('content_warning_visibility'), Auth::user())) {
      flash('Setting updated successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }
    }

    return redirect()->back();
  }

  /**
   * Changes user profile comment visibility setting.
   *
   * @param App\Services\UserService $service
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postProfileComments(Request $request, UserService $service) {
    if ($service->updateProfileCommentSetting($request->input('allow_profile_comments'), Auth::user())) {
      flash('Setting updated successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }
    }

    return redirect()->back();
  }
  /**
   * Shows the notifications page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getNotifications() {
    $notifications = Auth::user()->notifications()->orderBy('id', 'DESC')->paginate(30);
    Auth::user()
      ->notifications()
      ->update(['is_unread' => 0]);
    Auth::user()->notifications_unread = 0;
    Auth::user()->save();

    return view('account.notifications', [
      'notifications' => $notifications
    ]);
  }

  /**
   * Deletes a notification and returns a response.
   *
   * @return \Illuminate\Http\Response
   */
  public function getDeleteNotification($id) {
    $notification = Notification::where('id', $id)->where('user_id', Auth::user()->id)->first();
    if ($notification) $notification->delete();
    return response(200);
  }

  /**
   * Deletes all of the user's notifications.
   *
   * @param mixed|null $type
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postClearNotifications($type = null) {
    if (isset($type)) {
      Auth::user()->notifications()->where('notification_type_id', $type)->delete();
    } else {
      Auth::user()->notifications()->delete();
    }

    flash('Notifications cleared successfully.')->success();

    return redirect()->back();
  }

  /**
   * Shows the account links page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getAliases() {
    return view('account.aliases');
  }

  /**
   * Shows the make primary alias modal.
   *
   * @param mixed $id
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getMakePrimary($id) {
    return view('account._make_primary_modal', [
      'alias' => UserAlias::where('id', $id)
        ->where('user_id', Auth::user()->id)
        ->first()
    ]);
  }

  /**
   * Makes an alias the user's primary alias.
   *
   * @param mixed $id
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postMakePrimary(LinkService $service, $id) {
    if ($service->makePrimary($id, Auth::user())) {
      flash('Your primary alias has been changed successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }
    }

    return redirect()->back();
  }

  /**
   * Shows the hide alias modal.
   *
   * @param mixed $id
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getHideAlias($id) {
    return view('account._hide_alias_modal', [
      'alias' => UserAlias::where('id', $id)
        ->where('user_id', Auth::user()->id)
        ->first()
    ]);
  }

  /**
   * Hides or unhides the selected alias from public view.
   *
   * @param mixed $id
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postHideAlias(LinkService $service, $id) {
    if ($service->hideAlias($id, Auth::user())) {
      flash('Your alias\'s visibility setting has been changed successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }
    }

    return redirect()->back();
  }

  /**
   * Shows the remove alias modal.
   *
   * @param mixed $id
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getRemoveAlias($id) {
    return view('account._remove_alias_modal', [
      'alias' => UserAlias::where('id', $id)
        ->where('user_id', Auth::user()->id)
        ->first()
    ]);
  }

  /**
   * Removes the selected alias from the user's account.
   *
   * @param mixed $id
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postRemoveAlias(LinkService $service, $id) {
    if ($service->removeAlias($id, Auth::user())) {
      flash('Your alias has been removed successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }
    }

    return redirect()->back();
  }

  /**
   * Show a user's deactivate confirmation page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getDeactivate() {
    return view('account.deactivate');
  }

  /**
   * Show a user's deactivate confirmation page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getDeactivateConfirmation() {
    return view('account._deactivate_confirmation');
  }

  public function postDeactivate(Request $request, UserService $service) {
    $wasDeactivated = Auth::user()->is_deactivated;
    if (
      $service->deactivate(
        ['deactivate_reason' => $request->get('deactivate_reason')],
        Auth::user(),
        null
      )
    ) {
      flash(
        $wasDeactivated
          ? 'Deactivation reason edited successfully.'
          : 'Your account has successfully been deactivated. We hope to see you again and wish you the best!'
      )->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }
    }

    return redirect()->back();
  }

  /**
   * Show a user's reactivate confirmation page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getReactivateConfirmation() {
    return view('account._reactivate_confirmation');
  }

  public function postReactivate(Request $request, UserService $service) {
    if ($service->reactivate(Auth::user(), null)) {
      flash('You have reactivated successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }
    }

    return redirect()->back();
  }

  /**
   * Edits the user's border.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postBorder(Request $request, UserService $service) {
    if (
      $service->updateBorder(
        $request->only(
          'border',
          'border_variant_id',
          'bottom_border_id',
          'top_border_id',
          'border_flip'
        ),
        Auth::user()
      )
    ) {
      flash('Border updated successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }
    }
    return redirect()->back();
  }

  /**
   * Create (or remove) image block
   *
   */
  public function postBlockUnblockImage(Request $request, UserService $service, $model, $id) {
    if (!$service->blockUnblockImage($model, $id, Auth::user())) {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }
    }

    return redirect()->back();
  }

  /**
   * Get a page of all the user's blocked images.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getImageBlocks(Request $request) {
    $query = Auth::user()->blockedImages()->with('object');

    $name = $request->get('name');
    if ($name) $query->whereRelation('object', 'name',  'LIKE', '%' . $name . '%');

    switch ($request->get('sort')) {
      case 'desc':
        $query->orderBy('id', 'DESC');
        break;
      case 'asc':
        $query->orderBy('id', 'ASC');
        break;
      default:
        $query->orderBy('id', 'DESC');
        break;
    }

    return view('account.blocked_images', [
      'images' => $query->paginate(20)->appends($request->query()),
    ]);
  }

  /**
   * Changes user's image  block setting
   *
   * @param App\Services\UserService $service
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postImageBlockSettings(Request $request, UserService $service) {
    $data = $request->only(['show_image_blocks']);
    if ($service->updateImageBlockSetting($data, Auth::user())) {
      flash('Image block setting updated successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }
    }

    return redirect()->back();
  }
  /**
   * Get applicable variants
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getBorderVariants(Request $request) {
    $border = $request->input('border');

    if (
      Border::where('parent_id', '=', $border)
      ->where('border_type', 'variant')
      ->active(Auth::user() ?? null)
      ->count()
    ) {
      $border_variants =
        ['0' => 'Select Border Variant'] +
        Border::where('parent_id', '=', $border)
        ->where('border_type', 'variant')
        ->active(Auth::user() ?? null)
        ->get()
        ->pluck('settingsName', 'id')
        ->toArray();
    } else {
      $border_variants = ['0' => 'None Available'];
    }

    return view('account.border_variants', [
      'border_variants' => $border_variants
    ]);
  }

  /**
   * Get applicable layers
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getBorderLayers(Request $request) {
    $border = $request->input('border');

    $layeredborder = Border::find($border);
    if (
      !$layeredborder ||
      !$layeredborder->topLayers()->count() ||
      !$layeredborder->bottomLayers()->count()
    ) {
      $bottom_layers = ['0' => 'None Available'];
      $top_layers = ['0' => 'None Available'];
    }

    return view('account.border_layers', [
      'top_layers' =>
      $top_layers ??
        ['0' => 'Select Top Layer'] +
        Border::where('parent_id', '=', $border)
        ->where('border_type', 'top')
        ->active(Auth::user() ?? null)
        ->get()
        ->pluck('settingsName', 'id')
        ->toArray(),
      'bottom_layers' =>
      $bottom_layers ??
        ['0' => 'Select Bottom Layer'] +
        Border::where('parent_id', '=', $border)
        ->where('border_type', 'bottom')
        ->active(Auth::user() ?? null)
        ->get()
        ->pluck('settingsName', 'id')
        ->toArray()
    ]);
  }

  /**
   * Change if the user's characters can be liked
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  App\Services\UserService  $service
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postAllowCharacterLikes(Request $request, UserService $service) {
    if ($service->updateAllowCharacterLikes($request->input('allow_character_likes'), Auth::user())) {
      flash('Like status updated successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) flash($error)->error();
    }
    return redirect()->back();
  }
}
