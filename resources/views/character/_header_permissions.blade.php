<?php
$trading = $character->is_trading;
$writing = $character->is_gift_writing_allowed;
$art = $character->is_gift_art_allowed;
$allowed = $trading || $writing == 1 || $art == 1;
$ask = $writing == 2 || $art == 2;
$closed = !$trading || $writing == 0 || $art == 0;
?>

<div class="permission-box no-details" style="--permcolor: var(--purple-clr_400)">
  <div class="status">
    <span
      id="copy"
      class=" m-0 p-0"
      data-bs-toggle="tooltip"
      title="Click to Copy the Character Code"
    >
      <i class="fas fa-copy"></i>
    </span>
  </div>
</div>
@if (config('lorekeeper.extensions.character_TH_profile_link') && $character->profile->link)
  <div class="permission-box no-details" style="--permcolor: var(--purple-clr_400)">
    <div class="status">
      <a data-character-id="{{ $character->id }}" href="{{ $character->profile->link }}">
        <span
          id="copy"
          class=" m-0 p-0"
          data-bs-toggle="tooltip"
          title="View this character's Toyhouse page"
          style="color: var(--white)"
        >
          <i class="fas fa-house-laptop"></i>
        </span>
      </a>
    </div>
  </div>
@endif
@if ($character->user && $character->user->settings->allow_character_likes)
  <div class="permission-box likes {{ $character->likeTotal ? '' : 'no-details' }}">
    <div class="status">
      <span data-bs-toggle="tooltip" title="Like this character">
        {!! Form::open(['url' => $character->url . '/like']) !!}
        {{-- <i class="fas fa-heart"></i> --}}
        {!! Form::submit('♥', [
            'class' => '',
            'style' => 'background-color: transparent; border: 0px; color: var(--white); box-shadow: unset; scale: 1.5'
        ]) !!}
        {{-- {!! Form::submit(ucfirst(__('character_likes.like')), ['class' => '']) !!} --}}
        {!! Form::close() !!}
      </span>
    </div>
    @if ($character->likeTotal)
      <div class="perms">
        {{ $character->likeTotal }}
      </div>
    @endif
  </div>
@endif

@if ($character->is_visible && Auth::check() && $character->user_id != Auth::user()->id)
  <?php $bookmark = Auth::user()->hasBookmarked($character); ?>
  <div class="permission-box no-details" style="--permcolor: var(--teal-clr_300)">
    <div class="status">
      <a
        href="#"
        class="bookmark-button"
        data-id="{{ $bookmark ? $bookmark->id : 0 }}"
        data-character-id="{{ $character->id }}"
      >
        <span data-bs-toggle="tooltip" title="Bookmark this character">
          <i class="fas fa-bookmark"></i>
        </span>
      </a>
    </div>
  </div>
@endif

@if (!$character->is_myo_slot)
  @if ($allowed)
    <div class="permission-box allowed">
      <div class="status">
        <i class="fas fa-check"></i>
      </div>
      <div class="perms">
        @if ($trading)
          <span data-bs-toggle="tooltip" title="OPEN for sale and trade offers.">
            <i class="fas fa-sack-dollar"></i>
          </span>
        @endif
        @if ($writing == 1)
          <span data-bs-toggle="tooltip" title="OPEN for gift writing.">
            <i class="fas fa-book"></i>
          </span>
        @endif
        @if ($art == 1)
          <span data-bs-toggle="tooltip" title="OPEN for gift art.">
            <i class="fas fa-paintbrush"></i>
          </span>
        @endif
      </div>
    </div>
  @endif
  @if ($ask)
    <div class="permission-box ask">
      <div class="status">
        <i class="fas fa-comment"></i>
      </div>
      <div class="perms">
        @if ($writing == 2)
          <span data-bs-toggle="tooltip" title="ASK before gifting writing.">
            <i class="fas fa-book"></i>
          </span>
        @endif
        @if ($art == 2)
          <span data-bs-toggle="tooltip" title="ASK before gifting art.">
            <i class="fas fa-paintbrush"></i>
          </span>
        @endif
      </div>
    </div>
  @endif
  @if ($closed)
    <div class="permission-box closed">
      <div class="status">
        <i class="fas fa-x"></i>
      </div>
      <div class="perms">
        @if (!$trading)
          <span data-bs-toggle="tooltip" title="CLOSED for sale and trade offers">
            <i class="fas fa-sack-dollar"></i>
          </span>
        @endif
        @if ($writing == 0)
          <span data-bs-toggle="tooltip" title="CLOSED for gift writing">
            <i class="fas fa-book"></i>
          </span>
        @endif
        @if ($art == 0)
          <span data-bs-toggle="tooltip" title="CLOSED for gift art">
            <i class="fas fa-paintbrush"></i>
          </span>
        @endif
      </div>
    </div>
  @endif
@endif
