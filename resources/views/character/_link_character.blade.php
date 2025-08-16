<div class="">
  <div>
    <a href="{{ $character->url }}">
      <img src="{{ $character->image->thumbnailUrl }}" class="img-thumbnail w-80" />
    </a>
  </div>
  <div class="mt-1">
    <a href="{{ $character->url }}" class="h5 mb-0">
      @if (!$character->is_visible)
        <i class="fas fa-eye-slash"></i>
      @endif {!! $character->formattedName !!}
    </a>
  </div>
  <div class="small">
    {{-- {!! $character->image->species_id ? $character->image->species->displayName : 'No Species' !!} --}}
    {{-- ・ {!! $character->image->rarity_id ? $character->image->rarity->displayName : 'No Rarity' !!}  --}}
    {{-- <br> --}}
    {!! $character->image->subtype_id ? $character->image->subtype->displayName : 'None' !!} Palate
    <br>
    {!! $character->displayOwner !!}
  </div>
</div>
