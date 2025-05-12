<?php

namespace App\Http\Controllers;

// use Auth;
use Illuminate\Support\Facades\Auth;
use Config;
use App\Models\User\User;
use App\Models\Border\Border;
use App\Models\Border\BorderCategory;

use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyCategory;
use App\Models\Feature\Feature;
use App\Models\Award\AwardCategory;
use App\Models\Award\Award;
use App\Models\Feature\FeatureCategory;
use App\Models\Item\Item;
use App\Models\Item\ItemCategory;
use App\Models\Prompt\Prompt;
use App\Models\Prompt\PromptCategory;
use App\Models\Pet\Pet;
use App\Models\Pet\PetCategory;
use App\Models\Rarity;
use App\Models\Recipe\Recipe;
use App\Models\Shop\Shop;
use App\Models\Shop\ShopStock;
use App\Models\Species\Species;
use App\Models\Species\Subtype;
use Illuminate\Http\Request;
use App\Models\Character\CharacterTransformation as Transformation;
use App\Models\Character\CharacterCategory;
use App\Models\Map\Map;
use App\Models\User\UserAward;

class WorldController extends Controller {
  /*
    |--------------------------------------------------------------------------
    | World Controller
    |--------------------------------------------------------------------------
    |
    | Displays information about the world, as entered in the admin panel.
    | Pages displayed by this controller form the site's encyclopedia.
    |
     */

