<?php

namespace App\Http\Controllers\Users;

use DB;
use Auth;
use Route;

use App\Facades\Settings;
use App\Http\Controllers\Controller;
use App\Models\Character\Character;
use App\Models\Character\CharacterImage;
use App\Models\Character\Sublist;
use App\Models\Currency\Currency;
use App\Models\Gallery\Gallery;
use App\Models\Gallery\GalleryCharacter;
use App\Models\Gallery\GallerySubmission;
use App\Models\Item\Item;
use App\Models\Item\ItemCategory;
use App\Models\Item\ItemLog;
use App\Models\User\UserAward;
use App\Models\Award\Award;
use App\Models\Award\AwardCategory;
use App\Models\Award\AwardLog;
use App\Models\Gallery\GalleryFavorite;
use App\Models\Character\CharacterCategory;
use App\Models\Pet\Pet;
use App\Models\Pet\PetCategory;
use App\Models\Prompt\Prompt;
use App\Models\Rarity;
use App\Models\User\User;
use App\Models\User\UserCurrency;
use App\Models\Currency\CurrencyLog;
use App\Models\User\UserItem;
use App\Models\Border\Border;
use App\Models\User\UserPet;
use App\Models\User\UserUpdateLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\User\UserPrizeLog;
use App\Models\Shop\UserShop;

class UserController extends Controller {
  /*
    |--------------------------------------------------------------------------
    | User Controller
    |--------------------------------------------------------------------------
    |
    | Displays user profile pages.
    |
    */

  /**
   * Create a new controller instance.
   */
  public function __construct() {
    parent::__construct();
    $name = Route::current()->parameter('name');
    $this->user = User::where('name', $name)->first();
    // check previous usernames (only grab the latest change)
    if (!$this->user) {
      $this->user = UserUpdateLog::whereIn('type', ['Username Changed', 'Name/Rank Change'])->where('data', 'like', '%"old_name":"' . $name . '"%')->orderBy('id', 'DESC')->first()->user ?? null;
    }
    if (!$this->user) {
      abort(404);
    }

    View::share('sublists', Sublist::orderBy('sort', 'DESC')->get());

    $this->user->updateCharacters();
    $this->user->updateArtDesignCredits();
  }

