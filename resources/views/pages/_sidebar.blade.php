<div class="featured-character">
  <div class="sidebar-header">
    <a href="#" class="card-link">
      <i class="fas fa-star mr-2"></i>
      Star of the Week!
    </a>
  </div>

  <div class="sidebar-section p-2">
    @if (isset($featured) && $featured)
      <a class="thumb" href="{{ $featured->url }}">
        <div class="character-border">
          <div class="rainbow"></div>
          <div class="stars"></div>
          {{-- <div class="char-filter"></div> --}}
        </div>
        <img src="{{ $featured->image->canViewFull(Auth::user() ?? null) && file_exists(public_path($featured->image->imageDirectory . '/' . $featured->image->fullsizeFileName)) ? $featured->image->fullsizeUrl : $featured->image->imageUrl }}"
          class="img-char-thumbnail" />
      </a>
      <a class="name" href="{{ $featured->url }}" class="h5 mb-0">
        @if (!$featured->is_visible)
          <i class="fas fa-eye-slash"></i>
        @endif {{ $featured->fullName }}
      </a>
      {!! $featured->displayOwner !!}
      <div class="species" class="small">
        {!! $featured->image->species_id ? $featured->image->species->displayName : 'No Species' !!}
      </div>
      <div class="rarity" class="small">
        {!! $featured->image->rarity_id ? $featured->image->rarity->displayName : 'No Rarity' !!}
      </div>
    @else
      <p>There is no featured character.</p>
    @endif
  </div>
</div>