  /**
   * Shows the index page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getIndex() {
    return view('world.index');
  }

  /**
   * Shows the currency categories page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getCurrencyCategories(Request $request) {
    $query = CurrencyCategory::query();
    $name = $request->get('name');
    if ($name) {
      $query->where('name', 'LIKE', '%' . $name . '%');
    }

    return view('world.currency_categories', [
      'categories' => $query->visible(Auth::user() ?? null)->orderBy('sort', 'DESC')->orderBy('id')->paginate(20)->appends($request->query()),
    ]);
  }

  /**
   * Shows the currency page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getCurrencies(Request $request) {
    $query = Currency::query()->visible(Auth::user() ?? null)->with('category')->where(function ($query) {
      $query->whereHas('category', function ($query) {
        $query->visible(Auth::user() ?? null);
      })->orWhereNull('currency_category_id');
    });

    $data = $request->only(['currency_category_id', 'name', 'sort']);
    if (isset($data['name'])) {
      $query->where(function ($query) use ($data) {
        $query->where('name', 'LIKE', '%' . $data['name'] . '%')->orWhere('abbreviation', 'LIKE', '%' . $data['name'] . '%');
      });
    }
    if (isset($data['currency_category_id'])) {
      if ($data['currency_category_id'] == 'withoutOption') {
        $query->whereNull('currency_category_id');
      } else {
        $query->where('currency_category_id', $data['currency_category_id']);
      }
    }

    if (isset($data['sort'])) {
      switch ($data['sort']) {
        case 'alpha':
          $query->sortAlphabetical();
          break;
        case 'alpha-reverse':
          $query->sortAlphabetical(true);
          break;
        case 'category':
          $query->sortCategory();
          break;
        case 'newest':
          $query->sortNewest();
          break;
        case 'oldest':
          $query->sortOldest();
          break;
      }
    } else {
      $query->sortCategory();
    }


    return view('world.currencies', [
      'currencies' => $query->visible(Auth::user() ?? null)->orderBy('name')->orderBy('id')->paginate(20)->appends($request->query()),
      'categories' => ['withoutOption' => 'Without Category'] + CurrencyCategory::visible(Auth::user() ?? null)->orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
    ]);
  }

  /**
   * Shows the rarity page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getRarities(Request $request) {
    $query = Rarity::query();
    $name = $request->get('name');
    if ($name) { {
        $query->where('name', 'LIKE', '%' . $name . '%');
      }
    }

    return view('world.rarities', [
      'rarities' => $query->orderBy('sort', 'DESC')->orderBy('id')->paginate(20)->appends($request->query()),
    ]);
  }

  /**
   * Shows the species page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getSpecieses(Request $request) {
    $query = Species::query();

    if (config('lorekeeper.extensions.species_trait_index.enable')) {
      $query->withCount('features');
    }

    $name = $request->get('name');
    if ($name) { {
        $query->where('name', 'LIKE', '%' . $name . '%');
      }
    }

    return view('world.specieses', [
      'specieses' => $query->with(['subtypes' => function ($query) {
        $query->visible(Auth::user() ?? null)->orderBy('sort', 'DESC');
      }])->visible(Auth::user() ?? null)->orderBy('sort', 'DESC')->orderBy('id')->paginate(20)->appends($request->query()),
    ]);
  }

  /**
   * Shows the subtypes page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getSubtypes(Request $request) {
    $query = Subtype::query()->with('species');
    $name = $request->get('name');
    if ($name) { {
        $query->where('name', 'LIKE', '%' . $name . '%');
      }
    }

    return view('world.subtypes', [
      'subtypes' => $query->visible(Auth::user() ?? null)->orderBy('sort', 'DESC')->orderBy('id')->paginate(20)->appends($request->query()),
    ]);
  }

  /**
   * Shows the item categories page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getItemCategories(Request $request) {
    $query = ItemCategory::query();
    $name = $request->get('name');
    if ($name) { {
        $query->where('name', 'LIKE', '%' . $name . '%');
      }
    }

    return view('world.item_categories', [
      'categories' => $query->visible(Auth::user() ?? null)->orderBy('sort', 'DESC')->orderBy('id')->paginate(20)->appends($request->query()),
    ]);
  }

  /**
   * Shows the award categories page.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getAwardCategories(Request $request) {
    $query = AwardCategory::query();
    $name = $request->get('name');
    if ($name) $query->where('name', 'LIKE', '%' . $name . '%');
    return view('world.award_categories', [
      'categories' => $query->orderBy('sort', 'DESC')->paginate(20)->appends($request->query()),
    ]);
  }

  /**
   * Shows the trait categories page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getFeatureCategories(Request $request) {
    $query = FeatureCategory::query();
    $name = $request->get('name');
    if ($name) { {
        $query->where('name', 'LIKE', '%' . $name . '%');
      }
    }

    return view('world.feature_categories', [
      'categories' => $query->visible(Auth::user() ?? null)->orderBy('sort', 'DESC')->orderBy('id')->paginate(20)->appends($request->query()),
    ]);
  }

  /**
   * Shows the traits page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getFeatures(Request $request) {
    $query = Feature::visible(Auth::user() ?? null)->with('category', 'rarity', 'species', 'subtype');

    $data = $request->only(['rarity_id', 'feature_category_id', 'species_id', 'subtype_id', 'name', 'sort']);

    if (isset($data['rarity_id']) && $data['rarity_id'] != 'none') { {
        $query->where('rarity_id', $data['rarity_id']);
      }
    }

    if (isset($data['feature_category_id']) && $data['feature_category_id'] != 'none') { {
        if ($data['feature_category_id'] == 'withoutOption') {
          $query->whereNull('feature_category_id');
        } else {
          $query->where('feature_category_id', $data['feature_category_id']);
        }
      }
    }

    if (isset($data['species_id']) && $data['species_id'] != 'none') { {
        if ($data['species_id'] == 'withoutOption') {
          $query->whereNull('species_id');
        } else {
          $query->where('species_id', $data['species_id']);
        }
      }
      if (isset($data['subtype_id']) && $data['subtype_id'] != 'none') {
        if ($data['subtype_id'] == 'withoutOption') {
          $query->whereNull('subtype_id');
        } else {
          $query->where('subtype_id', $data['subtype_id']);
        }
      }
    }

    if (isset($data['name'])) { {
        $query->where('name', 'LIKE', '%' . $data['name'] . '%');
      }
    }

    if (isset($data['sort'])) {
      switch ($data['sort']) {
        case 'alpha':
          $query->sortAlphabetical();
          break;
        case 'alpha-reverse':
          $query->sortAlphabetical(true);
          break;
        case 'category':
          $query->sortCategory();
          break;
        case 'rarity':
          $query->sortRarity();
          break;
        case 'rarity-reverse':
          $query->sortRarity(true);
          break;
        case 'species':
          $query->sortSpecies();
          break;
        case 'subtypes':
          $query->sortSubtype();
          break;
        case 'newest':
          $query->sortNewest();
          break;
        case 'oldest':
          $query->sortOldest();
          break;
      }
    } else {
      $query->sortCategory();
    }

    return view('world.features', [
      'features'   => $query->orderBy('id')->paginate(20)->appends($request->query()),
      'rarities'   => ['none' => 'Any Rarity'] + Rarity::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
      'specieses'  => ['none' => 'Any ' . ucfirst(__('lorekeeper.species'))] + ['withoutOption' => 'Without Species'] + Species::visible(Auth::user() ?? null)->orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
      'subtypes'   => ['none' => 'Any Subtype'] + ['withoutOption' => 'Without Subtype'] + Subtype::visible(Auth::user() ?? null)->orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
      'categories' => ['none' => 'Any Category'] + ['withoutOption' => 'Without Category'] + FeatureCategory::visible(Auth::user() ?? null)->orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
    ]);
  }

  /**
   * Shows a species' visual trait list.
   *
   * @param mixed $id
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getSpeciesFeatures($id) {
    $categories = FeatureCategory::orderBy('sort', 'DESC')->get();
    $rarities = Rarity::orderBy('sort', 'ASC')->get();

    $species = Species::visible(Auth::user() ?? null)->where('id', $id)->first();
    if (!$species) {
      abort(404);
    }
    if (!config('lorekeeper.extensions.visual_trait_index.enable_species_index')) {
      abort(404);
    }

    $features = count($categories)
      ? $species
      ->features()
      ->visible(Auth::user() ?? null)
      ->with('rarity', 'subtype')
      ->orderByRaw('FIELD(feature_category_id,' . implode(',', $categories->pluck('id')->toArray()) . ')')
      ->orderByRaw('FIELD(rarity_id,' . implode(',', $rarities->pluck('id')->toArray()) . ')')
      ->orderBy('has_image', 'DESC')
      ->orderBy('name')
      ->get()
      ->filter(function ($feature) {
        if ($feature->subtype) {
          return $feature->subtype->is_visible;
        }
        return true;
      })
      ->groupBy(['feature_category_id', 'id'])
      : $species
      ->features()
      ->visible(Auth::check() ? Auth::user() : null)
      ->with('rarity', 'subtype')
      ->orderByRaw('FIELD(rarity_id,' . implode(',', $rarities->pluck('id')->toArray()) . ')')
      ->orderBy('has_image', 'DESC')
      ->orderBy('name')
      ->get()
      ->filter(function ($feature) {
        if ($feature->subtype) {
          return $feature->subtype->is_visible;
        }
        return true;
      })
      ->groupBy(['feature_category_id', 'id']);

    return view('world.species_features', [
      'species'    => $species,
      'categories' => $categories->keyBy('id'),
      'rarities'   => $rarities->keyBy('id'),
      'features'   => $features,
    ]);
  }

  /**
   * Shows a subtype's visual trait list.
   *
   * @param mixed $id
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getSubtypeFeatures($id, Request $request) {
    $categories = FeatureCategory::orderBy('sort', 'DESC')->get();
    $rarities = Rarity::orderBy('sort', 'ASC')->get();
    $speciesBasics = $request->get('add_basics');
    $subtype = Subtype::visible(Auth::user() ?? null)->where('id', $id)->first();
    $species = Species::visible(Auth::user() ?? null)->where('id', $subtype->species->id)->first();
    if (!$subtype) {
      abort(404);
    }
    if (!config('lorekeeper.extensions.visual_trait_index.enable_subtype_index')) {
      abort(404);
    }

    $features = $speciesBasics ? $species : $subtype;
    $features = $features->features()->visible(Auth::user() ?? null);
    $features = count($categories) ?
      $features->orderByRaw('FIELD(feature_category_id,' . implode(',', $categories->pluck('id')->toArray()) . ')') :
      $features;
    $features = $features->orderByRaw('FIELD(rarity_id,' . implode(',', $rarities->pluck('id')->toArray()) . ')')
      ->orderBy('has_image', 'DESC')
      ->orderBy('name')
      ->get();

    if (!$speciesBasics) {
      $features = $features->groupBy(['feature_category_id', 'id']);
    } else {
      $features = $features
        ->filter(function ($feature) use ($subtype) {
          return !($feature->subtype && $feature->subtype->id != $subtype->id);
        })
        ->groupBy(['feature_category_id', 'id']);
    }

    return view('world.subtype_features', [
      'subtype'    => $subtype,
      'categories' => $categories->keyBy('id'),
      'rarities'   => $rarities->keyBy('id'),
      'features'   => $features,
    ]);
  }

  /**
   * Shows a universal visual trait list.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getUniversalFeatures(Request $request) {
    $categories = FeatureCategory::orderBy('sort', 'DESC')->get();
    $rarities = Rarity::orderBy('sort', 'ASC')->get();

    if (!config('lorekeeper.extensions.visual_trait_index.enable_universal_index')) {
      abort(404);
    }

    $features = Feature::whereNull('species_id')
      ->visible(Auth::user() ?? null);
    $features = count($categories) ?
      $features->orderByRaw('FIELD(feature_category_id,' . implode(',', $categories->pluck('id')->toArray()) . ')') :
      $features;
    $features = $features->orderByRaw('FIELD(rarity_id,' . implode(',', $rarities->pluck('id')->toArray()) . ')')
      ->orderBy('has_image', 'DESC')
      ->orderBy('name')
      ->get()->groupBy(['feature_category_id', 'id']);

    return view('world.universal_features', [
      'categories' => $categories->keyBy('id'),
      'rarities'   => $rarities->keyBy('id'),
      'features'   => $features,
    ]);
  }

  /**
   * Provides a single trait's description html for use in a modal.
   *
   * @param mixed $id
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getFeatureDetail($id) {
    $feature = Feature::visible(Auth::user() ?? null)->where('id', $id)->with('species', 'subtype', 'rarity')->first();

    if (!$feature) {
      abort(404);
    }

    return view('world._feature_entry', [
      'feature' => $feature,
    ]);
  }

  /**
   * Shows the items page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getItems(Request $request) {
    $query = Item::with('category')->released(Auth::user() ?? null);

    if (config('lorekeeper.extensions.item_entry_expansion.extra_fields')) {
      $query->with('artist', 'shopStock')->withCount('shopStock');
    }

    if (config('lorekeeper.extensions.item_entry_expansion.extra_fields')) {
      $query->with('artist', 'shopStock')->withCount('shopStock');
    }

    $categoryVisibleCheck = ItemCategory::visible(Auth::user() ?? null)->pluck('id', 'name')->toArray();
    // query where category is visible, or, no category and released
    $query->where(function ($query) use ($categoryVisibleCheck) {
      $query->whereIn('item_category_id', $categoryVisibleCheck)->orWhereNull('item_category_id');
    });
    $data = $request->only(['item_category_id', 'name', 'sort', 'artist', 'rarity_id']);
    if (isset($data['item_category_id'])) {
      if ($data['item_category_id'] == 'withoutOption') {
        $query->whereNull('item_category_id');
      } else {
        $query->where('item_category_id', $data['item_category_id']);
      }
    }

    if (isset($data['name'])) {
      $query->where('name', 'LIKE', '%' . $data['name'] . '%');
    }

    if (isset($data['artist']) && $data['artist'] != 'none') {
      $query->where('artist_id', $data['artist']);
    }
    if (isset($data['rarity_id'])) {
      if ($data['rarity_id'] == 'withoutOption') {
        $query->whereNull('data->rarity_id');
      } else {
        $query->where('data->rarity_id', $data['rarity_id']);
      }
    }

    if (isset($data['sort'])) {
      switch ($data['sort']) {
        case 'alpha':
          $query->sortAlphabetical();
          break;
        case 'alpha-reverse':
          $query->sortAlphabetical(true);
          break;
        case 'category':
          $query->sortCategory();
          break;
        case 'newest':
          $query->sortNewest();
          break;
        case 'oldest':
          $query->sortOldest();
          break;
      }
    } else {
      $query->sortCategory();
    }

    return view('world.items', [
      'items'       => $query->orderBy('id')->paginate(20)->appends($request->query()),
      'categories'  => ['withoutOption' => 'Without Category'] + ItemCategory::visible(Auth::user() ?? null)->orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
      'shops'       => Shop::orderBy('sort', 'DESC')->get(),
      'artists'     => User::whereIn('id', Item::whereNotNull('artist_id')->pluck('artist_id')->toArray())->pluck('name', 'id')->toArray(),
      'rarities'    => ['withoutOption' => 'Without Rarity'] + Rarity::orderBy('rarities.sort', 'DESC')->pluck('name', 'id')->toArray(),
    ]);
  }

  /**
   * Shows an individual item's page.
   *
   * @param int $id
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getItem($id) {
    $categories = ItemCategory::orderBy('sort', 'DESC')->get();
    // TODO: multiple item searches
    $item = Item::where('id', $id)->released()->first();
    if (!$item) abort(404);
    $item = Item::where('id', $id)->released(Auth::user() ?? null)->with('category');

    if (config('lorekeeper.extensions.item_entry_expansion.extra_fields')) {
      $item->with('artist', 'shopStock')->withCount('shopStock');
    }

    $item = $item->first();

    if (!$item) {
      abort(404);
    }
    if ($item->category && !$item->category->is_visible) {
      if (Auth::check() ? !Auth::user()->isStaff : true) {
        abort(404);
      }
    }

    return view('world.item_page', [
      'item'        => $item,
      'imageUrl'    => $item->imageUrl,
      'name'        => $item->displayName,
      'description' => $item->parsed_description,
      'categories' => $categories->keyBy('id'),
      'shops' => Shop::whereIn('id', ShopStock::where('item_id', $item->id)->pluck('shop_id')->unique()->toArray())->orderBy('sort', 'DESC')->get(),
    ]);
  }

  /**
   * Shows the awards page.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getAwards(Request $request) {
    $query = Award::with('category');
    $data = $request->only(['award_category_id', 'name', 'sort', 'ownership']);
    if (isset($data['award_category_id']) && $data['award_category_id'] != 'none')
      $query->where('award_category_id', $data['award_category_id']);
    if (isset($data['name']))
      $query->where('name', 'LIKE', '%' . $data['name'] . '%');

    if (isset($data['ownership'])) {
      switch ($data['ownership']) {
        case 'all':
          $query->where('is_character_owned', 1)->where('is_user_owned', 1);
          break;
        case 'character':
          $query->where('is_character_owned', 1)->where('is_user_owned', 0);
          break;
        case 'user':
          $query->where('is_character_owned', 0)->where('is_user_owned', 1);
          break;
      }
    }

    if (isset($data['sort'])) {
      switch ($data['sort']) {
        case 'alpha':
          $query->sortAlphabetical();
          break;
        case 'alpha-reverse':
          $query->sortAlphabetical(true);
          break;
        case 'category':
          $query->sortCategory();
          break;
        case 'newest':
          $query->sortNewest();
          break;
        case 'oldest':
          $query->sortOldest();
          break;
      }
    } else $query->sortAlphabetical();

    if (!Auth::check() || !Auth::user()->isStaff) $query->released();

    return view('world.awards', [
      'awards' => $query->paginate(20)->appends($request->query()),
      'categories' => ['none' => 'Any Category'] + AwardCategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
      'shops' => Shop::orderBy('sort', 'DESC')->get()
    ]);
  }


  /**
   * Shows an individual award's page.
   *
   * @param  int  $id
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getAward($id) {
    $categories = AwardCategory::orderBy('sort', 'DESC')->get();
    $award = Award::where('id', $id);
    $released = $award->released()->count();
    if ((!Auth::check() || !Auth::user()->isStaff)) $award = $award->released();
    $award = $award->first();
    if (!$award) abort(404);

    if (!$released) flash('This ' . __('awards.award') . ' is not yet released.')->error();


    return view('world.award_page', [
      'award' => $award,
      'imageUrl' => $award->imageUrl,
      'name' => $award->displayName,
      'description' => $award->parsed_description,
      'categories' => $categories->keyBy('id'),
      'shops' => Shop::orderBy('sort', 'DESC')->get()
    ]);
  }

  /**
   * Shows the character categories page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getCharacterCategories(Request $request) {
    $query = CharacterCategory::query()->with('sublist');
    $name = $request->get('name');
    if ($name) {
      $query->where('name', 'LIKE', '%' . $name . '%')->orWhere('code', 'LIKE', '%' . $name . '%');
    }

    return view('world.character_categories', [
      'categories' => $query->visible(Auth::check() ? Auth::user() : null)->orderBy('sort', 'DESC')->orderBy('id')->paginate(20)->appends($request->query()),

    ]);
  }

  /**
   * Shows the Transformations page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getTransformations(Request $request) {
    $query = Transformation::query();
    $name = $request->get('name');
    if ($name) {
      $query->where('name', 'LIKE', '%' . $name . '%');
    }

    return view('prompts.prompt_categories', [
      'categories' => $query->orderBy('sort', 'DESC')->paginate(20)->appends($request->query()),
    ]);
  }

  /**
   * Shows the prompts page.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getPrompts(Request $request) {
    $query = Prompt::active()->with('category');
    $data = $request->only(['prompt_category_id', 'name', 'sort']);
    if (isset($data['prompt_category_id']) && $data['prompt_category_id'] != 'none') {
      $query->where('prompt_category_id', $data['prompt_category_id']);
    }

    if (isset($data['name'])) {
      $query->where('name', 'LIKE', '%' . $data['name'] . '%');
    }

    if (isset($data['sort'])) {
      switch ($data['sort']) {
        case 'alpha':
          $query->sortAlphabetical();
          break;
        case 'alpha-reverse':
          $query->sortAlphabetical(true);
          break;
        case 'category':
          $query->sortCategory();
          break;
        case 'newest':
          $query->sortNewest();
          break;
        case 'oldest':
          $query->sortOldest();
          break;
        case 'start':
          $query->sortStart();
          break;
        case 'start-reverse':
          $query->sortStart(true);
          break;
        case 'end':
          $query->sortEnd();
          break;
        case 'end-reverse':
          $query->sortEnd(true);
          break;
      }
    } else {
      $query->sortCategory();
    }

    return view('world.prompts', [
      'prompts' => $query->paginate(20)->appends($request->query()),
      'categories' => ['none' => 'Any Category'] + PromptCategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
    ]);
  }

  /**
   * shows all maps
   */
  public function getMaps() {
    return view('world.maps', [
      'maps' => Map::active()->orderBy('name', 'DESC')->get(),
    ]);
  }

