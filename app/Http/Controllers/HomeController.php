<?php

namespace App\Http\Controllers;

use App\Models\Gallery\GallerySubmission;
use App\Models\Character\Sublist;

use Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Character\Character;
use App\Models\Sales\Sales;
use App\Models\News;
use App\Models\SitePage;
use App\Models\Species\Species;
use App\Models\Character\CharacterImage;
use App\Services\LinkService;
use App\Services\UserService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class HomeController extends Controller {
  /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | Displays the homepage and handles redirection for linking a user's social media account.
    |
    */

  /**
   * Shows the homepage.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getIndex() {
    if (Settings::get('featured_character')) {
      $character = Character::find(Settings::get('featured_character'));
    } else {
      $character = null;
    }

    // Fetch the 8 most recent Submissions
    $query = GallerySubmission::visible(Auth::user() ?? null)->accepted()->orderBy('created_at', 'DESC');
    $gallerySubmissions = $query->get()->take(8);

    // Fetch the 8 most recent MYOs
    // (not currently working)
    $myos = Character::visible()->where('character_category_id', 3)->orderBy('number', 'DESC')->get()->take(4);

    return view('welcome', [
      'about'               => SitePage::where('key', 'about')->first(),
      'gallerySubmissions'  => $gallerySubmissions,
      'saleses'             => Sales::visible()->orderBy('id', 'DESC')->take(1)->get(),
      'featured'            => $character,
      'newses'              => News::visible()->orderBy('updated_at', 'DESC')->take(2)->get(),
      'myos'                => $myos,
    ]);
  }

  /**
   * Gets random character from specified species.
   *
   * @param int (species_id) $species
   */
  public function randomCharacter(int $species) {
    $query = Character::with('user.rank')->with('image.features')->with('rarity')->with('image.species')->myo(0)->where(function ($query) {
      $query->where('is_gift_art_allowed', '>=', 1)
        ->orWhere('is_gift_writing_allowed', '>=', 1);
    });
    $imageQuery = CharacterImage::images(Auth::user() ?? null)->with('features')->with('rarity')->with('species')->where('species_id', $species)->whereIn('id', $query->pluck('character_image_id')->toArray());

    $query->whereIn('id', $imageQuery->pluck('character_id')->toArray());

    if (!Auth::check() || !Auth::user()->hasPower('manage_characters')) {
      $query->visible();
    }

    $allCharacters = $query->get();

    if (!count($allCharacters)) {
      return false;
    }

    return $allCharacters->random();
  }

  /**
   * Shows the account linking page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getLink(Request $request) {
    // If the user already has a username associated with their account, redirect them
    if (Auth::check() && Auth::user()->hasAlias) {
      redirect()->to('home');
    }

    // Display the login link
    return view('auth.link');
  }

  /**
   * Redirects to the appropriate provider.
   *
   * @param string $provider
   */
  public function getAuthRedirect(LinkService $service, $provider) {
    if (!$this->checkProvider($provider, Auth::user())) {
      flash($this->error)->error();

      return redirect()->to(Auth::user()->has_alias ? 'account/aliases' : 'link');
    }

    // Redirect to the provider's authentication page
    return $service->getAuthRedirect($provider); //Socialite::driver($provider)->redirect();
  }

  /**
   * Redirects to the appropriate provider.
   *
   * @param string $provider
   */
  public function getAuthCallback(LinkService $service, $provider) {
    if (!$this->checkProvider($provider, Auth::user())) {
      flash($this->error)->error();

      return redirect()->to(Auth::user()->has_alias ? 'account/aliases' : 'link');
    }

    // Toyhouse runs on Laravel Passport for OAuth2 and this has some issues with state exceptions,
    // admin suggested the easy fix (to use stateless)
    $result =
      $provider == 'toyhouse'
      ? Socialite::driver($provider)->stateless()->user()
      : Socialite::driver($provider)->user();
    if ($service->saveProvider($provider, $result, Auth::user())) {
      flash('Account has been linked successfully.')->success();
      Auth::user()->updateCharacters();
      Auth::user()->updateArtDesignCredits();

      return redirect()->to('account/aliases');
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }

      return redirect()->to(Auth::user()->has_alias ? 'account/aliases' : 'link');
    }

    return redirect()->to('/');
  }

  /**
   * Shows the email page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getEmail(Request $request) {
    // If the user already has an email associated with their account, redirect them
    if (Auth::check() && Auth::user()->hasEmail) {
      return redirect()->to('home');
    }

    // Step 1: display a login email
    return view('auth.email');
  }

  /**
   * Posts the email page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function postEmail(UserService $service, Request $request) {
    $data = $request->input('email');
    if ($service->updateEmail(['email' => $data], Auth::user())) {
      flash('Email added successfully!');

      return redirect()->to('home');
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }

      return redirect()->back();
    }
  }

  /**
   * Shows the birthdaying page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getBirthday(Request $request) {
    // If the user already has a username associated with their account, redirect them
    if (Auth::check() && Auth::user()->birthday) {
      return redirect()->to('/');
    }

    // Step 1: display a login birthday
    return view('auth.birthday');
  }

  /**
   * Posts the birthdaying page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function postBirthday(Request $request) {
    $service = new UserService();
    // Make birthday into format we can store
    $data = $request->input('dob');

    if ($service->updateBirthday($data, Auth::user())) {
      flash('Birthday added successfully!');

      return redirect()->to('/');
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }

      return redirect()->back();
    }
  }

  /**
   * Shows the birthdaying page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getBirthdayBlocked(Request $request) {
    // If the user already has a username associated with their account, redirect them
    if (Auth::check() && Auth::user()->checkBirthday) {
      return redirect()->to('/');
    }

    if (Auth::check() && !Auth::user()->birthday) {
      return redirect()->to('birthday');
    }

    // Step 1: display a login birthday
    return view('auth.blocked');
  }

  private function checkProvider($provider, $user) {
    // Check if the site can be used for authentication
    $isAllowed = false;
    foreach (config('lorekeeper.sites') as $key => $site) {
      if ($key == $provider && isset($site['auth'])) {
        // require a primary alias if the user does not already have one
        if (
          !Auth::user()->has_alias &&
          (!isset($site['primary_alias']) || !$site['primary_alias'])
        ) {
          $this->error =
            'The site you selected cannot be used as your primary alias (means of identification). Please choose a different site to link.';

          return false;
        }

        $isAllowed = true;
        break;
      }
    }
    if (!$isAllowed) {
      $this->error =
        'The site you selected cannot be linked with your account. Please contact an administrator if this is in error!';

      return false;
    }

    // I think there's no harm in linking multiple of the same site as people may want their activity separated into an ARPG account.
    // Uncomment the following to restrict to one account per site, however.
    // Check if the user already has a username associated with their account
    // if(DB::table('user_aliases')->where('site', $provider)->where('user_id', $user->id)->exists()) {
    //    $this->error = 'You already have a username associated with this website linked to your account.';
    //    return false;
    // }

    return true;
  }
}
