<?php

namespace App\Models\Character;

use App\Facades\Notifications;
use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyLog;
use App\Models\Character\CharacterLineage;
use App\Models\Character\CharacterLineageBlacklist;
use App\Models\Gallery\GalleryCharacter;
use App\Models\Item\Item;
use App\Models\Item\ItemLog;
use App\Models\Award\Award;
use App\Models\Award\AwardLog;
use App\Models\Model;
use App\Models\Rarity;
use App\Models\Submission\Submission;
use App\Models\Submission\SubmissionCharacter;
use App\Models\Trade;
use App\Models\User\User;
use App\Models\User\UserCharacterLog;
use App\Models\WorldExpansion\FactionRankMember;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Settings;

class Character extends Model {
  use SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'character_image_id',
    'character_category_id',
    'rarity_id',
    'user_id',
    'owner_alias',
    'number',
    'slug',
    'description',
    'parsed_description',
    'is_sellable',
    'is_tradeable',
    'is_giftable',
    'sale_value',
    'transferrable_at',
    'is_visible',
    'is_gift_art_allowed',
    'is_gift_writing_allowed',
    'is_trading',
    'sort',
    'is_myo_slot',
    'name',
    'trade_id',
    'owner_url',
    'home_id',
    'home_changed',
    'faction_id',
    'faction_changed',
    'is_links_open',
    'encounter_energy',
  ];

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'characters';

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'transferrable_at' => 'datetime',
    'home_changed'     => 'datetime',
    'faction_changed'  => 'datetime',
  ];

  /**
   * Whether the model contains timestamps to be saved and updated.
   *
   * @var string
   */
  public $timestamps = true;

  /**
   * Accessors to append to the model.
   *
   * @var array
   */
  public $appends = ['is_available'];

  /**
   * Validation rules for character creation.
   *
   * @var array
   */
  public static $createRules = [
    'character_category_id' => 'required',
    'rarity_id'             => 'required',
    'user_id'               => 'nullable',
    'number'                => 'required',
    'slug'                  => 'required|alpha_dash',
    'description'           => 'nullable',
    'sale_value'            => 'nullable',
    'image'                 => 'required|mimes:jpeg,jpg,gif,png|max:20000',
    'thumbnail'             => 'nullable|mimes:jpeg,jpg,gif,png|max:20000',
    'owner_url'             => 'url|nullable',
  ];

  /**
   * Validation rules for character updating.
   *
   * @var array
   */
  public static $updateRules = [
    'character_category_id' => 'required',
    'number'                => 'required',
    'slug'                  => 'required',
    'description'           => 'nullable',
    'sale_value'            => 'nullable',
    'image'                 => 'nullable|mimes:jpeg,jpg,gif,png|max:20000',
    'thumbnail'             => 'nullable|mimes:jpeg,jpg,gif,png|max:20000',
  ];

  /**
   * Validation rules for MYO slots.
   *
   * @var array
   */
  public static $myoRules = [
    'rarity_id'   => 'nullable',
    'user_id'     => 'nullable',
    'number'      => 'nullable',
    'slug'        => 'nullable',
    'description' => 'nullable',
    'sale_value'  => 'nullable',
    'name'        => 'required',
    'image'       => 'nullable|mimes:jpeg,gif,png|max:20000',
    'thumbnail'   => 'nullable|mimes:jpeg,gif,png|max:20000',
  ];

  /**********************************************************************************************

        RELATIONS

   **********************************************************************************************/

  /**
   * Get the user who owns the character.
   */
  public function user() {
    return $this->belongsTo(User::class, 'user_id');
  }

  /**
   * Get the category the character belongs to.
   */
  public function category() {
    return $this->belongsTo(CharacterCategory::class, 'character_category_id');
  }

  /**
   * Get the masterlist image of the character.
   */
  public function image() {
    return $this->belongsTo(CharacterImage::class, 'character_image_id');
  }

  /**
   * Get all images associated with the character.
   *
   * @param mixed|null $user
   */
  public function images($user = null) {
    return $this->hasMany(CharacterImage::class, 'character_id')->images($user);
  }

  /**
   * Get the user-editable profile data of the character.
   */
  public function profile() {
    return $this->hasOne(CharacterProfile::class, 'character_id');
  }

  /**
   * Get the character's active design update.
   */
  public function designUpdate() {
    return $this->hasMany(CharacterDesignUpdate::class, 'character_id');
  }

  /**
   * Get the trade this character is attached to.
   */
  public function trade() {
    return $this->belongsTo(Trade::class, 'trade_id');
  }

  /**
   * Get the trade this character is attached to.
   */
  public function home() {
    return $this->belongsTo('App\Models\WorldExpansion\Location', 'home_id');
  }

  /**
   * Get the faction this character is attached to.
   */
  public function faction() {
    return $this->belongsTo('App\Models\WorldExpansion\Faction', 'faction_id');
  }

  /**
   * Get the rarity of this character.
   */
  public function rarity() {
    return $this->belongsTo(Rarity::class, 'rarity_id');
  }

  public function pets() {
    return $this->hasMany('App\Models\User\UserPet', 'character_id');
  }

  /**
   * Get the character's associated gallery submissions.
   */
  public function gallerySubmissions() {
    return $this->hasMany(GalleryCharacter::class, 'character_id');
  }

  /**
   * Get the character's items.
   */
  public function items() {
    return $this->belongsToMany(Item::class, 'character_items')->withPivot('count', 'data', 'updated_at', 'id')->whereNull('character_items.deleted_at');
  }
  /**
   * Get the character's awards.
   */
  public function awards() {
    return $this->belongsToMany('App\Models\Award\Award', 'character_awards')->withPivot('count', 'data', 'updated_at', 'id')->whereNull('character_awards.deleted_at');
  }

  /**
   * Get all of the likes that are not NULL
   */
  public function characterLikes() {
    return $this->hasMany('App\Models\Character\CharacterLike')->where('character_id', $this->id)->whereNotNull('liked_at');
  }

  /**
   * Get the lineage of the character.
   */
  public function lineage() {
    return $this->hasOne(CharacterLineage::class, 'character_id');
  }

  /**
   * Get the character's children from the lineages.
   */
  public function children() {
    return $this->hasMany(CharacterLineage::class, 'parent_1_id')->orWhere('parent_2_id', $this->id);
  }

  /*
  * Get the links for this character
  */
  public function links() {
    // character id can be in either column
    return $this->hasMany(CharacterRelation::class, 'character_1_id')->orWhere('character_2_id', $this->id);
  }

  /**********************************************************************************************

        SCOPES

   **********************************************************************************************/

  /**
   * Scope a query to only include either characters of MYO slots.
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param bool                                  $isMyo
   *
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeMyo($query, $isMyo = false) {
    return $query->where('is_myo_slot', $isMyo);
  }

  /**
   * Scope a query to only include visible characters.
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param mixed|null                            $user
   *
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeVisible($query, $user = null) {
    if ($user && $user->hasPower('manage_characters')) {
      return $query;
    }

    return $query->where('is_visible', 1);
  }

  /**
   * Scope a query to only include characters that the owners are interested in trading.
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   *
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeTrading($query) {
    return $query->where('is_trading', 1);
  }

  /**
   * Scope a query to only include characters that can be traded.
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   *
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeTradable($query) {
    return $query->where(function ($query) {
      $query->whereNull('transferrable_at')->orWhere('transferrable_at', '<', Carbon::now());
    })->where(function ($query) {
      $query->where('is_sellable', 1)->orWhere('is_tradeable', 1)->orWhere('is_giftable', 1);
    });
  }

  /**********************************************************************************************

        ACCESSORS

   **********************************************************************************************/

  /**
   * Get the character's availability for activities/transfer.
   *
   * @return bool
   */
  public function getIsAvailableAttribute() {
    if ($this->designUpdate()->active()->exists()) {
      return false;
    }
    if ($this->trade_id) {
      return false;
    }
    if (CharacterTransfer::active()->where('character_id', $this->id)->exists()) {
      return false;
    }

    return true;
  }

  /**
   * Display the owner's name.
   * If the owner is not a registered user on the site, this displays the owner's dA name.
   *
   * @return string
   */
  public function getDisplayOwnerAttribute() {
    if ($this->user_id) {
      return $this->user->displayName;
    } else {
      return prettyProfileLink($this->owner_url);
    }
  }

  /**
   * Gets the character's code.
   * If this is a MYO slot, it will return the MYO slot's name.
   *
   * @return string
   */
  public function getSlugAttribute() {
    if ($this->is_myo_slot) {
      return $this->name;
    } else {
      return $this->attributes['slug'];
    }
  }

  /**
   * Displays the character's name, linked to their character page.
   *
   * @return string
   */
  public function getDisplayNameAttribute() {
    return '<a href="' . $this->url . '" class="display-character">' . $this->fullName . '</a>';
  }
  /**
   * Displays the character's name, linked to their character page.
   *
   * @return string
   */
  public function getOnlyNameAttribute() {
    return '<a href="' . $this->url . '" class="display-character">' . $this->name . '</a>';
  }

  /**
   * Gets the character's name, including their code and user-assigned name.
   * If this is a MYO slot, simply returns the slot's name.
   *
   * @return string
   */
  public function getFormattedNameAttribute() {
    if ($this->is_myo_slot) {
      return $this->name;
    } else {
      $name = '<a class="name h5 mb-0" href="' . $this->url . '">' . (!$this->is_visible ? '<i class="fas fa-eye-slash"></i>' : '') . ' ' . $this->name . ' </a>';
      $slug = '<a class="slug mb-0" href="' . $this->url . '">' . $this->slug . '</a>';
      // $owner = '<a href="' . $this->url . '">' . $this->displayOwner . '</a>';
      return '<div class="grid pc-center pi-center">' . $name . ' ' . $slug . '' . '</div>';
    }
  }
  public function getFullNameAttribute() {
    if ($this->is_myo_slot) {
      return $this->name;
    } else {
      return $this->slug . ($this->name ? ': ' . $this->name : '');
    }
  }
  public function getNameFallbackAttribute() {
    if ($this->is_myo_slot) {
      return $this->name;
    } else {
      return ($this->name ? $this->name : $this->slug);
    }
  }

  /**
   * Gets the character's warnings, if they exist.
   */
  public function getWarningsAttribute() {
    if (config('lorekeeper.settings.enable_character_content_warnings') && $this->image->content_warnings) {
      return '<i class="fa fa-exclamation-triangle text-danger" data-bs-toggle="tooltip" title="' . implode(', ', $this->image->content_warnings) . '"></i> ';
    }

    return null;
  }

  /**
   * Gets the character's page's URL.
   *
   * @return string
   */
  public function getUrlAttribute() {
    if ($this->is_myo_slot) {
      return url('myo/' . $this->id);
    } else {
      return url('character/' . $this->slug);
    }
  }

  /**
   * Gets the character's asset type for asset management.
   *
   * @return string
   */
  public function getAssetTypeAttribute() {
    return 'characters';
  }

  /**
   * Gets the character's log type for log creation.
   *
   * @return string
   */
  public function getLogTypeAttribute() {
    return 'Character';
  }

  public function getHomeSettingAttribute() {
    return intval(Settings::get('WE_character_locations'));
  }

  public function getLocationAttribute() {
    $setting = $this->homeSetting;

    switch ($setting) {
      case 1:
        if (!$this->user) {
          return null;
        } elseif (!$this->user->home) {
          return null;
        } else {
          return $this->user->home->fullDisplayName;
        }

      case 2:
        if (!$this->home) {
          return null;
        } else {
          return $this->home->fullDisplayName;
        }

      case 3:
        if (!$this->home) {
          return null;
        } else {
          return $this->home->fullDisplayName;
        }

      default:
        return null;
    }
  }

  public function getFactionSettingAttribute() {
    return intval(Settings::get('WE_character_factions'));
  }

  public function getCurrentFactionAttribute() {
    $setting = $this->factionSetting;

    switch ($setting) {
      case 1:
        if (!$this->user) {
          return null;
        } elseif (!$this->user->faction) {
          return null;
        } else {
          return $this->user->faction->fullDisplayName;
        }

      case 2:
        if (!$this->faction) {
          return null;
        } else {
          return $this->faction->fullDisplayName;
        }

      case 3:
        if (!$this->faction) {
          return null;
        } else {
          return $this->faction->fullDisplayName;
        }

      default:
        return null;
    }
  }

  /**
   * Get character's faction rank.
   */
  public function getFactionRankAttribute() {
    if (!isset($this->faction_id) || !$this->faction->ranks()->count()) {
      return null;
    }
    if (FactionRankMember::where('member_type', 'character')->where('member_id', $this->id)->first()) {
      return FactionRankMember::where('member_type', 'character')->where('member_id', $this->id)->first()->rank;
    }
    if ($this->faction->ranks()->where('is_open', 1)->count()) {
      $standing = $this->getCurrencies(true)->where('id', Settings::get('WE_faction_currency'))->first();
      if (!$standing) {
        return $this->faction->ranks()->where('is_open', 1)->where('breakpoint', 0)->first();
      }

      return $this->faction->ranks()->where('is_open', 1)->where('breakpoint', '<=', $standing->quantity)->orderBy('breakpoint', 'DESC')->first();
    }
  }

  /**
   * Gets the character's trading, gift art and gift writing status as badges.
   * If this is a MYO slot, only returns trading status.
   *
   * @return string
   */
  public function getMiniBadgeAttribute() {
    $tradingCode = $this->is_trading ? 'badge-success' : 'badge-danger';
    $tradingSection = "<span class='badge " . $tradingCode . "'><i class='fas fa-comments-dollar'></i></span>";
    $nonMyoSection = '';

    if (!$this->is_myo_slot) {
      $artCode = $this->is_gift_art_allowed == 1 ? 'badge-success' : ($this->is_gift_art_allowed == 2 ? 'badge-warning text-light' : 'badge-danger');
      $writingCode = $this->is_gift_writing_allowed == 1 ? 'badge-success' : ($this->is_gift_writing_allowed == 2 ? 'badge-warning text-light' : 'badge-danger');
      $nonMyoSection = "<span class='badge " . $artCode . "'><i class='fas fa-pencil-ruler'></i></span> <span class='badge " . $writingCode . "'><i class='fas fa-file-alt'></i></span> ";
    }

    return ' ・ <i class="fas fa-info-circle help-icon m-0" data-bs-toggle="tooltip" data-html="true" title="' . $nonMyoSection . $tradingSection . '"></i>';
  }

  /**********************************************************************************************

        OTHER FUNCTIONS

   **********************************************************************************************/

  /**
   * Checks if the character's owner has registered on the site and updates ownership accordingly.
   */
  public function updateOwner() {
    // Return if the character has an owner on the site already.
    if ($this->user_id) {
      return;
    }

    // Check if the owner has an account and update the character's user ID for them.
    $owner = checkAlias($this->owner_url);
    if (is_object($owner)) {
      $this->user_id = $owner->id;
      $this->owner_url = null;
      $this->save();

      $owner->settings->is_fto = 0;
      $owner->settings->save();
    }
  }

  /**
   * Get the character's held currencies.
   *
   * @param bool $showAll
   *
   * @return \Illuminate\Support\Collection
   */
  public function getCurrencies($showAll = false) {
    // Get a list of currencies that need to be displayed
    // On profile: only ones marked is_displayed
    // In bank: ones marked is_displayed + the ones the user has

    $owned = CharacterCurrency::where('character_id', $this->id)->pluck('quantity', 'currency_id')->toArray();

    $currencies = Currency::where('is_character_owned', 1);
    if ($showAll) {
      $currencies->where(function ($query) use ($owned) {
        $query->where('is_displayed', 1)->orWhereIn('id', array_keys($owned));
      });
    } else {
      $currencies = $currencies->where('is_displayed', 1);
    }

    $currencies = $currencies->orderBy('sort_character', 'DESC')->get();

    foreach ($currencies as $currency) {
      $currency->quantity = $owned[$currency->id] ?? 0;
    }

    return $currencies;
  }

  /**
   * Get the character's held currencies as an array for select inputs.
   *
   * @return array
   */
  public function getCurrencySelect() {
    return CharacterCurrency::where('character_id', $this->id)->leftJoin('currencies', 'character_currencies.currency_id', '=', 'currencies.id')->orderBy('currencies.sort_character', 'DESC')->get()->pluck('name_with_quantity', 'currency_id')->toArray();
  }

  /**
   * Get the character's currency logs.
   *
   * @param int $limit
   *
   * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection
   */
  public function getCurrencyLogs($limit = 10) {
    $character = $this;
    $query = CurrencyLog::with('currency')->where(function ($query) use ($character) {
      $query->with('sender.rank')->where('sender_type', 'Character')->where('sender_id', $character->id)->where('log_type', '!=', 'Staff Grant');
    })->orWhere(function ($query) use ($character) {
      $query->with('recipient.rank')->where('recipient_type', 'Character')->where('recipient_id', $character->id)->where('log_type', '!=', 'Staff Removal');
    })->orderBy('id', 'DESC');
    if ($limit) {
      return $query->take($limit)->get();
    } else {
      return $query->paginate(30);
    }
  }

  /**
   * Get the character's item logs.
   *
   * @param int $limit
   *
   * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection
   */
  public function getItemLogs($limit = 10) {
    $character = $this;

    $query = ItemLog::with('item')->where(function ($query) use ($character) {
      $query->with('sender.rank')->where('sender_type', 'Character')->where('sender_id', $character->id)->where('log_type', '!=', 'Staff Grant');
    })->orWhere(function ($query) use ($character) {
      $query->with('recipient.rank')->where('recipient_type', 'Character')->where('recipient_id', $character->id)->where('log_type', '!=', 'Staff Removal');
    })->orderBy('id', 'DESC');

    if ($limit) {
      return $query->take($limit)->get();
    } else {
      return $query->paginate(30);
    }
  }

  /**
   * Get the character's award logs.
   *
   * @param  int  $limit
   * @return \Illuminate\Support\Collection|\Illuminate\Pagination\LengthAwarePaginator
   */
  public function getAwardLogs($limit = 10) {
    $character = $this;

    $query = AwardLog::with('award')->where(function ($query) use ($character) {
      $query->with('sender.rank')->where('sender_type', 'Character')->where('sender_id', $character->id)->where('log_type', '!=', 'Staff Grant');
    })->orWhere(function ($query) use ($character) {
      $query->with('recipient.rank')->where('recipient_type', 'Character')->where('recipient_id', $character->id)->where('log_type', '!=', 'Staff Removal');
    })->orderBy('id', 'DESC');

    if ($limit) return $query->take($limit)->get();
    else return $query->paginate(30);
  }

  /**
   * Get the character's ownership logs.
   *
   * @return \Illuminate\Pagination\LengthAwarePaginator
   */
  public function getOwnershipLogs() {
    $query = UserCharacterLog::with('sender.rank')->with('recipient.rank')->where('character_id', $this->id)->orderBy('id', 'DESC');

    return $query->paginate(30);
  }

  /**
   * Get the character's update logs.
   *
   * @return \Illuminate\Pagination\LengthAwarePaginator
   */
  public function getCharacterLogs() {
    $query = CharacterLog::with('sender.rank')->where('character_id', $this->id)->orderBy('id', 'DESC');

    return $query->paginate(30);
  }

  /**
   * Get submissions that the character has been included in.
   *
   * @return \Illuminate\Pagination\LengthAwarePaginator
   */
  public function getSubmissions() {
    return Submission::with('user.rank')->with('prompt')->where('status', 'Approved')->whereIn('id', SubmissionCharacter::where('character_id', $this->id)->pluck('submission_id')->toArray())->paginate(30);

    // Untested
    // $character = $this;
    // return Submission::where('status', 'Approved')->with(['characters' => function($query) use ($character) {
    //    $query->where('submission_characters.character_id', 1);
    // }])
    // ->whereHas('characters', function($query) use ($character) {
    //    $query->where('submission_characters.character_id', 1);
    // });
    // return Submission::where('status', 'Approved')->where('user_id', $this->id)->orderBy('id', 'DESC')->paginate(30);
  }

  /**
   * Notifies character's bookmarkers in case of a change.
   *
   * @param mixed $type
   */
  public function notifyBookmarkers($type) {
    // Bookmarkers will not be notified if the character is set to not visible
    if ($this->is_visible) {
      $column = null;
      switch ($type) {
        case 'BOOKMARK_TRADING':
          $column = 'notify_on_trade_status';
          break;
        case 'BOOKMARK_GIFTS':
          $column = 'notify_on_gift_art_status';
          break;
        case 'BOOKMARK_GIFT_WRITING':
          $column = 'notify_on_gift_writing_status';
          break;
        case 'BOOKMARK_OWNER':
          $column = 'notify_on_transfer';
          break;
        case 'BOOKMARK_IMAGE':
          $column = 'notify_on_image';
          break;
      }

      // The owner of the character themselves will not be notified, in the case that
      // they still have a bookmark on the character after it was transferred to them
      $bookmarkers = CharacterBookmark::where('character_id', $this->id)->where('user_id', '!=', $this->user_id);
      if ($column) {
        $bookmarkers = $bookmarkers->where($column, 1);
      }

      $bookmarkers = User::whereIn('id', $bookmarkers->pluck('user_id')->toArray())->get();

      // This may have to be redone more efficiently in the case of large numbers of bookmarkers,
      // but since we're not expecting many users on the site to begin with it should be fine
      foreach ($bookmarkers as $bookmarker)
        Notifications::create($type, $bookmarker, [
          'character_url' => $this->url,
          'character_name' => $this->fullName
        ]);
    }
  }


  /**
   * Finds the lineage blacklist level of this character.
   * 0 is no restriction at all
   * 1 is ancestors but no children
   * 2 is no lineage at all
   *
   * @return int
   */
  public function getLineageBlacklistLevel($maxLevel = 2) {
    return CharacterLineageBlacklist::getBlacklistLevel($this, $maxLevel);
  }

  /**
   * Gets the character's parent type (ex father, mother, parent) based on sex
   *
   */
  public function getParentTypeAttribute() {
    if (!$this->image->sex) {
      return "Parent";
    } else if ($this->image->sex == "Male") {
      return "Father";
    } else {
      return "Mother";
    }
  }
}
