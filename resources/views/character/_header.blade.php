@if (
    !$character->is_myo_slot &&
        config('lorekeeper.extensions.previous_and_next_characters.display') &&
        isset($extPrevAndNextBtnsUrl)
)
  @if ($extPrevAndNextBtns['prevCharName'] || $extPrevAndNextBtns['nextCharName'])
    <div class="row mb-4">
      @if ($extPrevAndNextBtns['prevCharName'])
        <div class="col text-left float-left">
          <a class="btn btn-outline-success text-success" href="{{ $extPrevAndNextBtns['prevCharUrl'] }}{!! $extPrevAndNextBtnsUrl !!}">
            <i class="fas fa-angle-double-left"></i> Previous Character ・ <span class="text-primary">{!! $extPrevAndNextBtns['prevCharName'] !!}</span>
          </a>
        </div>
      @endif
      @if ($extPrevAndNextBtns['nextCharName'])
        <div class="col text-right float-right">
          <a class="btn btn-outline-success text-success" href="{{ $extPrevAndNextBtns['nextCharUrl'] }}{!! $extPrevAndNextBtnsUrl !!}">
            <span class="text-primary">{!! $extPrevAndNextBtns['nextCharName'] !!}</span> ・ Next Character <i class="fas fa-angle-double-right"></i>
            <br />
          </a>
        </div>
      @endif
    </div>
  @endif
@endif
<div class="character-masterlist-categories">
  @if (!$character->is_myo_slot)
    {!! $character->category->displayName !!} ・ {!! $character->image->species->displayName !!} ・ {!! $character->image->rarity->displayName !!}
  @else
    {{ __('lorekeeper.myo') }} @if ($character->image->species_id)
      ・ {!! $character->image->species->displayName !!}
    @endif
    @if ($character->image->rarity_id)
      ・ {!! $character->image->rarity->displayName !!}
    @endif
  @endif
</div>
<div id="character-main" class=" mb-0">
  <div class="float-right align-content-center">
    @if (!$character->is_myo_slot)
      @if ($character->user && $character->user->settings->allow_character_likes)
        <div
          class="btn btn-primary float-right ml-2"
          data-bs-toggle="tooltip"
          title="{{ ucfirst(__('character_likes.liked')) }}
             {{ $character->likeTotal }} times"
        >
          <i class="fas fa-star"></i> {{ $character->likeTotal }}</a>
        </div>
      @endif
      @if (Auth::check() &&
              $character->user &&
              $character->user->settings->allow_character_likes &&
              Auth::user()->canLike($character) &&
              Auth::user()->id != $character->user_id
      )
        <span class="float-right float-top ml-2 align-content-center">
          {!! Form::open(['url' => $character->url . '/like']) !!}
          {!! Form::submit(ucfirst(__('character_likes.like')), ['class' => 'btn btn-success']) !!}
          {!! Form::close() !!}
        </span>
      @endif
    @endif
    @if (config('lorekeeper.extensions.character_status_badges'))
      <!-- character trade/gift status badges -->
      <span
        class="btn {{ $character->is_trading ? 'badge-success' : 'badge-danger' }} float-right ml-2"
        data-bs-toggle="tooltip"
        title="{{ $character->is_trading ? 'OPEN for sale and trade offers.' : 'CLOSED for sale and trade offers.' }}"
      >
        <i class="fas fa-comments-dollar"></i>
      </span>
      @if (!$character->is_myo_slot)
        <span
          id="copy"
          class="btn badge-success"
          data-bs-toggle="tooltip"
          title="Click to Copy the Character Code"
        ><i class="fas fa-copy"></i></span>
        <span
          class="btn {{ $character->is_gift_writing_allowed == 1 ? 'badge-success' : ($character->is_gift_writing_allowed == 2 ? 'badge-warning text-light' : 'badge-danger') }} float-right ml-2"
          data-bs-toggle="tooltip"
          title="{{ $character->is_gift_writing_allowed == 1 ? 'OPEN for gift writing.' : ($character->is_gift_writing_allowed == 2 ? 'PLEASE ASK before gift writing.' : 'CLOSED for gift writing.') }}"
        ><i class="fas fa-file-alt"></i></span>
        <span
          class="btn {{ $character->is_gift_art_allowed == 1 ? 'badge-success' : ($character->is_gift_art_allowed == 2 ? 'badge-warning text-light' : 'badge-danger') }} float-right ml-2"
          data-bs-toggle="tooltip"
          title="{{ $character->is_gift_art_allowed == 1 ? 'OPEN for gift art.' : ($character->is_gift_art_allowed == 2 ? 'PLEASE ASK before gift art.' : 'CLOSED for gift art.') }}"
        ><i class="fas fa-pencil-ruler"></i></span>
      @endif
    @endif
  </div>
  <h1>
    @if ($character->is_visible && Auth::check() && $character->user_id != Auth::user()->id)
      <?php $bookmark = Auth::user()->hasBookmarked($character); ?>
      <a
        href="#"
        class="btn btn-outline-info float-right bookmark-button ml-2"
        data-id="{{ $bookmark ? $bookmark->id : 0 }}"
        data-character-id="{{ $character->id }}"
      ><i class="fas fa-bookmark"></i>
        {{ $bookmark ? 'Edit Bookmark' : 'Bookmark' }}</a>
    @endif
    @if (config('lorekeeper.extensions.character_TH_profile_link') && $character->profile->link)
      <a
        class="btn btn-outline-info float-right"
        data-character-id="{{ $character->id }}"
        href="{{ $character->profile->link }}"
      ><i class="fas fa-home"></i> Profile</a>
    @endif
  </h1>
  @if (!$character->is_visible)
    <i class="fas fa-eye-slash"></i>
  @endif
  <h1>
    {!! $character->displayName !!}
  </h1>
  @if (Settings::get('character_title_display'))
    <div class="h5">{!! $character->image->displayTitles !!}</div>
  @endif
  <div class="mb-3">
    Owned by {!! $character->displayOwner !!}
  </div>

  <script>
    $(document).ready(function() {
      $('#copy').on('click', async (e) => {
        await window.navigator.clipboard.writeText("{{ $character->slug }}");
        e.currentTarget.classList.remove('toCopy');
        e.currentTarget.classList.add('toCheck');
        setTimeout(() => {
          e.currentTarget.classList.remove('toCheck');
          e.currentTarget.classList.add('toCopy');
        }, 2000);
      });
    });
  </script>
