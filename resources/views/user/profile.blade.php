@extends('user.layout', [
    'componentName' => 'user/profile',
    'user' => isset($user) ? $user : null
])

<link href="{{ asset('css/vendor/bootstrap_profile.css') }}" rel="stylesheet">
<link href="{{ asset('css/vendor/lorekeeper_profile.css') }}" rel="stylesheet">

@section('profile-title')
  {{ $user->name }}'s Profile
@endsection

@section('meta-img')
  {{ $user->avatarUrl }}
  {{ $user->profileImgUrl }}
@endsection

@section('profile-content')
  {!! breadcrumbs(['Users' => 'users', $user->name => $user->url]) !!}

  @if (Auth::check() && Auth::user()->id != $user->id && config('lorekeeper.mod_mail.allow_user_mail'))
    <a class="btn btn-primary btn-sm float-right" href="{{ url('mail/new?recipient_id=' . $user->id) }}">
      <i class="fas fa-envelope">
      </i> Message User </a>
  @endif

  @include('widgets._awardcase_feature', [
      'target' => $user,
      'count' => Config::get('lorekeeper.extensions.awards.user_featured'),
      'float' => false
  ])

  @if ($user->is_banned)
    <div class="alert alert-danger"> This user has been banned. </div>
  @endif

  @if (Auth::check() && Auth::user()->isStaff)
    <div class="alert alert-warning">
      This user has received {{ $user->settings->strike_count }} strike{{ $user->settings->strike_count == 1 ? '' : 's' }}.
    </div>
  @endif
  <h1>
    <div style=" float:left;">
      {!! $user->userBorder() !!}
      {{-- @include('widgets._object_block', ['object' => $user]) --}}

    </div>

    {!! $user->displayName !!}
    <a href="{{ url('reports/new?url=') . $user->url }}">
      <i
        class="fas fa-exclamation-triangle fa-xs"
        data-bs-toggle="tooltip"
        title="Click here to report this user."
        style="opacity: 50%; font-size:0.5em;"
      ></i>
    </a>

    @if ($user->settings->is_fto)
      <span
        class="badge badge-success float-right"
        data-bs-toggle="tooltip"
        title="This user has not owned any characters from this world before."
      > FTO</span>
    @endif
  </h1>

  <div class="mb-4">
    <div class="row">
      <div class="row col-md-6">
        <div class="">
          <h5> Alias </h5>
        </div>
        <div class="pl-2"> {!! $user->displayAlias !!} </div>
      </div>
      <div class="row col-md-6">
        <div class="">
          <h5> Joined </h5>
        </div>
        <div class="pl-2"> {!! format_date($user->created_at, false) !!} ({{ $user->created_at->diffForHumans() }})</div>
      </div>
      <div class="row col-md-6">
        <div class="">
          <h5> Rank </h5>
        </div>
        <div class="pl-2"> {!! $user->rank->displayName !!} {!! add_help($user->rank->parsed_description) !!} </div>
      </div>
      @if ($user->birthdayDisplay && isset($user->birthday))
        <div class="row col-md-6">
          <div class="">
            <h5> Birthday </h5>
          </div>
          <div class="pl-2"> {!! $user->birthdayDisplay !!} </div>
        </div>
      @endif
      @if ($user_enabled && isset($user->home_id))
        <div class="row col-md-6">
          <div class="col-md-4 col-4">
            <h5> Home </h5>
          </div>
          <div class="col-md-8 col-8"> {!! $user->home ? $user->home->fullDisplayName : '-Deleted Location-' !!} </div>
        </div>
      @endif
      @if (isset($user->border) || isset($user->borderVariant))
        <div class="row col-sm-5">
          <div class="col-md-3 col-4">
            <h5> Border </h5>
          </div>
          <div class="col-md-9 col-8">
            <a href="{{ $user->borderVariant ? $user->borderVariant->parent->idUrl : $user->border->idUrl }}">
              {!! $user->borderVariant ? $user->borderVariant->parent->name : $user->border->name !!} @if ($user->borderVariant)
                ({{ $user->borderVariant->name }})
              @endif
            </a>
          </div>

          @if ($user->is_deactivated)
            <div class="alert alert-info text-center">
              <h1> {!! $user->displayName !!} </h1>
              <p> This account is currently deactivated, be it by staff or the user's own action. All information herein is hidden
                until the account is reactivated. </p>
              @if (Auth::check() && Auth::user()->isStaff)
                <p class="mb-0"> As you are staff, you can see the profile contents below and the sidebar contents. </p>
              @endif
            </div>
          @endif
        </div>
      @endif
    </div>

    <br>
    </br>

    @if (isset($user->profile->parsed_text))
      <div class="card mb-3" style="clear:both;">
        @if ($user->profile->pronouns)
          <h5 class="pronouns card-header">
            {{ $user->profile->pronouns }}
          </h5>
        @endif

        <div id="profile" class="card-body">
          {!! $user->profile->parsed_text !!}
          @if ($user->name == 'pim' || $user->name == 'joz' || $user->name == 'jop')
            <div class="pims-content">
              <iframe
                src="https://www.youtube.com/embed/prB4O6oiFZg"
                title="mayonnaise on an escalator!!! goin' upstairs so see ya later!!"
                frameborder="0"
                allow="picture-in-picture"
                referrerpolicy="strict-origin-when-cross-origin"
                allowfullscreen
              >
              </iframe>
            </div>
          @endif

        </div>
      </div>
    @endif

    <div class="grid grid-2-col gap-1 mb-4 ">
      <div id="selected-character" class="profile h-max card-body grid-area-unset w-100 h-100 bg-white">
        @include('widgets._selected_character', [
            'character' => $user->settings->selectedCharacter,
            'user' => $user,
            'fullImage' => true
        ])
      </div>
      <div class="profile-assets grid gap-1" style="grid-template-rows: 2fr 3fr;">
        <div class="card profile-currencies profile-assets-card">
          <div class="card-body text-center">
            <h5 class="card-title"> Bank </h5>
            <div class="profile-assets-content grid grid-3-col ai-center gap-x-1 ji-center jc-center">
              @foreach ($user->getCurrencies(false) as $currency)
                <div class="simple-badge"> {!! $currency->display($currency->quantity) !!} </div>
              @endforeach
            </div>
            <div class="text-right">
              <a href="{{ $user->url . '/bank' }}"> View all... </a>
            </div>
          </div>
        </div>
        <div class="card profile-inventory profile-assets-card">
          <div class="card-body text-center">
            <h5 class="card-title"> Inventory </h5>
            <div class="profile-assets-content grid grid-4-col">
              @if (count($items))
                @foreach ($items as $item)
                  <div class="profile-inventory-item">
                    @if ($item->imageUrl)
                      <img
                        src="{{ $item->imageUrl }}"
                        data-bs-toggle="tooltip"
                        title="{{ $item->name }}"
                        alt="{{ $item->name }}"
                      />
                    @else
                      <p> {{ $item->name }} </p>
                    @endif
                  </div>
                @endforeach
              @else
                <div> No items owned. </div>
              @endif
            </div>
            <div class="text-right">
              <a href="{{ $user->url . '/inventory' }}"> View all... </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-body text-center">
        <h5 class="card-title"> {{ ucfirst(__('awards.awards')) }} </h5>
        <div class="grid grid-4-col pi-center">
          @if (count($awards ?: 0))
            @foreach ($awards as $award)
              <div class="profile-inventory-item badje">
                @if ($award->imageUrl)
                  <img
                    class="w-100"
                    src="{{ $award->imageUrl }}"
                    data-bs-toggle="tooltip"
                    title="{{ $award->name }}"
                  />
                @else
                  <p> {{ $award->name }} </p>
                @endif
              </div>
            @endforeach
          @else
            <div> No {{ __('awards.awards') }} earned. </div>
          @endif
        </div>
        <div class="text-right">
          <a href="{{ $user->url . '/' . __('awards.awardcase') }}"> View all... </a>
        </div>
      </div>
    </div>

    <h2>
      <a href="{{ $user->url . '/characters' }}"> Characters </a>
      {{-- @if (isset($sublists) && $sublists->count() > 0)
        @foreach ($sublists as $sublist)
          / <a href="{{ $user->url . '/sublist/' . $sublist->key }}"> {{ $sublist->name }} </a>
        @endforidach
      @endif --}}
    </h2>

    @foreach ($characters->take(4)->get()->chunk(4) as $chunk)
      <div class="grid grid-4-col gap-1">
        @foreach ($chunk as $character)
          @include('browse._masterlist_content_entry', [
              'char_image' =>
                  $character->image->canViewFull(Auth::user() ?? null) &&
                  file_exists(public_path($character->image->imageDirectory . ' /  ' . $character->image->fullsizeFileName))
                      ? $character->image->thumbnailUrl
                      : $character->image->thumbnailUrl
          ])

          {{-- <div class="col-md-3 col-6 text-center">
  <div>
    <a href="{{ $character->url }}">
      <img
      src="{{ $character?->image?->thumbnailUrl }}"
      class="img-thumbnail"
      alt="{{ $character->fullName }}"
      />
</a>
    </div>
    <div class="mt-1">
      <a href="{{ $character->url }}" class="h5 mb-0">
        @if (!$character->is_visible)
        <i class="fas fa-eye-slash"></i>
        @endif
        {!! $character->formattedName !!}
      </a>
    </div>
  </div> --}}
        @endforeach
      </div>
      <br>
    @endforeach

    <div class="text-right">
      <a href="{{ $user->url . '/characters' }}"> View all... </a>
    </div>
    <hr>
    <br>
    <br>

    <div class="text-right">
      @comments(['model' => $user->profile, 'perPage' => 5])
    </div>
  @endsection
