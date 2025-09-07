<div id="sb-featured-desktop">
  <div class="featured-character">
    <?php if (isset($featured)) {
        $char_image = $featured->image->canViewFull(Auth::user() ?? null) && file_exists(public_path($featured->image->imageDirectory . ' /' . $featured->image->fullsizeFileName)) ? $featured->image->thumbnailUrl : $featured->image->thumbnailUrl;
    } ?>
    <div class="sidebar-header">
      <a href="#" class="card-link">
        <i class="fas fa-star mr-2"></i>
        Star of the Week!
      </a>
    </div>
    <div class="details-sb p-2">
      @if (isset($featured) && $featured)
        <a class="thumb" href="{{ $featured->url }}">
          <div class="character-border">
            <div class="rainbow">
            </div>
            <div class="stars">
            </div>
          </div>
          <img
            src="{{ $featured->image->canViewFull(Auth::user() ?? null) && file_exists(public_path($featured->image->imageDirectory . '/' . $featured->image->fullsizeFileName)) ? $featured->image->fullsizeUrl : $featured->image->imageUrl }}"
            class="img-char-thumbnail"
          />
        </a>
        <a class="name h5 mb-0 ta-center" href="{{ $featured->url }}">
          @if (!$featured->is_visible)
            <i class="fas fa-eye-slash"></i>
          @endif {{ $featured->name }}
        </a>
        <a class="slug mb-0" href="{{ $featured->url }}">
          {!! $featured->slug !!}
        </a>
        {!! $featured->displayOwner !!}
        {{-- <div class="species" class="small"> --}}
        {{-- {!! $featured->image->species_id ? $featured->image->species->displayName : 'No Species' !!} --}}
        {{-- </div> --}}
        {{-- <div class="rarity" class="small">
        {!! $featured->image->rarity_id ? $featured->image->rarity->displayName : 'No Rarity' !!}
      </div> --}}
      @else
        <p> There is no featured character. </p>
      @endif
    </div>
  </div>
</div>

@if (isset($featured) && $featured)
  <div id="sb-featured-mobile">
    <div class="featured-character palate-colors {{ getSubtypeInfo($featured->image->subtype_id, 'label', null, $featured) }}">
      <?php $char_image = $featured->image->canViewFull(Auth::user() ?? null) && file_exists(public_path($featured->image->imageDirectory . ' /' . $featured->image->fullsizeFileName)) ? $featured->image->thumbnailUrl : $featured->image->thumbnailUrl; ?>
      <div class="character details-sb">
        @if (isset($featured) && $featured)
          <a class="thumb" href="{{ $featured->url }}">
            <div class="character-border">
              <div class="rainbow">
              </div>
              <div class="stars">
              </div>
            </div>
            <img
              src="{{ $featured->image->canViewFull(Auth::user() ?? null) && file_exists(public_path($featured->image->imageDirectory . '/' . $featured->image->fullsizeFileName)) ? $featured->image->fullsizeUrl : $featured->image->imageUrl }}"
              class="img-char-thumbnail"
            />
          </a>
        @else
          <p> There is no featured featured. </p>
        @endif
      </div>
      <div class="info">
        <a href="#" class="sidebar-header card-link">
          <i class="fas fa-star mr-2"></i>
          Star of the Week!
        </a>
        <div class="meta">
          <a class="name h5 mb-0 ta-center {{ strlen($featured->name) > 10 ? 'name-sm' : (strlen($featured->name) < 6 ? 'name-lg' : '') }}"
            href="{{ $featured->url }}"
          >
            @if (!$featured->is_visible)
              <i class="fas fa-eye-slash"></i>
            @endif {{ $featured->name }}
          </a>
          <a class="slug mb-0" href="{{ $featured->url }}">
            {!! $featured->slug !!}
          </a>

          {!! $featured->displayOwner !!}
        </div>
        <div class="ml-badge baddge">
          <div class="flag">
            <div class="bg">
            </div>
            <div class="label">
              {{ ucfirst(getSubtypeInfo($featured->image->subtype_id)) }} Palate
            </div>
          </div>
          <img src="{{ asset('images/subtypes/badges/' . getSubtypeInfo($featured->image->subtype_id) . '.png') }}"
            alt="{{ 'Subtype badge for ' . $featured->url . '.' }}"
          >
        </div>
      </div>
    </div>
  </div>
@endif

<div id="kofi-banner-dt" class="mt-4">
  <div class="featured-character">
    <div class="sidebar-header">
      <a href="#" class="card-link">
        <i class="fas fa-star mr-2"></i>
        Support Somnivores!
      </a>
    </div>
    <div class="details-sb p-2">
      <a class="thumb" href="/world/items/78">
        <div class="character-border">
          <div class="rainbow kofi">
          </div>
          <div class="stars paused">
          </div>
        </div>
        <img src="{{ asset('images/somnivores/site/kofi-gift.png') }}" class="img-char-thumbnail kofi-gift" />
      </a>
      <a class="name flex gap-_5 h5 mb-4" href="https://ko-fi.com/somnivores/tiers">
        Somnivores' Ko-fi
        <span class="small flex ai-center">
          <i class="fa-solid fa-arrow-up-right-from-square "></i>
        </span>
      </a>
      <p class="text-center" style="width: var(--sidebar-width);">
        We offer monthly goodies! <br>
        Click to see what's included ❤
      </p>
    </div>
  </div>
</div>

<div id="kofi-banner-mb">

</div>
