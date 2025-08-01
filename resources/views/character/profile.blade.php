@extends('character.layout', ['componentName' => 'character/profile', 'isMyo' => $character->is_myo_slot])

@section('profile-title')
  {{ $character->fullName }}'s Profile
@endsection

@section('meta-img')
  {{ $character->image->content_warnings ? asset('images/somnivores/site/content-warning.png') : $character->image->thumbnailUrl }}
@endsection

@section('profile-content')
  @if ($character->is_myo_slot)
    {!! breadcrumbs([
        'MYO Slot Masterlist' => 'myos',
        $character->fullName => $character->url,
        'Profile' => $character->url . '/profile',
    ]) !!}
  @else
    {!! breadcrumbs([
        $character->category->masterlist_sub_id ? $character->category->sublist->name . ' Masterlist' : 'Character Masterlist' => $character->category->masterlist_sub_id ? 'sublist/' . $character->category->sublist->key : 'masterlist',
        $character->fullName => $character->url,
        'Profile' => $character->url . '/profile',
    ]) !!}
  @endif

  @include('character._header', ['character' => $character])

  {{-- @if (isset($character->profile->professionObj) || isset($character->profile->profession))
    <div class="card-header mb-2 p-0 text-right">
      <div class="col-lg-2 ml-auto">
        <a class="btn btn-secondary btn-sm" href="/professions/{{ $character->profile->professionObj->category_id ?? '' }}">
          @if (isset($character->profile->professionObj))
            <h5 class="p-0 m-0">
              <img class="fr-fic fr-dii mr-2" src="{{ $character->profile->professionObj->iconUrl ?? '/images/somnivores/site/profession.png' }}" style="max-width:50px;">{{ $character->profile->professionObj->name }}
            </h5>
          @else
            <h5 class="p-0 m-0">
              <img class="fr-fic fr-dii mr-2" src="/images/somnivores/site/profession.png" style="max-width:50px;">{{ $character->profile->profession }}
            </h5>
          @endif
        </a>
      </div>
    </div>
  @endif --}}

  <div class="mb-3">
    <div class="text-center">
      <a href="{{ $character->image->canViewFull(Auth::user() ?? null) && file_exists(public_path($character->image->imageDirectory . '/' . $character->image->fullsizeFileName)) ? $character->image->fullsizeUrl : $character->image->imageUrl }}"
        data-lightbox="entry" data-title="{{ $character->fullName }}">
        <img src="{{ $character->image->canViewFull(Auth::user() ?? null) && file_exists(public_path($character->image->imageDirectory . '/' . $character->image->fullsizeFileName)) ? $character->image->fullsizeUrl : $character->image->imageUrl }}"
          class="image img-fluid" alt="{{ $character->fullName }}" />
      </a>
    </div>
    @if ($character->image->canViewFull(Auth::user() ?? null) && file_exists(public_path($character->image->imageDirectory . '/' . $character->image->fullsizeFileName)))
      <div class="text-right">You are viewing the full-size image. <a href="{{ $character->image->imageUrl }}">View watermarked
          image</a>?</div>
    @endif
  </div>

  {{-- Bio --}}
  <a class="float-left" href="{{ url('reports/new?url=') . $character->url . '/profile' }}">
    <i class="fas fa-exclamation-triangle" data-bs-toggle="tooltip" title="Click here to report this character's profile." style="opacity: 50%;"></i></a>
  @if (Auth::check() && ($character->user_id == Auth::user()->id || Auth::user()->hasPower('manage_characters')))
    <div class="text-right mb-2">
      <a href="{{ $character->url . '/profile/edit' }}" class="btn btn-outline-info btn-sm">
        <i class="fas fa-cog"></i> Edit Profile</a>
    </div>
  @endif
  @if ($character->profile->parsed_text)
    <div class="card mb-3">
      <div class="card-body parsed-text">
        {!! $character->profile->parsed_text !!}
      </div>
    </div>
  @endif

  @if ($character->is_trading || $character->is_gift_art_allowed || $character->is_gift_writing_allowed)
    <div class="card mb-3">
      <ul class="list-group list-group-flush">
        @if ($character->is_gift_art_allowed >= 1 && !$character->is_myo_slot)
          <li class="list-group-item">
            <h5 class="mb-0">
              <i class="{{ $character->is_gift_art_allowed == 1 ? 'text-success' : 'text-secondary' }} far fa-circle fa-fw mr-2"></i>
              {{ $character->is_gift_art_allowed == 1 ? 'Gift art is allowed' : 'Please ask before gift art' }}
            </h5>
          </li>
        @endif
        @if ($character->is_gift_writing_allowed >= 1 && !$character->is_myo_slot)
          <li class="list-group-item">
            <h5 class="mb-0">
              <i class="{{ $character->is_gift_writing_allowed == 1 ? 'text-success' : 'text-secondary' }} far fa-circle fa-fw mr-2"></i>
              {{ $character->is_gift_writing_allowed == 1 ? 'Gift writing is allowed' : 'Please ask before gift writing' }}
            </h5>
          </li>
        @endif
        @if ($character->is_trading)
          <li class="list-group-item">
            <h5 class="mb-0">
              <i class="text-success far fa-circle fa-fw mr-2"></i> Open for trades
            </h5>
          </li>
        @endif
      </ul>
    </div>
  @endif
@endsection