  /**
   * Gets a map by its name
   */
  public function getMap($name) {
    $map = Map::active()->where('name', $name)->first();
    if (!$map) abort(404);
    return view('world.map', [
      'map' => $map,
    ]);
  }

  /**
   * Shows the border categories page.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getBorderCategories(Request $request) {
    $query = BorderCategory::query();
    $name = $request->get('name');
    if ($name) {
      $query->where('name', 'LIKE', '%' . $name . '%');
    }

    return view('world.border_categories', [
      'categories' => $query->orderBy('sort', 'DESC')->paginate(20)->appends($request->query()),
    ]);
  }

  /**
   * Shows the borders page.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getBorders(Request $request) {
    $query = Border::base()->active(Auth::user() ?? null);
    $data = $request->only(['border_category_id', 'name', 'sort', 'is_default', 'artist']);
    if (isset($data['border_category_id']) && $data['border_category_id'] != 'none') {
      $query->where('border_category_id', $data['border_category_id']);
    }

    if (isset($data['is_default']) && $data['is_default'] != 'none') {
      $query->where('is_default', $data['is_default'])->where('admin_only', 0);
    }

    if (isset($data['name'])) {
      $query->where('name', 'LIKE', '%' . $data['name'] . '%');
    }

    if (isset($data['artist']) && $data['artist'] != 'none') {
      $query->where('artist_id', $data['artist']);
    }

    if (isset($data['sort'])) {
      switch ($data['sort']) {
        case 'alpha':
          $query->sortAlphabetical();
          break;
        case 'alpha-reverse':
          $query->sortAlphabetical(true);
          break;
        case 'category':
          $query->sortCategory();
          break;
        case 'newest':
          $query->sortNewest();
          break;
        case 'oldest':
          $query->sortOldest();
          break;
      }
    } else {
      $query->sortCategory();
    }

    return view('world.borders', [
      'borders' => $query->paginate(20)->appends($request->query()),
      'categories' => ['none' => 'Any Category'] + BorderCategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
      'is_default' => ['none' => 'Any Type', '0' => 'Unlockable', '1' => 'Default'],
      'artists' => ['none' => 'Any Artist'] + User::whereIn('id', Border::whereNotNull('artist_id')->pluck('artist_id')->toArray())->pluck('name', 'id')->toArray(),
    ]);
  }

  /**
   * Shows an individual border's page.
   *
   * @param  int  $id
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getBorder($id) {
    $border = Border::base()->where('id', $id)->active()->first();
    if (!$border) {
      abort(404);
    }

    return view('world._border_page', [
      'border' => $border,
      'imageUrl' => $border->imageUrl,
      'name' => $border->displayName,
      'description' => $border->parsed_description,
    ]);
  }

  /**
   * Shows the pet categories page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getPetCategories(Request $request) {
    $query = PetCategory::query();
    $name = $request->get('name');
    if ($name) {
      $query->where('name', 'LIKE', '%' . $name . '%');
    }

    return view('world.pet_categories', [
      'categories' => $query->orderBy('sort', 'DESC')->paginate(20)->appends($request->query()),
    ]);
  }

  /**
   * Shows the pets page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getPets(Request $request) {
    $query = Pet::with('category');
    // only show pets with no parent_id if config is set
    if (!config('lorekeeper.pets.include_variants')) {
      $query->whereNull('parent_id');
    }
    $categoryVisibleCheck = PetCategory::visible(Auth::check() ? Auth::user() : null)->pluck('id', 'name')->toArray();
    // query where category is visible, or, no category and visible
    $query->where(function ($query) use ($categoryVisibleCheck) {
      $query->whereIn('pet_category_id', $categoryVisibleCheck)->orWhereNull('pet_category_id');
    });
    $data = $request->only(['pet_category_id', 'name', 'sort']);
    if (isset($data['pet_category_id']) && $data['pet_category_id'] != 'none') {
      $query->where('pet_category_id', $data['pet_category_id']);
    }
    if (isset($data['name'])) {
      $query->where('name', 'LIKE', '%' . $data['name'] . '%');
    }

    if (isset($data['sort'])) {
      switch ($data['sort']) {
        case 'alpha':
          $query->sortAlphabetical();
          break;
        case 'alpha-reverse':
          $query->sortAlphabetical(true);
          break;
        case 'category':
          $query->sortCategory();
          break;
        case 'newest':
          $query->sortNewest();
          break;
        case 'oldest':
          $query->sortOldest();
          break;
      }
    } else {
      $query->sortCategory();
    }

    return view('world.pets', [
      'pets'       => $query->paginate(20)->appends($request->query()),
      'categories' => ['none' => 'Any Category'] + PetCategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
    ]);
  }

  /**
   * Gets a specific pet page.
   *
   * @param mixed $id
   */
  public function getPet($id) {
    $pet = Pet::with('category')->findOrFail($id);

    return view('world.pet_page', [
      'pet' => $pet,
    ]);
  }

