<div id="{{ strtolower($character->slug) }}"
  class="masterlist-character text-center {{ getSubtypeInfo($character->image->subtype_id, 'label', null, $character) }}"
>
  {{-- Subtype Badge --}}
  <div class="ml-badge">
    <div class="flag">
      <div class="bg"></div>
      <div class="label">
        {{ ucfirst(getSubtypeInfo($character->image->subtype_id)) }} Palate
      </div>
    </div>
    <img src="{{ asset('images/subtypes/badges/' . getSubtypeInfo($character->image->subtype_id) . '.png') }}"
      alt="{{ 'Subtype badge for ' . $character->url . '.' }}"
    >
  </div>
  <div class="border-background"></div>
  {{-- Name --}}
  <div
    class="name {{ strlen($character->nameFallback) > 14 ? 'name-sm' : (strlen($character->nameFallback) < 8 ? 'name-lg' : '') }}"
  >
    <a href="{{ $character->url }}" class="">
      @if (!$character->is_visible)
        <i class="fas fa-eye-slash"></i>
      @endif
      {!! $character->warnings !!}
      {{ Illuminate\Support\Str::limit($character->nameFallback, 20, $end = '...') }}
    </a>
  </div>
  {{-- Thumbnail / Main Image --}}
  <a class="thumbnail" href="{{ $character->url }}">
    {{-- {{ $char_image = $character->image->canViewFull(Auth::user() ?? null) && file_exists(public_path($character->image->imageDirectory . '/' . $character->image->fullsizeFileName)) ? $character->image->thumbnailUrl : $character->image->thumbnailUrl }}" --}}
    <div class="tn-background"></div>
    <div class="ml-thumbnail">
      <img src="{{ $char_image }}" alt="Thumbnail for {{ $character->nameFallback }}" />
      {{-- <div class="shine" style=" {{ '--card_shine_mask-image: url(' . $char_image . ');' }} "></div> --}}
    </div>
  </a>
  {{-- Character Number ID --}}
  <div class="slug gap-_5 flex">
    <div class="fas fa-star"></div>
    {{ Illuminate\Support\Str::limit($character->slug, 20, $end = '...') }}
  </div>
  {{-- Owner --}}
  <div class="display-user flex  gap-_5 ">
    {!! $character->user->name !!}
    <div class="fas fa-user"></div>
  </div>
  {{-- Paper Overlay --}}
  <div class="paper-overlay"></div>
  {{-- vvv Disabled Content vvv --}}
  {{--   Somnivore Species Label --}}
  {{--     {!! $character->image->species_id ? $character->image->species->displayName : 'No ' . ucfirst(__('lorekeeper.species')) !!} --}}
  {{--   Content Warning --}}
  {{--     @if (count($character->image->content_warnings ?? []) && (!Auth::check() || (Auth::check() && Auth::user()->settings->content_warning_visibility < 2)))
           <p class="mb-0">
             <span class="text-danger mr-1"><strong>Character Warning:</strong></span>
             {{ implode(', ', $character->image->content_warnings) }}
           </p>
           @endif --}}
  {{--   Block Details --}}
  {{--     <div class="mt-1">@include('widgets._object_block', ['object' => $character->image])</div> --}}
  {{--   Character Rarity --}}
  {{--     {!! $character->image->rarity_id ? $character->image->rarity->displayName : 'No Rarity' !!} --}}
</div>

<script>
  document.addEventListener('mousemove', function(event) {
    let card = $('#' + '{{ strtolower($character->slug) }} .thumbnail');
    card.mousemove(function(e) {
      let xp = ((e.pageX - card.offset().left) / card.width()).toFixed(3);
      let yp = ((e.pageY - card.offset().top) / card.height()).toFixed(3);
      card.attr("style", `--mpx:${xp}; --mpy:${yp}`);
    });
  });
</script>