  /**
   * Shows a user's profile.
   *
   * @param  string  $name
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getUser($name) {
    $characters = $this->user->characters();
    if (!Auth::check() || !(Auth::check() && Auth::user()->hasPower('manage_characters'))) $characters->visible();

    $aliases = $this->user->aliases();
    if (!Auth::check() || !(Auth::check() && Auth::user()->hasPower('edit_user_info'))) {
      $aliases->visible();
    }

    return view('user.profile', [
      'name'                  => $name,
      'user'                  => $this->user,
      'items'                 => $this->user->items()->where('count', '>', 0)->orderBy('user_items.updated_at', 'DESC')->take(4)->get(),
      'sublists'              => Sublist::orderBy('sort', 'DESC')->get(),
      'characters'            => $characters,
      'user_enabled'          => Settings::get('WE_user_locations'),
      'user_factions_enabled' => Settings::get('WE_user_factions'),
      'aliases'               => $aliases->orderBy('is_primary_alias', 'DESC')->orderBy('site')->get(),
      'pets'                  => $this->user->pets()->orderBy('user_pets.updated_at', 'DESC')->take(5)->get(),
      'awards'                => $this->user->awards()->orderBy('user_awards.updated_at', 'DESC')
        /* */->whereNull('deleted_at')->where('count', '>', 0)->take(4)->get(),
    ]);
  }

  /**
   * Shows a user's aliases.
   *
   * @param  string  $name
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getUserAliases($name) {
    $aliases = $this->user->aliases();
    if (!Auth::check() || !(Auth::check() && Auth::user()->hasPower('edit_user_info'))) $aliases->visible();

    return view('user.aliases', [
      'user' => $this->user,
      'aliases' => $aliases->orderBy('is_primary_alias', 'DESC')->orderBy('site')->get(),
    ]);
  }

  /**
   * Shows a user's characters.
   *
   * @param string $name
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getUserCharacters($name) {
    $query = Character::myo(0)->where('user_id', $this->user->id);
    $imageQuery = CharacterImage::images(Auth::user() ?? null)->with('features')->with('rarity')->with('species')->with('features');

    if ($sublists = Sublist::where('show_main', 0)->get()) {
      $subCategories = [];
    }
    $subSpecies = [];
    foreach ($sublists as $sublist) {
      $subCategories = array_merge($subCategories, $sublist->categories->pluck('id')->toArray());
      $subSpecies = array_merge($subSpecies, $sublist->species->pluck('id')->toArray());
    }

    $query->whereNotIn('character_category_id', $subCategories);
    $imageQuery->whereNotIn('species_id', $subSpecies);

    $query->whereIn('id', $imageQuery->pluck('character_id'));

    if (!Auth::check() || !(Auth::check() && Auth::user()->hasPower('manage_characters'))) {
      $query->visible();
    }

    return view('user.characters', [
      'user'       => $this->user,
      'characters' => $query->orderBy('sort', 'DESC')->get(),
    ]);
  }

  /**
   * Shows a user's sublist characters.
   *
   * @param string $name
   * @param mixed  $key
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getUserSublist($name, $key) {
    $query = Character::myo(0)->where('user_id', $this->user->id);
    $imageQuery = CharacterImage::images(Auth::user() ?? null)->with('features')->with('rarity')->with('species')->with('features');

    $sublist = Sublist::where('key', $key)->first();
    if (!$sublist) {
      abort(404);
    }
    $subCategories = $sublist->categories->pluck('id')->toArray();
    $subSpecies = $sublist->species->pluck('id')->toArray();

    if ($subCategories) {
      $query->whereIn('character_category_id', $subCategories);
    }
    if ($subSpecies) {
      $imageQuery->whereIn('species_id', $subSpecies);
    }

    $query->whereIn('id', $imageQuery->pluck('character_id'));

    if (!Auth::check() || !(Auth::check() && Auth::user()->hasPower('manage_characters'))) {
      $query->visible();
    }

    return view('user.sublist', [
      'user'       => $this->user,
      'characters' => $query->orderBy('sort', 'DESC')->get(),
      'sublist'    => $sublist,
    ]);
  }

  /**
   * Shows a user's MYO slots.
   *
   * @param string $name
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getUserMyoSlots($name) {
    $myo = $this->user->myoSlots();
    if (!Auth::check() || !(Auth::check() && Auth::user()->hasPower('manage_characters'))) {
      $myo->visible();
    }

    return view('user.myo_slots', [
      'user' => $this->user,
      'myos' => $myo->get(),
    ]);
  }

  /**
   * Shows a user's inventory.
   *
   * @param string $name
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getUserInventory(Request $request, $name) {
    $categories = ItemCategory::visible(Auth::user() ?? null)->orderBy('sort', 'DESC')->get();
    $query = Item::query();
    $data = $request->only(['item_category_id', 'name', 'artist', 'rarity_id']);
    if (isset($data['item_category_id'])) {
      $query->where('item_category_id', $data['item_category_id']);
    }
    if (isset($data['name'])) {
      $query->where('name', 'LIKE', '%' . $data['name'] . '%');
    }
    if (isset($data['artist'])) {
      $query->where('artist_id', $data['artist']);
    }
    if (isset($data['rarity_id'])) {
      if ($data['rarity_id'] == 'withoutOption') {
        $query->whereNull('data->rarity_id');
      } else {
        $query->where('data->rarity_id', $data['rarity_id']);
      }
    }

    $items = count($categories) ?
      $this->user->items()
      ->whereIn('items.id', $query->pluck('id')->toArray())
      ->where('count', '>', 0)
      ->orderByRaw('FIELD(item_category_id,' . implode(',', $categories->pluck('id')->toArray()) . ')')
      ->orderBy('name')
      ->orderBy('updated_at')
      ->get()
      ->groupBy(['item_category_id', 'id']) :
      $this->user->items()
      ->whereIn('items.id', $query->pluck('id')->toArray())
      ->where('count', '>', 0)
      ->orderBy('name')
      ->orderBy('updated_at')
      ->get()
      ->groupBy(['item_category_id', 'id']);

    return view('user.inventory', [
      'user'        => $this->user,
      'categories'  => $categories->keyBy('id'),
      'items'       => $items,
      'userOptions' => User::where('id', '!=', $this->user->id)->orderBy('name')->pluck('name', 'id')->toArray(),
      'sublists' => Sublist::orderBy('sort', 'DESC')->get(),
      'logs'        => $this->user->getItemLogs(),
      'artists'     => User::whereIn('id', Item::whereNotNull('artist_id')->pluck('artist_id')->toArray())->pluck('name', 'id')->toArray(),
      'rarities'    => ['withoutOption' => 'No Rarity'] + Rarity::orderBy('rarities.sort', 'DESC')->pluck('name', 'id')->toArray(),
    ]);
  }



  /**
   * Shows a user's pets.
   *
   * @param string $name
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getUserPets($name) {
    $categories = PetCategory::orderBy('sort', 'DESC')->get();
    $pets = count($categories) ? $this->user->pets()->orderByRaw('FIELD(pet_category_id,' . implode(',', $categories->pluck('id')->toArray()) . ')')->orderBy('name')->orderBy('updated_at')->get()->groupBy('pet_category_id') : $this->user->pets()->orderBy('name')->orderBy('updated_at')->get()->groupBy('pet_category_id');

    return view('user.pets', [
      'user'        => $this->user,
      'categories'  => $categories->keyBy('id'),
      'pets'        => $pets,
      'userOptions' => User::where('id', '!=', $this->user->id)->orderBy('name')->pluck('name', 'id')->toArray(),
      'user'        => $this->user,
      'logs'        => $this->user->getPetLogs(),
    ]);
  }

  /**
   * Shows a user's awardcase.
   *
   * @param  string  $name
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getUserAwardCase($name) {
    $categories = AwardCategory::orderBy('sort', 'DESC')->get();
    $awards = count($categories) ?
      $this->user->awards()
      ->where('count', '>', 0)
      ->orderByRaw('FIELD(award_category_id,' . implode(',', $categories->pluck('id')->toArray()) . ')')
      ->orderBy('name')
      ->orderBy('updated_at')
      ->get()
      ->groupBy(['award_category_id', 'id']) :
      $this->user->awards()
      ->where('count', '>', 0)
      ->orderBy('name')
      ->orderBy('updated_at')
      ->get()
      ->groupBy(['award_category_id', 'id']);
    return view('user.awardcase', [
      'user' => $this->user,
      'categories' => $categories->keyBy('id'),
      'awards' => $awards,
      'userOptions' => User::where('id', '!=', $this->user->id)->orderBy('name')->pluck('name', 'id')->toArray(),
      'user' => $this->user,
      'logs' => $this->user->getAwardLogs(),
      'sublists' => Sublist::orderBy('sort', 'DESC')->get()
    ]);
  }

  /**
   * Shows a user's pets.
   *
   * @param string $name
   * @param mixed  $id
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getUserPet($name, $id) {
    $pet = UserPet::findOrFail($id);

    return view('user.pet', [
      'user'        => $this->user,
      'pet'         => $pet,
      'userOptions' => User::where('id', '!=', $this->user->id)->orderBy('name')->pluck('name', 'id')->toArray(),
      'logs'        => $this->user->getPetLogs(),
    ]);
  }
  /**
   * Shows a user's Bank.
   *
   * @param string $name
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getUserBank($name) {
    $user = $this->user;

    return view('user.bank', [
      'user' => $this->user,
      'logs' => $this->user->getCurrencyLogs(),
    ] + (Auth::check() && Auth::user()->id == $this->user->id ? [
      'currencyOptions' => Currency::where('allow_user_to_user', 1)->where('is_user_owned', 1)->whereIn('id', UserCurrency::where('user_id', $this->user->id)->pluck('currency_id')->toArray())->orderBy('sort_user', 'DESC')->pluck('name', 'id')->toArray(),
      'userOptions'     => User::where('id', '!=', Auth::user()->id)->orderBy('name')->pluck('name', 'id')->toArray(),
    ] : []));
  }

  /**
   * Shows a user's currency logs.
   *
   * @param string $name
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getUserCurrencyLogs($name) {
    $user = $this->user;

    return view('user.currency_logs', [
      'user' => $this->user,
      'logs' => $this->user->getCurrencyLogs(0),
    ]);
  }

  /**
   * Shows a user's item logs.
   *
   * @param  string  $name
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getUserItemLogs($name) {
    $user = $this->user;
    return view('user.item_logs', [
      'user' => $this->user,
      'logs' => $this->user->getItemLogs(0),
      'sublists' => Sublist::orderBy('sort', 'DESC')->get()
    ]);
  }

  /**
   * Shows a user's character ownership logs.
   *
   * @param string $name
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getUserOwnershipLogs($name) {
    return view('user.ownership_logs', [
      'user' => $this->user,
      'logs' => $this->user->getOwnershipLogs(),
    ]);
  }

  /**
   * Shows a user's submissions.
   *
   * @param string $name
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getUserSubmissions($name) {
    return view('user.submission_logs', [
      'user' => $this->user,
      'logs' => $this->user->getSubmissions(Auth::user() ?? null),
    ]);
  }

  /**
   * Shows a user's recipe logs.
   *
   * @param string $name
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getUserRecipeLogs($name) {
    $user = $this->user;

    return view('user.recipe_logs', [
      'user'     => $this->user,
      'logs'     => $this->user->getRecipeLogs(0),
      'sublists' => Sublist::orderBy('sort', 'DESC')->get(),
    ]);
  }

  /**
   * Shows a user's gallery submissions.
   *
   * @param string $name
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getUserGallery(Request $request, $name) {
    return view('user.gallery', [
      'user'        => $this->user,
      'submissions' => $this->user->gallerySubmissions()->visible(Auth::user() ?? null)->paginate(20)->appends($request->query()),
    ]);
  }

  /**
   * Shows a user's character art.
   *
   * @param string $name
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getUserCharacterArt(Request $request, $name) {
    $characters = Character::whereHas('image', function ($query) {
      $query->whereHas('artists', function ($query) {
        $query->where('user_id', $this->user->id);
      });
    });

    if (!Auth::check() || !(Auth::check() && Auth::user()->hasPower('manage_characters'))) {
      $characters->visible();
    }

    return view('user.character_designs', [
      'user'        => $this->user,
      'characters'  => $characters->get(),
      'isDesign'    => false,
    ]);
  }

  /**
   * Shows a user's character designs.
   *
   * @param string $name
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getUserCharacterDesigns(Request $request, $name) {
    $characters = Character::whereHas('image', function ($query) {
      $query->whereHas('designers', function ($query) {
        $query->where('user_id', $this->user->id);
      });
    });

    if (!Auth::check() || !(Auth::check() && Auth::user()->hasPower('manage_characters'))) {
      $characters->visible();
    }

    return view('user.character_designs', [
      'user'        => $this->user,
      'characters'  => $characters->get(),
      'isDesign'    => true,
    ]);
  }

  /**
   * Shows a user's gallery submission favorites.
   *
   * @param string $name
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getUserFavorites(Request $request, $name) {
    return view('user.favorites', [
      'user'       => $this->user,
      'characters' => false,
      'favorites'  => GallerySubmission::whereIn('id', $this->user->galleryFavorites()->pluck('gallery_submission_id')->toArray())->visible(Auth::user() ?? null)->orderBy('created_at', 'DESC')->paginate(20)->appends($request->query()),

    ]);
  }

  /**
   * Shows a user's gallery submission favorites that contain characters they own.
   *
   * @param string $name
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getUserOwnCharacterFavorites(Request $request, $name) {
    $user = $this->user;
    $userCharacters = $user->characters()->pluck('id')->toArray();
    $userFavorites = $user->galleryFavorites()->pluck('gallery_submission_id')->toArray();

    return view('user.favorites', [
      'user'       => $this->user,
      'characters' => true,
      'favorites'  =>
      $this->user->characters->count()
        ? GallerySubmission::whereIn('id', $userFavorites)
        ->whereIn('id', GalleryCharacter::whereIn('character_id', $userCharacters)
          ->pluck('gallery_submission_id')
          ->toArray())
        ->visible(Auth::check() ? Auth::user() : null)
        ->orderBy('created_at', 'DESC')
        ->paginate(20)
        ->appends($request->query())
        : null,
      // 'sublists' => Sublist::orderBy('sort', 'DESC')->get()

    ]);
  }

  /**
   * Shows a user's borders.
   *
   * @param  string  $name
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getUserBorders($name) {
    $default =  Border::base()->active(Auth::user() ?? null)->where('is_default', 1)->get();
    $admin = Border::base()->where('admin_only', 1)->get();

    return view('user.borders', [
      'user' => $this->user,
      'default' => $default,
      'admin' => $admin,
      'logs' => $this->user->getBorderLogs(),
    ]);
  }

  /**
   * Shows a user's border logs.
   *
   * @param  string  $name
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getUserBorderLogs($name) {
    $user = $this->user;

    return view('user.border_logs', [
      'user' => $this->user,
      'logs' => $this->user->getBorderLogs(0),
      'sublists' => Sublist::orderBy('sort', 'DESC')->get(),
      'characters' => true,
      'favorites' => $this->user->characters->count() ? GallerySubmission::whereIn('id', $userFavorites)->whereIn('id', GalleryCharacter::whereIn('character_id', $userCharacters)->pluck('gallery_submission_id')->toArray())->visible(Auth::check() ? Auth::user() : null)->accepted()->orderBy('created_at', 'DESC')->paginate(20) : null,
    ]);
  }

  /**
   * Shows a user's characters.
   *
   * @param  string  $name
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getUserShops($name) {
    $shops = UserShop::visible()->where('user_id', $this->user->id);

    return view('user.shops', [
      'user' => $this->user,
      'shops' => $shops->orderBy('sort', 'DESC')->get(),
      'sublists' => Sublist::orderBy('sort', 'DESC')->get()
    ]);
  }

  /**
   * Shows a user's redeem logs.
   *
   * @param  string  $name
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getUserRedeemLogs($name) {
    $user = $this->user;
    return view('home._redeem_logs', [
      'user' => $this->user,
      'logs' => $this->user->getRedeemLogs(0),
      'sublists' => Sublist::orderBy('sort', 'DESC')->get()
    ]);
  }
}