  /**
   * Shows the items page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getRecipes(Request $request) {
    $query = Recipe::query();
    $data = $request->only(['name', 'sort']);
    if (isset($data['name'])) {
      $query->where('name', 'LIKE', '%' . $data['name'] . '%');
    }

    if (isset($data['sort'])) {
      switch ($data['sort']) {
        case 'alpha':
          $query->sortAlphabetical();
          break;
        case 'alpha-reverse':
          $query->sortAlphabetical(true);
          break;
        case 'newest':
          $query->sortNewest();
          break;
        case 'oldest':
          $query->sortOldest();
          break;
        case 'locked':
          $query->sortNeedsUnlocking();
          break;
      }
    } else {
      $query->sortNewest();
    }

    return view('world.recipes.recipes', [
      'recipes' => $query->paginate(20)->appends($request->query()),
    ]);
  }

  /**
   * Shows an individual recipe;ss page.
   *
   * @param int $id
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getRecipe($id) {
    $recipe = Recipe::where('id', $id)->first();
    if (!$recipe) {
      abort(404);
    }

    return view('world.recipes._recipe_page', [
      'recipe'      => $recipe,
      'imageUrl'    => $recipe->imageUrl,
      'name'        => $recipe->displayName,
      'description' => $recipe->parsed_description,
    ]);
  }
}
