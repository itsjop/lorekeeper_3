@extends('character.layout', ['componentName' => 'character/character', 'isMyo' => $character->is_myo_slot])

@section('profile-title')
  {{ $character->fullName }}
@endsection

@section('meta-img')
  {{ $character->image->content_warnings ? asset('images/somnivores/site/content-warning.png') : $character->image->thumbnailUrl }}
@endsection

@section('profile-content')

  @include('widgets._awardcase_feature', [
      'target' => $character,
      'count' => Config::get('lorekeeper.extensions.awards.character_featured'),
      'float' => true
  ])
  @if ($character->is_myo_slot)
    {!! breadcrumbs(['MYO Slot Masterlist' => 'myos', $character->fullName => $character->url]) !!}
  @else
    {!! breadcrumbs([
        $character->category->masterlist_sub_id
            ? $character->category->sublist->name . ' Masterlist'
            : 'Character Masterlist' => $character->category->masterlist_sub_id
            ? 'sublist/' . $character->category->sublist->key
            : 'masterlist',
        $character->fullName => $character->url
    ]) !!}
  @endif

  <div>
    {{-- <sub-component :character_prop="'{{ json_encode($character) }}'"
      :colours_prop="'{{ json_encode($character->image->colours) }}'"
      :Auth="'{{ json_encode(Auth::check()) }}'"
      /> --}}
  </div>

  @include('character._header_custom', ['character' => $character])
  @if ($character->images()->where('is_valid', 1)->whereNotNull('transformation_id')->exists())
    <div class="form-selectors card-header p-0">
      <ul class="nav nav-tabs flex gap-_5 card-header-tab ai-center">
        <h5 class="m-0">Forms:</h5>
        @foreach ($character->images()->where('is_valid', 1)->get() as $image)
          <li class="nav-item">
            <a
              class="nav-link br-15 form-data-button {{ $image->id == $character->image->id ? 'active' : '' }}"
              data-bs-toggle="tab"
              role="tab"
              style="border: 2px solid white;"
              data-id="{{ $image->id }}"
            >
              {{ $image->transformation_id ? $image->transformation->name : 'Main' }}
              {{ $image->transformation_info ? ' (' . $image->transformation_info . ')' : '' }}
            </a>
          </li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Main Image --}}
  <div id="char-col" class="char-col">
    <div class="text-center">
      <a
        href="{{ $character->image->canViewFull(Auth::check() ? Auth::user() : null) && file_exists(public_path($character->image->imageDirectory . '/' . $character->image->fullsizeFileName)) ? $character->image->fullsizeUrl : $character->image->imageUrl }}"
        data-lightbox="entry"
        data-title="{{ $character->fullName }}"
      >
        @if (
            (isset($character->image->content_warnings) && !Auth::check()) ||
                (Auth::check() && Auth::user()->settings->content_warning_visibility < 2 && isset($character->image->content_warnings))
        )
          @include('widgets._cw_img', [
              'src' =>
                  $character->image->canViewFull(Auth::user() ?? null) &&
                  file_exists(public_path($character->image->imageDirectory . '/' . $character->image->fullsizeFileName))
                      ? $character->image->fullsizeUrl
                      : $character->image->imageUrl,
              'class' => 'image',
              'alt' => $character->fullName,
              'warnings' => isset($character->image->content_warnings)
                  ? implode(', ', $character->image->content_warnings)
                  : ''
          ])
        @else
          <img
            src="{{ $character->image->canViewFull(Auth::user() ?? null) && file_exists(public_path($character->image->imageDirectory . '/' . $character->image->fullsizeFileName)) ? $character->image->fullsizeUrl : $character->image->imageUrl }}"
            class="image {{ Auth::check() && checkImageBlock($character, Auth::user()) ? 'image-blur' : '' }} {{ $character->image->showContentWarnings(Auth::user() ?? null) ? 'content-warning' : '' }}"
            alt="{{ $character->fullName }}"
          />
        @endif
      </a>
      <div class="mt-2 text-center">
        @include('widgets._object_block', ['object' => $character])
      </div>
    </div>
    @if (
        $character->image->canViewFull(Auth::check() ? Auth::user() : null) &&
            file_exists(public_path($character->image->imageDirectory . '/' . $character->image->fullsizeFileName))
    )
      <div class="text-right">
        You are viewing the full-size image.
        <a href="{{ $character->image->imageUrl }}">
          View watermarked image
        </a>
        ?
      </div>
    @endif
  </div>
  @include('character._image_info', ['image' => $character->image, 'character' => $character])

  <div
    class="row mb-3"
    id="main-tab"
    style="clear:both;"
  > </div>

  <?php
  $pets = $character->image->character->pets()->orderBy('sort', 'DESC')->limit(config('lorekeeper.pets.display_pet_count'))->get();
  $firstTab = count($pets) ? 1 : (count($items) ? 2 : (count($character->links) ? 3 : 0));
  ?>

  <div class="char-attachments">

    @if ($firstTab !== 0)
      <div class="character-attch-tabs card-header" style="position: relative; z-index: 5;">
        <ul class="nav nav-tabs flex gap-_5 card-header-tabs">
          @if (count($pets))
            <li class="nav-item">
              <a
                class="nav-link {{ $firstTab == 1 ? 'active' : '' }}"
                id="petsTab"
                data-bs-toggle="tab"
                href="#pets"
                role="tab"
              >
                <h5 class="m-0">
                  <i class="fas fa-dog"></i>
                  Pets
                </h5>
              </a>
            </li>
          @endif
          @if (count($items))
            <li class="nav-item">
              <a
                class="nav-link {{ $firstTab == 2 ? 'active' : '' }}"
                id="inventoryTab"
                data-bs-toggle="tab"
                href="#inventory"
                role="tab"
              >
                <h5 class="m-0">
                  <i class="fas fa-gifts"></i>
                  Inventory
                </h5>
              </a>
            </li>
          @endif
          @if (count($character->links))
            <li class="nav-item">
              <a
                class="nav-link {{ $firstTab == 3 ? 'active' : '' }}"
                id="connectionsTab"
                data-bs-toggle="tab"
                href="#connections"
                role="tab"
              >
                <h5 class="m-0">
                  <i class="fas fa-link"></i>
                  Connections
                </h5>
              </a>
            </li>
          @endif
        </ul>
      </div>
    @endif

    @if ($firstTab !== 0)
      <div class="card-attch-body card-body tab-content">
        <div class="tab-pane fade {{ $firstTab == 1 ? 'show active' : '' }}" id="pets">
          @include('character._tab_pets', [
              'pets' => $character->image->character->pets()->orderBy('sort', 'DESC')->limit(config('lorekeeper.pets.display_pet_count'))->get(),
              'character' => $character
          ])
        </div>
        <div class="tab-pane fade {{ $firstTab == 2 ? 'show active' : '' }}" id="inventory">
          @include('character._character_inventory_solo', ['items' => $items])
        </div>
        <div class="tab-pane fade {{ $firstTab == 3 ? 'show active' : '' }}" id="connections">
          @include('character._character_links_solo', [
              'character' => $character,
              'types' => config('lorekeeper.character_relationships')
          ])
        </div>
      </div>
    @endif
  </div>
  <br />
  {{-- Info --}}
  <div class="card character-bio">

    <div class="card-header" style="position: relative; z-index: 5;">
      <ul class="nav nav-tabs flex gap-_5 card-header-tabs">
        <li class="nav-item">
          <a
            class="nav-link active"
            data-bs-toggle="tab"
            href="#pets"
            role="tab"
          >
            <h5 class="m-0">
              <i class="fas fa-star"></i>
              Profile
            </h5>
          </a>
        </li>
      </ul>
    </div>
    @if ($character->profile->parsed_text)
      <div class="card mb-3">
        <div id="profile" class="card-body parsed-text">
          {!! $character->profile->parsed_text !!}
        </div>
      </div>
    @else
      <div class="card mb-3">
        <div class="small italic text-secondary card-body parsed-text">
          This character doesn't have a bio yet!
        </div>
      </div>
    @endif
    <div class="card-header">
      <ul class="nav nav-tabs flex gap-_5 card-header-tabs">
        <li class="nav-item">
          <a
            class="nav-link active"
            id="statsTab"
            data-bs-toggle="tab"
            href="#stats"
            role="tab"
          >Stats</a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link"
            id="notesTab"
            data-bs-toggle="tab"
            href="#notes"
            role="tab"
          >Description</a>
        </li>
        @if ($character->getLineageBlacklistLevel() < 2)
          <li class="nav-item">
            <a
              class="nav-link"
              id="lineageTab"
              data-bs-toggle="tab"
              href="#lineage"
              role="tab"
            >Lineage</a>
          </li>
        @endif
        @if (Auth::check() && Auth::user()->hasPower('manage_characters'))
          <li class="nav-item">
            <a
              class="nav-link"
              id="settingsTab"
              data-bs-toggle="tab"
              href="#settings-{{ $character->slug }}"
              role="tab"
            >
              <i class="fas fa-cog"></i></a>
          </li>
        @endif
      </ul>
    </div>

    <div class="card-body tab-content">
      <div class="tab-pane fade show active" id="stats">
        @include('character._tab_stats', ['character' => $character])
      </div>
      <div class="tab-pane fade" id="notes">
        @include('character._tab_notes', ['character' => $character])
      </div>
      <div class="tab-pane fade" id="lineage">
        @include('character._tab_lineage', ['character' => $character])
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  @parent
  <style>
    .image-blur {
      filter: blur(5px);
    }
  </style>
  @include('character._image_js', ['character' => $character])
  @include('character._transformation_js')
@endsection
