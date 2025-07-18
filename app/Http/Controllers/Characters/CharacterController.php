<?php

namespace App\Http\Controllers\Characters;
use App\Services\CharacterManager;
use App\Services\CurrencyManager;
use App\Services\InventoryManager;
use Route;
use App\Facades\Settings;
use App\Http\Controllers\Controller;
use App\Models\Character\Character;
use App\Models\Character\CharacterCurrency;
use App\Models\Character\CharacterItem;
use App\Models\Character\CharacterProfile;
use App\Models\Character\CharacterRelation;
use App\Models\Character\CharacterTransfer;
use App\Models\Currency\Currency;
use App\Models\Gallery\GallerySubmission;
use App\Models\Item\Item;
use App\Models\Item\ItemCategory;
use App\Models\Rarity;
use App\Models\User\User;
use App\Models\User\UserCurrency;
use App\Models\User\UserItem;
use App\Models\WorldExpansion\Faction;
use App\Models\WorldExpansion\Location;
use App\Models\Item\ItemLog;

use App\Models\Award\Award;
use App\Models\Award\AwardCategory;
use App\Models\User\UserAward;
use App\Models\Award\AwardLog;
use App\Models\Character\CharacterAward;
use App\Models\Profession\Profession;
use App\Models\Character\CharacterImage;
use App\Services\AwardCaseManager;
use App\Services\CharacterLinkService;
use App\Services\DesignUpdateManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class CharacterController extends Controller {
  /*
    |--------------------------------------------------------------------------
    | Character Controller
    |--------------------------------------------------------------------------
    |
    | Handles displaying and acting on a character.
    |
    */

  /**
   * Create a new controller instance.
   */
  public function __construct() {
    $this->middleware(function ($request, $next) {
      $slug = Route::current()->parameter('slug');
      $query = Character::myo(0)->where('slug', $slug);
      if (!(Auth::check() && Auth::user()->hasPower('manage_characters'))) {
        $query->where('is_visible', 1);
      }
      $this->character = $query->first();
      if (!$this->character) {
        abort(404);
      }

      $this->character->updateOwner();

      if (config('lorekeeper.extensions.previous_and_next_characters.display')) {
        $query = Character::myo(0);
        // Get only characters of this category if pull number is limited to category
        if (config('lorekeeper.settings.character_pull_number') === 'category') {
          $query->where('character_category_id', $this->character->character_category_id);
        }

        if (!(Auth::check() && Auth::user()->hasPower('manage_characters'))) {
          $query->where('is_visible', 1);
        }

        // Get the previous and next characters, if they exist
        $prevCharName = null;
        $prevCharUrl = null;
        $nextCharName = null;
        $nextCharUrl = null;

        if ($query->count()) {
          $characters = $query->orderBy('number', 'DESC')->get();

          // Filter
          $lowerChar = $characters->where('number', '<', $this->character->number)->first();
          $higherChar = $characters->where('number', '>', $this->character->number)->last();
        }

        if (config('lorekeeper.extensions.previous_and_next_characters.reverse') == 0) {
          $nextCharacter = $lowerChar;
          $previousCharacter = $higherChar;
        } else {
          $previousCharacter = $lowerChar;
          $nextCharacter = $higherChar;
        }

        if (!$previousCharacter || $previousCharacter->id == $this->character->id) {
          $previousCharacter = null;
        } else {
          $prevCharName = $previousCharacter->fullName;
          $prevCharUrl = $previousCharacter->url;
        }

        if (!$nextCharacter || $nextCharacter->id == $this->character->id) {
          $nextCharacter = null;
        } else {
          $nextCharName = $nextCharacter->fullName;
          $nextCharUrl = $nextCharacter->url;
        }

        $extPrevAndNextBtns = ['prevCharName' => $prevCharName, 'prevCharUrl' => $prevCharUrl, 'nextCharName' => $nextCharName, 'nextCharUrl' => $nextCharUrl];
        View::share('extPrevAndNextBtns', $extPrevAndNextBtns);
      }


      if (Auth::check()) {
        Auth::user()->checkLike($this->character);
      }
      return $next($request);
    });
  }

  /**
   * Shows a character's masterlist entry.
   *
   * @param string $slug
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getCharacter($slug) {
    return view('character.character', [
      'character'             => $this->character,
      'showMention'           => true,
      'extPrevAndNextBtnsUrl' => '',
    ]);
  }

  /**
   * Shows a character's profile.
   *
   * @param string $slug
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getCharacterProfile($slug) {
    return view('character.profile', [
      'character'             => $this->character,
      'extPrevAndNextBtnsUrl' => '/profile',
    ]);
  }

  /**
   * Shows a character's edit profile page.
   *
   * @param string $slug
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getEditCharacterProfile($slug) {
    if (!Auth::check()) {
      abort(404);
    }

    $isMod = Auth::user()->hasPower('manage_characters');
    $isOwner = ($this->character->user_id == Auth::user()->id);
    if (!$isMod && !$isOwner) {
      abort(404);
    }

    $professions = Profession::where("is_choosable", 1)->with('category')->get()->filter(function ($item) {
      return $item->category->species_id == null || $item->category->species_id == $this->character->image->species_id;
    })->pluck('name', 'id')->toArray();

    return view('character.edit_profile', [
      'character'            => $this->character,
      'locations'            => Location::all()->where('is_character_home')->pluck('style', 'id')->toArray(),
      'factions'             => Faction::all()->where('is_character_faction')->pluck('style', 'id')->toArray(),
      'user_enabled'         => Settings::get('WE_user_locations'),
      'user_faction_enabled' => Settings::get('WE_user_factions'),
      'char_enabled'         => Settings::get('WE_character_locations'),
      'char_faction_enabled' => Settings::get('WE_character_factions'),
      'professions' => $professions
    ]);
  }

  /**
   * Edits a character's profile.
   *
   * @param App\Services\CharacterManager $service
   * @param string                        $slug
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postEditCharacterProfile(Request $request, CharacterManager $service, $slug) {
    if (!Auth::check()) {
      abort(404);
    }

    $isMod = Auth::user()->hasPower('manage_characters');
    $isOwner = ($this->character->user_id == Auth::user()->id);
    if (!$isMod && !$isOwner) {
      abort(404);
    }

    $request->validate(CharacterProfile::$rules);

    if ($service->updateCharacterProfile($request->only([
      'name',
      'link',
      'text',
      'is_gift_art_allowed',
      'is_gift_writing_allowed',
      'is_trading',
      'alert_user',
      'location',
      'faction',
      'profession',
      'profession_id'
    ]), $this->character, Auth::user(), !$isOwner)) {
      flash('Profile edited successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }
    }

    return redirect()->back();
  }

  /**
   * Sorts a character's titles.
   *
   * @param App\Services\CharacterManager $service
   * @param string                        $slug
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postSortTitles(CharacterManager $service, Request $request, $slug) {
    if ($service->sortCharacterTitles($this->character, $request->get('sort'))) {
      flash('Title order updated successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }
    }

    return redirect()->back();
  }

  /**
   * Shows a character's gallery.
   *
   * @param string $slug
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getCharacterGallery(Request $request, $slug) {
    return view('character.gallery', [
      'character'             => $this->character,
      'extPrevAndNextBtnsUrl' => '/gallery',
      'submissions'           => GallerySubmission::whereIn('id', $this->character->gallerySubmissions->pluck('gallery_submission_id')->toArray())->visible(Auth::user() ?? null)->orderBy('created_at', 'DESC')->paginate(20),
    ]);
  }

  /**
   * Shows a character's images.
   *
   * @param string $slug
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getCharacterImages($slug) {
    return view('character.images', [
      'user'                  => Auth::user() ?? null,
      'character'             => $this->character,
      'extPrevAndNextBtnsUrl' => '/images',
    ]);
  }

  /**
   * Shows a character's inventory.
   *
   * @param string $slug
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getCharacterInventory(Request $request, $slug) {
    $categories = ItemCategory::visible(Auth::user() ?? null)->where('is_character_owned', '1')->orderBy('sort', 'DESC')->get();
    $itemOptions = Item::whereIn('item_category_id', $categories->pluck('id'));

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
      $this->character->items()
      ->whereIn('items.id', $query->pluck('id')->toArray())
      ->where('count', '>', 0)
      ->orderByRaw('FIELD(item_category_id,' . implode(',', $categories->pluck('id')->toArray()) . ')')
      ->orderBy('name')
      ->orderBy('updated_at')
      ->get()
      ->groupBy(['item_category_id', 'id']) :
      $this->character->items()
      ->whereIn('items.id', $query->pluck('id')->toArray())
      ->where('count', '>', 0)
      ->orderBy('name')
      ->orderBy('updated_at')
      ->get()
      ->groupBy(['item_category_id', 'id']);

    return view('character.inventory', [
      'character'             => $this->character,
      'extPrevAndNextBtnsUrl' => '/inventory',
      'categories'            => $categories->keyBy('id'),
      'items'                 => $items,
      'logs'                  => $this->character->getItemLogs(),
      'artists'               => User::whereIn('id', Item::whereNotNull('artist_id')->pluck('artist_id')->toArray())->pluck('name', 'id')->toArray(),
      'rarities'              => ['withoutOption' => 'Without Rarity'] + Rarity::orderBy('rarities.sort', 'DESC')->pluck('name', 'id')->toArray(),
    ] + (Auth::check() && (Auth::user()->hasPower('edit_inventories') || Auth::user()->id == $this->character->user_id) ? [
      'itemOptions'   => $itemOptions->pluck('name', 'id'),
      'userInventory' => UserItem::with('item')->whereIn('item_id', $itemOptions->pluck('id'))->whereNull('deleted_at')->where('count', '>', '0')->where('user_id', Auth::user()->id)->get()->filter(function ($userItem) {
        return $userItem->isTransferrable == true;
      })->sortBy('item.name'),
      'page'          => 'character',
    ] : []));
  }

  /**
   * Shows a character's bank.
   *
   * @param string $slug
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getCharacterBank($slug) {
    $character = $this->character;

    return view('character.bank', [
      'character'             => $this->character,
      'extPrevAndNextBtnsUrl' => '/bank',
      'currencies'            => $character->getCurrencies(true),
      'logs'                  => $this->character->getCurrencyLogs(),
    ] + (Auth::check() && Auth::user()->id == $this->character->user_id ? [
      'takeCurrencyOptions' => Currency::where('allow_character_to_user', 1)->where('is_user_owned', 1)->where('is_character_owned', 1)->whereIn('id', CharacterCurrency::where('character_id', $this->character->id)->pluck('currency_id')->toArray())->orderBy('sort_character', 'DESC')->pluck('name', 'id')->toArray(),
      'giveCurrencyOptions' => Currency::where('allow_user_to_character', 1)->where('is_user_owned', 1)->where('is_character_owned', 1)->whereIn('id', UserCurrency::where('user_id', Auth::user()->id)->pluck('currency_id')->toArray())->orderBy('sort_user', 'DESC')->pluck('name', 'id')->toArray(),

    ] : []) + (Auth::check() && (Auth::user()->hasPower('edit_inventories') || Auth::user()->id == $this->character->user_id) ? [
      'currencyOptions' => Currency::where('is_character_owned', 1)->orderBy('sort_character', 'DESC')->pluck('name', 'id')->toArray(),
    ] : []));
  }

  /**
   * Shows a character's awards.
   *
   * @param  string  $slug
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getCharacterAwards($slug) {
    $categories = AwardCategory::orderBy('sort', 'DESC')->get();
    $awardOptions = Award::where('is_character_owned', '1');

    $awards = count($categories) ?
      $this->character->awards()
      ->where('count', '>', 0)
      ->orderByRaw('FIELD(award_category_id,' . implode(',', $categories->pluck('id')->toArray()) . ')')
      ->orderBy('name')
      ->orderBy('updated_at')
      ->get()
      ->groupBy(['award_category_id', 'id']) :
      $this->character->awards()
      ->where('count', '>', 0)
      ->orderBy('name')
      ->orderBy('updated_at')
      ->get()
      ->groupBy(['award_category_id', 'id']);
    return view('character.awards', [
      'character' => $this->character,
      'categories' => $categories->keyBy('id'),
      'awards' => $awards,
      'logs' => $this->character->getAwardLogs(),
    ] + (Auth::check() && (Auth::user()->hasPower('edit_inventories') || Auth::user()->id == $this->character->user_id) ? [
      'awardOptions' => $awardOptions->pluck('name', 'id'),
      'page' => 'character'
    ] : []));
  }


  /**
   * Transfers currency between the user and character.
   *
   * @param App\Services\CharacterManager $service
   * @param string                        $slug
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postCurrencyTransfer(Request $request, CurrencyManager $service, $slug) {
    if (!Auth::check()) {
      abort(404);
    }

    $action = $request->get('action');
    $sender = ($action == 'take') ? $this->character : Auth::user();
    $recipient = ($action == 'take') ? Auth::user() : $this->character;

    if ($service->transferCharacterCurrency($sender, $recipient, Currency::where(($action == 'take') ? 'allow_character_to_user' : 'allow_user_to_character', 1)->where('id', $request->get(($action == 'take') ? 'take_currency_id' : 'give_currency_id'))->first(), $request->get('quantity'))) {
      flash('Currency transferred successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }
    }

    return redirect()->back();
  }

  /**
   * Handles inventory item processing, including transferring items between the user and character.
   *
   * @param App\Services\CharacterManager $service
   * @param string                        $slug
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postInventoryEdit(Request $request, InventoryManager $service, $slug) {
    if (!Auth::check()) {
      abort(404);
    }
    switch ($request->get('action')) {
      default:
        flash('Invalid action selected.')->error();
        break;
      case 'give':
        $sender = Auth::user();
        $recipient = $this->character;

        if ($service->transferCharacterStack($sender, $recipient, UserItem::find($request->get('stack_id')), $request->get('stack_quantity'), Auth::user())) {
          flash('Item transferred successfully.')->success();
        } else {
          foreach ($service->errors()->getMessages()['error'] as $error) {
            flash($error)->error();
          }
        }
        break;
      case 'name':
        return $this->postName($request, $service);
      case 'delete':
        return $this->postDelete($request, $service);
      case 'take':
        return $this->postItemTransfer($request, $service);
    }

    return redirect()->back();
  }

  /**
   * Handles inventory award processing, including transferring awards between the user and character.
   *
   * @param  \Illuminate\Http\Request       $request
   * @param  App\Services\CharacterManager  $service
   * @param  string                         $slug
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postAwardEdit(Request $request, AwardCaseManager $service, $slug) {
    if (!Auth::check()) abort(404);
    switch ($request->get('action')) {
      default:
        flash('Invalid action selected.')->error();
        break;
      case 'give':
        $sender = Auth::user();
        $recipient = $this->character;

        if ($service->transferCharacterStack($sender, $recipient, UserAward::find($request->get('stack_id')), $request->get('stack_quantity'))) {
          flash(ucfirst(__('awards.award')) . ' transferred successfully.')->success();
        } else {
          foreach ($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }

        break;
      case 'delete':
        return $this->postDeleteAward($request, $service);
        break;
      case 'take':
        return $this->postAwardTransfer($request, $service);
        break;
    }

    return redirect()->back();
  }
    /**********************************************************************************************

        LINKS

    **********************************************************************************************/

    /**
     * Shows a character's links page.
     *
     * @param string $slug
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCharacterLinks($slug) {
        return view('character.links', [
            'character' => $this->character,
            'types'     => config('lorekeeper.character_relationships'),
        ]);
    }

    /**
     * Shows a character's edit links page.
     *
     * @param string $slug
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCreateEditCharacterLinks($slug) {
        if (!Auth::check()) {
            abort(404);
        }

        if (!Auth::user()->id == $this->character->user_id && !Auth::user()->hasPower('manage_characters')) {
            abort(404);
        }

        return view('character.edit_links', [
            'character' => $this->character,
        ]);
    }

    /**
     * Creates / requests character links.
     *
     * @param App\Services\CharacterManager $service
     * @param string                        $slug
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreateEditCharacterLinks(Request $request, CharacterLinkService $service, $slug) {
        if (!Auth::check()) {
            abort(404);
        }

        $isMod = Auth::user()->hasPower('manage_characters');
        $isOwner = ($this->character->user_id == Auth::user()->id);
        if (!$isMod && !$isOwner) {
            abort(404);
        }

        if ($service->createCharacterRelationLinks($this->character, $request->only(['slug']), Auth::user())) {
            flash('Links requested successfully.')->success();
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }

        return redirect()->back();
    }

    /**
     * Edits a character's link info.
     *
     * @param App\Services\CharacterManager $service
     * @param string                        $slug
     * @param mixed                         $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEditCharacterLinkInfo(Request $request, CharacterLinkService $service, $slug, $id) {
        $data = $request->only(['info', 'type']);
        if ($service->updateCharacterRelationLinkInfo($data + ['slug' => $slug], $id, Auth::user())) {
            flash('Info updated successfully!')->success();
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }

        return redirect()->back();
    }

    /**
     * Gets the delete character relationship modal.
     *
     * @param mixed $slug
     * @param mixed $id
     */
    public function getDeleteCharacterLink($slug, $id) {
        $link = CharacterRelation::find($id);

        if (!$link) {
            abort(404);
        }

        return view('character._delete_link', [
            'link'      => $link,
            'character' => $this->character,
        ]);
    }

    /**
     * deletes a character relationship link.
     *
     * @param string $slug
     * @param mixed  $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postDeleteCharacterLink(Request $request, CharacterLinkService $service, $slug, $id) {
        if ($service->deleteCharacterRelationLink($id)) {
            flash('Link deleted successfully!')->success();
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }

        return redirect()->back();
    }

  /**
   * Transfers inventory items back to a user.
   *
   * @param  \Illuminate\Http\Request       $request
   * @param  App\Services\InventoryManager  $service
   * @return \Illuminate\Http\RedirectResponse
   */
  private function postItemTransfer(Request $request, InventoryManager $service) {
    if ($service->transferCharacterStack($this->character, $this->character->user, CharacterItem::find($request->get('ids')), $request->get('quantities'))) {
      flash('Item transferred successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) flash($error)->error();
    }
    return redirect()->back();
  }

  /**
   * Transfers inventory awards back to a user.
   *
   * @param  \Illuminate\Http\Request       $request
   * @param  App\Services\InventoryManager  $service
   * @return \Illuminate\Http\RedirectResponse
   */
  private function postAwardTransfer(Request $request, AwardCaseManager $service) {
    if ($service->transferCharacterStack($this->character, $this->character->user, CharacterAward::find($request->get('ids')), $request->get('quantities'))) {
      flash(ucfirst(__('awards.award')) . ' transferred successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) flash($error)->error();
    }
    return redirect()->back();
  }

  /**
   * Names an inventory stack.
   *
   * @param  \Illuminate\Http\Request       $request
   * @param  App\Services\CharacterManager  $service
   * @return \Illuminate\Http\RedirectResponse
   */
  private function postName(Request $request, InventoryManager $service) {
    $request->validate(['stack_name' => 'nullable|max:100']);
    if ($service->nameStack($this->character, CharacterItem::find($request->get('ids')), $request->get('stack_name'), Auth::user())) {
      flash('Item named successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) flash($error)->error();
    }
    return redirect()->back();
  }

  /**
   * Deletes an inventory stack.
   *
   * @param  \Illuminate\Http\Request       $request
   * @param  App\Services\CharacterManager  $service
   * @return \Illuminate\Http\RedirectResponse
   */
  private function postDelete(Request $request, InventoryManager $service) {
    if ($service->deleteStack($this->character, CharacterItem::find($request->get('ids')), $request->get('quantities'), Auth::user())) {
      flash('Item deleted successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) flash($error)->error();
    }
    return redirect()->back();
  }
  /**
   * Deletes an award stack.
   *
   * @param  \Illuminate\Http\Request       $request
   * @param  App\Services\CharacterManager  $service
   * @return \Illuminate\Http\RedirectResponse
   */
  private function postDeleteAward(Request $request, AwardCaseManager $service) {
    if ($service->deleteStack($this->character, CharacterAward::find($request->get('ids')), $request->get('quantities'))) {
      flash(ucfirst(__('awards.award')) . ' deleted successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) flash($error)->error();
    }
    return redirect()->back();
  }

  /**
   * Shows a character's currency logs.
   *
   * @param string $slug
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getCharacterCurrencyLogs($slug) {
    return view('character.currency_logs', [
      'character'             => $this->character,
      'extPrevAndNextBtnsUrl' => '/currency-logs',
      'logs'                  => $this->character->getCurrencyLogs(0),
    ]);
  }

  /**
   * Shows a character's item logs.
   *
   * @param mixed $slug
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getCharacterItemLogs($slug) {
    return view('character.item_logs', [
      'character'             => $this->character,
      'extPrevAndNextBtnsUrl' => '/item-logs',
      'logs'                  => $this->character->getItemLogs(0),
    ]);
  }

  /**
   * Shows a character's awar logs.
   *
   * @param  string  $name
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getCharacterAwardLogs($slug) {
    return view('character.award_logs', [
      'character' => $this->character,
      'logs' => $this->character->getAwardLogs(0)
    ]);
  }

  /**
   * Shows a character's ownership logs.
   *
   * @param string $slug
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getCharacterOwnershipLogs($slug) {
    return view('character.ownership_logs', [
      'character'             => $this->character,
      'extPrevAndNextBtnsUrl' => '/ownership',
      'logs'                  => $this->character->getOwnershipLogs(0),
    ]);
  }

  /**
   * Shows a character's ownership logs.
   *
   * @param string $slug
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getCharacterLogs($slug) {
    return view('character.character_logs', [
      'character'             => $this->character,
      'extPrevAndNextBtnsUrl' => '/change-log',
      'logs'                  => $this->character->getCharacterLogs(),
    ]);
  }

  /**
   * Shows a character's submissions.
   *
   * @param mixed $slug
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getCharacterSubmissions($slug) {
    return view('character.submission_logs', [
      'character'             => $this->character,
      'extPrevAndNextBtnsUrl' => '/submissions',
      'logs'                  => $this->character->getSubmissions(),
    ]);
  }

  /**
   * Shows a character's transfer page.
   *
   * @param string $slug
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getTransfer($slug) {
    if (!Auth::check()) {
      abort(404);
    }

    $isMod = Auth::user()->hasPower('manage_characters');
    $isOwner = ($this->character->user_id == Auth::user()->id);
    if (!$isMod && !$isOwner) {
      abort(404);
    }

    return view('character.transfer', [
      'character'      => $this->character,
      'transfer'       => CharacterTransfer::active()->where('character_id', $this->character->id)->first(),
      'cooldown'       => Settings::get('transfer_cooldown'),
      'transfersQueue' => Settings::get('open_transfers_queue'),
      'userOptions'    => User::visible()->orderBy('name')->pluck('name', 'id')->toArray(),
    ]);
  }

  /**
   * Opens a transfer request for a character.
   *
   * @param App\Services\CharacterManager $service
   * @param string                        $slug
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postTransfer(Request $request, CharacterManager $service, $slug) {
    if (!Auth::check()) {
      abort(404);
    }

    if ($service->createTransfer($request->only(['recipient_id', 'user_reason']), $this->character, Auth::user())) {
      flash('Transfer created successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }
    }

    return redirect()->back();
  }

  /**
   * Cancels a transfer request for a character.
   *
   * @param App\Services\CharacterManager $service
   * @param string                        $slug
   * @param int                           $id
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postCancelTransfer(Request $request, CharacterManager $service, $slug, $id) {
    if (!Auth::check()) {
      abort(404);
    }

    if ($service->cancelTransfer(['transfer_id' => $id], Auth::user())) {
      flash('Transfer cancelled.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }
    }

    return redirect()->back();
  }

  /**
   * Shows a character's design update approval page.
   *
   * @param string $slug
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getCharacterApproval($slug) {
    if (!Auth::check() || $this->character->user_id != Auth::user()->id) {
      abort(404);
    }

    return view('character.update_form', [
      'character' => $this->character,
      'queueOpen' => Settings::get('is_design_updates_open'),
      'request'   => $this->character->designUpdate()->active()->first(),
    ]);
  }

  /**
   * Opens a new design update approval request for a character.
   *
   * @param App\Services\DesignUpdateManager $service
   * @param string                           $slug
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postCharacterApproval($slug, DesignUpdateManager $service) {
    if (!Auth::check() || $this->character->user_id != Auth::user()->id) {
      abort(404);
    }

    if ($request = $service->createDesignUpdateRequest($this->character, Auth::user())) {
      flash('Successfully created new design update request draft.')->success();

      return redirect()->to($request->url);
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }
    }

    return redirect()->back();
  }

  /**
   * Shows a character's images.
   *
   * @param string $slug
   * @param mixed  $id
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getCharacterImage($slug, $id) {
    $image = CharacterImage::where('character_id', $this->character->id)->where('id', $id)->first();

    return view('character.image', [
      'user'      => Auth::check() ? Auth::user() : null,
      'character' => $this->character,
      'image'     => $image,
      'ajax'      => true,
    ]);
  }

  /**
   * Opens a new design update approval request for a character. but with a specific image lmao
   *
   * @param  App\Services\CharacterManager  $service
   * @param  string                         $slug
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postCharacterApprovalSpecificImage($slug, CharacterManager $service, $id) {
    if (!Auth::check() || $this->character->user_id != Auth::user()->id) abort(404);
    $image = CharacterImage::where('character_id', $this->character->id)->where('id', $id)->first();

    if ($request = $service->createDesignUpdateRequest($this->character, Auth::user(), $image, true)) {
      flash('Successfully created new design update request draft.')->success();
      return redirect()->to($request->url);
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) flash($error)->error();
    }
    return redirect()->back();
  }

  /**
   * Shows the characters pets.
   *
   * @param string $slug
   *
   */
  public function getCharacterPets($slug) {
    return view('character.pets', [
      'character'             => $this->character,
    ]);
  }

  /**
   * Like a character
   */
  public function postLikeCharacter(Request $request, CharacterManager $service, $slug) {
    if (!Auth::check()) abort(404);

    //owned by same user
    if (Auth::user()->id == $this->character->user->id) abort(404);

    //user disabled likes
    if (!$this->character->user->settings->allow_character_likes) abort(404);

    if ($service->likeCharacter($this->character, Auth::user())) {
      flash('Character ' . __('character_likes.liked') . ' successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) flash($error)->error();
    }
    return redirect()->back();
  }
}
