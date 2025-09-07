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
            <i class="fas fa-angle-double-left"></i> Previous Character ・ <span class="text-primary"> {!! $extPrevAndNextBtns['prevCharName'] !!} </span>
          </a>
        </div>
      @endif
      @if ($extPrevAndNextBtns['nextCharName'])
        <div class="col text-right float-right">
          <a class="btn btn-outline-success text-success" href="{{ $extPrevAndNextBtns['nextCharUrl'] }}{!! $extPrevAndNextBtnsUrl !!}">
            <span class="text-primary"> {!! $extPrevAndNextBtns['nextCharName'] !!} </span> ・ Next Character <i class="fas fa-angle-double-right"></i>
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

<div id="character-main-profile" class=" mb-0">
  <div class="permission-badges">
    <div class="ownedby grid-span">
      Owned by {!! $character->displayOwner !!}
    </div>
    @include('character._header_permissions', ['character' => $character])
  </div>

  <h1 class="character-name-title">
    @if (!$character->is_visible)
      <i class="fas fa-eye-slash"></i>
    @endif
    {!! $character->displayName !!}
  </h1>
  @if (Settings::get('character_title_display'))
    <div class="h5"> {!! $character->image->displayTitles !!} </div>
  @endif

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
