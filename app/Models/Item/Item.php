<?php

namespace App\Models\Item;

use DB;
use Auth;
use Config;
use App\Models\Cultivation\CultivationPlot;
use App\Models\Cultivation\CultivationArea;
// use App\Model;
use App\Models\Model;
use App\Models\Item\ItemCategory;
use App\Models\Shop\Shop;
use App\Models\Prompt\Prompt;
use App\Models\Rarity;
use App\Models\Shop\ShopStock;
use App\Models\User\User;


class Item extends Model {
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'item_category_id',
    'name',
    'has_image',
    'description',
    'parsed_description',
    'allow_transfer',
    'data',
    'reference_url',
    'artist_alias',
    'artist_url',
    'artist_id',
    'is_released',
    'hash',
    'is_deletable',
  ];

  protected $appends = ['image_url'];

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'items';

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'data' => 'array',
  ];

  /**
   * The relationships that should always be loaded.
   *
   * @var array
   */
  protected $with = [
    'tags',
  ];

  /**
   * Validation rules for creation.
   *
   * @var array
   */
  public static $createRules = [
    'item_category_id'   => 'nullable',
    'name'               => 'required|unique:items|between:3,100',
    'description'        => 'nullable',
    'image'              => 'mimes:png',
    'rarity_id'          => 'nullable',
    'reference_url'      => 'nullable|between:3,200',
    'uses'               => 'nullable|between:3,250',
    'release'            => 'nullable|between:3,100',
    'currency_quantity'  => 'nullable|integer|min:1',
  ];

  /**
   * Validation rules for updating.
   *
   * @var array
   */
  public static $updateRules = [
    'item_category_id'  => 'nullable',
    'name'              => 'required|between:3,100',
    'description'       => 'nullable',
    'image'             => 'mimes:png',
    'reference_url'     => 'nullable|between:3,200',
    'uses'              => 'nullable|between:3,250',
    'release'           => 'nullable|between:3,100',
    'currency_quantity' => 'nullable|integer|min:1',
  ];

  /**********************************************************************************************

        RELATIONS

   **********************************************************************************************/

  /**
   * Get the category the item belongs to.
   */
  public function category() {
    return $this->belongsTo(ItemCategory::class, 'item_category_id');
  }

  /**
   * Get the item's tags.
   */
  public function tags() {
    return $this->hasMany(ItemTag::class, 'item_id');
  }

  /**
   * Get the user that drew the item art.
   */
  public function artist() {
    return $this->belongsTo(User::class, 'artist_id');
  }

  /**
   * Gets the item's rarity.
   */
  public function rarity() {
    return $this->belongsTo(Rarity::class, $this->attributes['rarity_id'] ?? null, 'id');
  }

  /**
   * Get shop stock for this item.
   */
  public function shopStock() {
    return $this->hasMany(ShopStock::class, 'item_id')->where('is_visible', 1);
  }

  /**********************************************************************************************

        SCOPES

   **********************************************************************************************/

  /**
   * Scope a query to sort items in alphabetical order.
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param bool                                  $reverse
   *
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeSortAlphabetical($query, $reverse = false) {
    return $query->orderBy('name', $reverse ? 'DESC' : 'ASC');
  }

  /**
   * Scope a query to sort items in category order.
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   *
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeSortCategory($query) {
    if (ItemCategory::all()->count()) {
      return $query->orderBy(ItemCategory::select('sort')->whereColumn('items.item_category_id', 'item_categories.id'), 'DESC');
    }

    return $query;
  }

  /**
   * Scope a query to sort items by newest first.
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   *
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeSortNewest($query) {
    return $query->orderBy('id', 'DESC');
  }

  /**
   * Scope a query to sort features oldest first.
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   *
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeSortOldest($query) {
    return $query->orderBy('id');
  }

  /**
   * Scope a query to show only released or "released" (at least one user-owned stack has ever existed) items.
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param mixed|null                            $user
   *
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeReleased($query, $user = null) {
    if ($user && $user->hasPower('edit_data')) {
      return $query;
    }

    return $query->where('is_released', 1);
  }

  /**********************************************************************************************

        ACCESSORS

   **********************************************************************************************/

  /**
   * Displays the model's name, linked to its encyclopedia page.
   *
   * @return string
   */
  public function getDisplayNameAttribute() {
    return '<a href="' . $this->url . '" class="display-item">' . $this->name . '</a>';
  }

  /**
   * Gets the file directory containing the model's image.
   *
   * @return string
   */
  public function getImageDirectoryAttribute() {
    return 'images/data/items';
  }

  /**
   * Gets the file name of the model's image.
   *
   * @return string
   */
  public function getImageFileNameAttribute() {
    return $this->id . '-' . $this->hash . '-image.png';
  }

  /**
   * Gets the path to the file directory containing the model's image.
   *
   * @return string
   */
  public function getImagePathAttribute() {
    return public_path($this->imageDirectory);
  }

  /**
   * Gets the URL of the model's image.
   *
   * @return string
   */
  public function getImageUrlAttribute() {
    if (!$this->has_image) {
      return null;
    }

    return asset($this->imageDirectory . '/' . $this->imageFileName);
  }

  /**
   * Gets the URL of the model's encyclopedia page.
   *
   * @return string
   */
  public function getUrlAttribute() {
    return url('world/items?name=' . $this->name);
  }

  /**
   * Gets the URL of the individual item's page, by ID.
   *
   * @return string
   */
  public function getIdUrlAttribute() {
    return url('world/items/' . $this->id);
  }

  /**
   * Gets the currency's asset type for asset management.
   *
   * @return string
   */
  public function getAssetTypeAttribute() {
    return 'items';
  }

  /**
   * Get the artist of the item's image.
   *
   * @return string
   */
  public function getItemArtistAttribute() {
    if (!$this->artist_url && !$this->artist_id) {
      return null;
    }

    // Check to see if the artist exists on site
    $artist = checkAlias($this->artist_url, false);
    if (is_object($artist)) {
      $this->artist_id = $artist->id;
      $this->artist_url = null;
      $this->save();
    }

    if ($this->artist_id) {
      return $this->artist->displayName;
    } elseif ($this->artist_url) {
      return prettyProfileLink($this->artist_url);
    }
  }

  /**
   * Get the reference url attribute.
   *
   * @return string
   */
  public function getReferenceAttribute() {
    if (!$this->reference_url) {
      return null;
    }

    return $this->reference_url;
  }

  /**
   * Get the rarity attribute.
   *
   * @return string
   */
  public function getRarityIdAttribute() {
    if (!isset($this->data) || !isset($this->data['rarity_id'])) {
      return null;
    }

    return $this->data['rarity_id'];
  }

  /**
   * Get the uses attribute.
   *
   * @return string
   */
  public function getUsesAttribute() {
    if (!$this->data) return null;
    return isset($this->data['uses']) && $this->data['uses'] ? $this->data['uses'] : null;
  }

  /**
   * Get the source attribute.
   *
   * @return string
   */
  public function getSourceAttribute() {
    if (!$this->data) return null;
    return isset($this->data['release']) && $this->data['release'] ? $this->data['release'] : null;
  }

  /**
   * Get the resale attribute.
   *
   * @return string
   */
  public function getResellAttribute() {
    if (!$this->data) return null;
    return isset($this->data['resell']) && $this->data['resell'] ? $this->data['resell'] : null;
  }

  /**
   * Get the prompts attribute as an associative array.
   *
   * @return array
   */
  public function getPromptsAttribute() {
    if (!$this->data) {
      return null;
    }
    $itemPrompts = $this->data['prompts'];

    if (count($itemPrompts)) {
      return Prompt::whereIn('id', $itemPrompts)->get();
    } else {
      return null;
    }
    if (count($itemPrompts)) {
      return Prompt::whereIn('id', $itemPrompts)->get();
    } else {
      return null;
    }
  }

  /**
   * Gets the admin edit URL.
   *
   * @return string
   */
  public function getAdminUrlAttribute() {
    return url('admin/data/items/edit/' . $this->id);
  }

  /**
   * Gets the power required to edit this model.
   *
   * @return string
   */
  public function getAdminPowerAttribute() {
    return 'edit_data';
  }

  /**
   * Check if an item can be donated.
   *
   * @return bool
   */
  public function getCanDonateAttribute() {
    if (!$this->allow_transfer) return 0;
    $setting = Config::get('lorekeeper.settings.donation_shop.item_donations');
    switch ($setting) {
      case 0:
        return 1;
      case 1:
        if ($this->category->can_donate) return 1;
        else return 0;
      case 2:
        if ($this->hasTag('donateable')) return 1;
        else return 0;
      case 3:
        if ($this->category->can_donate) return 1;
        elseif ($this->hasTag('donateable')) return 1;
        else return 0;
    };
    return 0;
  }

  /**
   * Check if an item can be donated.
   *
   * @return bool
   */
  public function getCanUserSellAttribute() {
    //borrowed idea from donation shop
    //it makes it a lot cleaner to check if a thing can be sold in a user shop
    //ty merc :)

    if (Auth::check() && Auth::user()->hasPower('edit_inventories')) return 1;
    if (!$this->allow_transfer) return 0;
    if (!$this->category) return 1;
    if ($this->category && $this->category->can_user_sell) return 1;
    else return 0;
  }

  /**********************************************************************************************

        OTHER FUNCTIONS

   **********************************************************************************************/

  /**
   * Checks if the item has a particular tag.
   *
   * @param mixed $tag
   *
   * @return bool
   */
  public function hasTag($tag) {
    return $this->tags()->where('tag', $tag)->where('is_active', 1)->exists();
  }

  /**
   * Gets a particular tag attached to the item.
   *
   * @param mixed $tag
   *
   * @return ItemTag
   */
  public function tag($tag) {
    return $this->tags()->where('tag', $tag)->where('is_active', 1)->first();
  }


  /**
   * Gets the rewards of the linked seed item tag if it exists.
   *
   */
  public function seedRewards() {
    if ($this->tag('seed')) {
      $assets = [];
      $rewards = $this->tag('seed')->getData()['rewards'];
      foreach ($rewards as $reward) {
        switch ($reward->rewardable_type) {
          case 'Item':
            $type = 'App\Models\Item\Item';
            break;
          case 'Currency':
            $type = 'App\Models\Currency\Currency';
            break;
          case 'LootTable':
            $type = 'App\Models\Loot\LootTable';
            break;
          case 'Raffle':
            $type = 'App\Models\Raffle\Raffle';
            break;
        }
        $asset = $type::find($reward->rewardable_id);
        $assets[] = ['asset' => $asset, 'quantity' => $reward->quantity];
      }
      return $assets;
    }
    return null;
  }

  /**
   * Gets the plot a tool item unlocks.
   *
   */
  public function toolPlot() {
    if ($this->tag('tool')) {
      return CultivationPlot::where('id', $this->tag('tool')->getData()['plot_id'])->first();
    }
    return null;
  }

  /**
   * Gets the area a exploration item unlocks.
   *
   */
  public function explorationArea() {
    if ($this->tag('exploration')) {
      return CultivationArea::where('id', $this->tag('exploration')->getData()['area_id'])->first();
    }
    return null;
  }

  /**
   * Get the shops that stock this item.
   *
   * @param mixed|null $user
   *
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function shops($user = null) {
    if (!config('lorekeeper.extensions.item_entry_expansion.extra_fields') || !$this->shop_stock_count) {
      return null;
    }

    $shops = Shop::where(function ($query) use ($user) {
      if ($user && $user->hasPower('edit_data')) {
        return $query;
      }

      return $query->where('is_hidden', 0)->where('is_staff', 0);
    })->whereIn('id', $this->shopStock->pluck('shop_id')->toArray())->get();

    return $shops;
  }
}
