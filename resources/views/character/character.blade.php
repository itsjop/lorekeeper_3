@extends('character.layout', ['componentName' => 'character/character', 'isMyo' => $character->is_myo_slot])

@section('profile-title')
  {{ $character->fullName }}
@endsection

@section('meta-img')
  {{ $character->image->content_warnings ? asset('images/lorekeeper/content-warning.png') : $character->image->thumbnailUrl }}
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

  @include('character._header', ['character' => $character])

  @if ($character->images()->where('is_valid', 1)->whereNotNull('transformation_id')->exists())
    <div class="card-header mb-2">
      <ul class="nav nav-tabs flex gap-_5 card-header-tabs">
        @foreach ($character->images()->where('is_valid', 1)->get() as $image)
          <li class="nav-item">
            <a
              class="nav-link form-data-button {{ $image->id == $character->image->id ? 'active' : '' }}"
              data-bs-toggle="tab"
              role="tab"
              data-id="{{ $image->id }}"
            >
              {{ $image->transformation_id ? $image->transformation->name : 'Main' }}
              {{ $image->transformation_info ? ' (' . $image->transformation_info . ')' : '' }}
            </a>
          </li>
        @endforeach
        <li>
          <h3>{!! add_help(
              'Click on a ' .
                  __('transformations.transformation') .
                  ' to view the image. If you don\'t see the ' .
                  __('transformations.transformation') .
                  ' you\'re looking for, it may not have been uploaded yet.'
          ) !!}</h3>
        </li>
      </ul>
    </div>
  @endif

  {{-- @if (isset($character->profile->professionObj) || isset($character->profile->profession))
    <div class="card-header mb-2 p-0 text-right">
      <div class="col-lg-2 ml-auto">
        <a class="btn btn-secondary btn-sm" href="/professions/{{ $character->profile->professionObj->category_id ?? '' }}">
          @if (isset($character->profile->professionObj))
            <h5 class="p-0 m-0">
              <img
                class="fr-fic fr-dii mr-2"
                src="{{ $character->profile->professionObj->iconUrl ?? '/images/lorekeeper/profession.png' }}"
                style="max-width:50px;"
              >{{ $character->profile->professionObj->name }}
            </h5>
          @else
            <h5 class="p-0 m-0">
              <img
                class="fr-fic fr-dii mr-2"
                src="/images/lorekeeper/profession.png"
                style="max-width:50px;"
              >{{ $character->profile->profession }}
            </h5>
          @endif
        </a>
      </div>
    </div>
  @endif --}}

  {{-- Main Image --}}
  <div
    class="row mb-3"
    id="main-tab"
    style="clear:both;"
  >
    <div class="col-md-7">
      <div class="text-center">
        <a
          href="{{ $character->image->canViewFull(Auth::check() ? Auth::user() : null) && file_exists(public_path($character->image->imageDirectory . '/' . $character->image->fullsizeFileName)) ? $character->image->fullsizeUrl : $character->image->imageUrl }}"
          data-lightbox="entry"
          data-title="{{ $character->fullName }}"
        >
          <img
            src="{{ $character->image->canViewFull(Auth::user() ?? null) && file_exists(public_path($character->image->imageDirectory . '/' . $character->image->fullsizeFileName)) ? $character->image->fullsizeUrl : $character->image->imageUrl }}"
            class="image {{ Auth::check() && checkImageBlock($character, Auth::user()) ? 'image-blur' : '' }} {{ $character->image->showContentWarnings(Auth::user() ?? null) ? 'content-warning' : '' }}"
            alt="{{ $character->fullName }}"
          />
        </a>
        <div class="mt-2 text-center">@include('widgets._object_block', ['object' => $character])</div>
      </div>
      @if (
          $character->image->canViewFull(Auth::check() ? Auth::user() : null) &&
              file_exists(public_path($character->image->imageDirectory . '/' . $character->image->fullsizeFileName))
      )
        <div class="text-right">You are viewing the full-size image. <a href="{{ $character->image->imageUrl }}">View watermarked
            image</a>?</div>
      @endif
    </div>
    @include('character._image_info', ['image' => $character->image])
  </div>

  {{-- Pets --}}
  <div class="card">
    <div class="flex jc-between ai-end">
      <h5>Pets</h5>
      <a href="{{ $character->url . '/pets' }}" class="btn btn-outline-info p-0 px-2 btn-sm">
        View all Pets
        <i class="fas fa-caret-right"></i>
      </a>
    </div>
    <div class="grid grid-4-col card-body gap-_5">
      {{-- get one random pet --}}
      @php
        $pets = $character->image->character
            ->pets()
            ->orderBy('sort', 'DESC')
            ->limit(config('lorekeeper.pets.display_pet_count'))
            ->get();
      @endphp
      @foreach ($pets as $pet)
        @if (config('lorekeeper.pets.pet_bonding_enabled'))
          @include('character._pet_bonding_info', ['pet' => $pet])
        @else
          <div class="ml-2 mr-3">
            <img src="{{ $pet->pet->image($pet->id) }}" style="max-width: 75px;" />
            <br>
            <span class="text-light badge badge-dark" style="font-size:95%;">{!! $pet->pet_name !!}</span>
          </div>
        @endif
      @endforeach
    </div>
  </div>
  <br />
  {{-- Info --}}
  <div class="card character-bio">
    <div>
      <h5>Profile</h5>
    </div>
    @if ($character->profile->parsed_text)
      <div class="card mb-3">
        <div class="card-body parsed-text">
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
      @if ($character->getLineageBlacklistLevel() < 2)
        <div class="tab-pane fade" id="lineage">
          @include('character._tab_lineage', ['character' => $character])
        </div>
      @endif
      @if (Auth::check() && Auth::user()->hasPower('manage_characters'))
        <div class="tab-pane fade" id="settings-{{ $character->slug }}">
          {!! Form::open([
              'url' => $character->is_myo_slot
                  ? 'admin/myo/' . $character->id . '/settings'
                  : 'admin/character/' . $character->slug . '/settings'
          ]) !!}
          <div class="form-group">
            {!! Form::checkbox('is_visible', 1, $character->is_visible, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
            {!! Form::label('is_visible', 'Is Visible', ['class' => 'form-check-label ml-3']) !!} {!! add_help(
                'Turn this off to hide the character. Only mods with the Manage Masterlist power (that\'s you!) can view it - the owner will also not be able to see the character\'s page.'
            ) !!}
          </div>
          <div class="text-right">
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
          </div>
          {!! Form::close() !!}
          <hr />
          <div class="text-right">
            <a
              href="#"
              class="btn btn-outline-danger btn-sm delete-character"
              data-slug="{{ $character->slug }}"
            >Delete</a>
          </div>
        </div>
      @endif
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
