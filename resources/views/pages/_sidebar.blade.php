<div class="featured-character">

  <?php $char_image = $featured->image->canViewFull(Auth::user() ?? null) && file_exists(public_path($featured->image->imageDirectory . ' /' . $featured->image->fullsizeFileName)) ? $featured->image->thumbnailUrl : $featured->image->thumbnailUrl; ?>

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
        </div>
        <img
          src="{{ $featured->image->canViewFull(Auth::user() ?? null) && file_exists(public_path($featured->image->imageDirectory . '/' . $featured->image->fullsizeFileName)) ? $featured->image->fullsizeUrl : $featured->image->imageUrl }}"
          class="img-char-thumbnail"
        />
      </a>
      <a
        class="name"
        href="{{ $featured->url }}"
        class="h5 mb-0"
      >
        @if (!$featured->is_visible)
          <i class="fas fa-eye-slash"></i>
        @endif {{ $featured->fullName }}
      </a>
      {!! $featured->displayOwner !!}
      <div class="species" class="small">
        {!! $featured->image->species_id ? $featured->image->species->displayName : 'No Species' !!}
      </div>
      {{-- <div class="rarity" class="small">
        {!! $featured->image->rarity_id ? $featured->image->rarity->displayName : 'No Rarity' !!}
      </div> --}}
    @else
      <p>There is no featured featured.</p>
    @endif
  </div>
<!--
  <div class="flex">
    <div id="{{ strtolower($featured->slug) }}"
      class="masterlist-character text-center {{ getSubtypeInfo($featured->image->subtype_id, 'label', null, $featured) }}"
    >
      {{-- Subtype Badge --}}
      <div class="ml-badge">
        <div class="flag">
          <div class="bg"></div>
          <div class="label">
            {{ ucfirst(getSubtypeInfo($featured->image->subtype_id)) }} Palate
          </div>
        </div>
        <img src="{{ asset('images/subtypes/badges/' . getSubtypeInfo($featured->image->subtype_id) . '.png') }}"
          alt="{{ 'Subtype badge for ' . $featured->url . '.' }}"
        >
      </div>
      <div class="border-background"></div>
      {{-- Name --}}
      <div
        class="name {{ strlen($featured->nameFallback) > 14 ? 'name-sm' : (strlen($featured->nameFallback) < 8 ? 'name-lg' : '') }}"
      >
        <a href="{{ $featured->url }}" class="">
          @if (!$featured->is_visible)
            <i class="fas fa-eye-slash"></i>
          @endif
          {!! $featured->warnings !!}
          {{ Illuminate\Support\Str::limit($featured->nameFallback, 20, $end = '...') }}
        </a>
      </div>
      {{-- Thumbnail / Main Image --}}
      <a class="thumbnail" href="{{ $featured->url }}">
        {{-- {{ $char_image = $featured->image->canViewFull(Auth::user() ?? null) && file_exists(public_path($featured->image->imageDirectory . '/' . $featured->image->fullsizeFileName)) ? $featured->image->thumbnailUrl : $featured->image->thumbnailUrl }}" --}}
        <div class="tn-background"></div>
        <div class="ml-thumbnail">
          <img src="{{ $char_image }}" alt="Thumbnail for {{ $featured->nameFallback }}" />
          {{-- <div class="shine" style=" {{ '--card_shine_mask-image: url(' . $char_image . ');' }} "></div> --}}
        </div>
      </a>
      {{-- Character Number ID --}}
      <div class="slug gap-_5 flex">
        <div class="fas fa-star"></div>
        {{ Illuminate\Support\Str::limit($featured->slug, 20, $end = '...') }}
      </div>
      {{-- Owner --}}
      <a class="display-user" href="{{ $featured->user->url }}">
        {!! $featured->user->name !!}
        <div class="fas fa-user"></div>
      </a>
      {{-- Paper Overlay --}}
      <div class="paper-overlay"></div>
      {{-- vvv Disabled Content vvv --}}
      {{--   Somnivore Species Label --}}
      {{--     {!! $featured->image->species_id ? $featured->image->species->displayName : 'No ' . ucfirst(__('lorekeeper.species')) !!} --}}
      {{--   Content Warning --}}
      {{--     @if (count($featured->image->content_warnings ?? []) && (!Auth::check() || (Auth::check() && Auth::user()->settings->content_warning_visibility < 2)))
           <p class="mb-0">
             <span class="text-danger mr-1"><strong>Character Warning:</strong></span>
             {{ implode(', ', $featured->image->content_warnings) }}
           </p>
           @endif --}}
      {{--   Block Details --}}
      {{--     <div class="mt-1">@include('widgets._object_block', ['object' => $featured->image])</div> --}}
      {{--   Character Rarity --}}
      {{--     {!! $featured->image->rarity_id ? $featured->image->rarity->displayName : 'No Rarity' !!} --}}
    </div>
  </div>
  <script>
    document.addEventListener('mousemove', function(event) {
      let card = $('#' + '{{ strtolower($featured->slug) }} .thumbnail');
      card.mousemove(function(e) {
        let xp = ((e.pageX - card.offset().left) / card.width()).toFixed(3);
        let yp = ((e.pageY - card.offset().top) / card.height()).toFixed(3);
        card.attr("style", `--mpx:${xp}; --mpy:${yp}`);
      });
    });
  </script>

-->
