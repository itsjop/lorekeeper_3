<div class=" {{ $charType }} palate-colors {{ getSubtypeInfo($character->image->subtype_id, 'label', null, $character) }}">
  <a href="{{ $character->url }}" class="cardslot">
    <div class="card">
      <div class="card-border"></div>
      <div class="card-bg"></div>
    </div>
    <img src="{{ $character->image->thumbnailUrl }}" class="" />
    <div class="slug">
      {{-- <div class="slug-text">
        {!! $character->slug !!}
      </div> --}}
      {{-- @include('widgets._subtype_badge', ['character', $character]) --}}
    </div>
  </a>
  <div class="name">
    <div class="small">
      {{-- {!! $character->image->species_id ? $character->image->species->displayName : 'No Species' !!} --}}
      {{-- ・ {!! $character->image->rarity_id ? $character->image->rarity->displayName : 'No Rarity' !!}  --}}
      {{-- <br> --}}
      {{-- {!! $character->image->subtype_id ? $character->image->subtype->displayName : 'None' !!} Palate --}}
      {!! $character->slug !!}
      {!! $character->displayOwner !!}
    </div>
    @if (!$character->is_visible)
      <a href="{{ $character->url }}" class=" h5 mb-0">
        <i class="fas fa-eye-slash"></i>
      </a>
    @endif

    <a href="{{ $character->url }}" class="namelink">
      <span style="font-family: 'Baloo 2';">
        {{ $charType == 'secondary' ? '& ' : '' }}
      </span>
      <span class="">
        {!! $character->name !!}
      </span>
    </a>
  </div>
</div>
