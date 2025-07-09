<div class="masterlist-character text-center">
  {{-- Subtype Badge --}}
  <div class="ml-badge">
    <img src="{{ asset('images/somnivores/masterlist/type_badges/currency-lunes.png') }}" alt="{{ 'Subtype badge for ' . $character->url . '.' }}">
  </div>
  {{-- Name --}}
  <div class="name">
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
    <img class="tn-background" src="{{ asset('images/somnivores/masterlist/char_profile_bg.png') }}">
    <img
      src="
        {{ $character->image->canViewFull(Auth::user() ?? null) && file_exists(public_path($character->image->imageDirectory . '/' . $character->image->fullsizeFileName)) ? $character->image->thumbnailUrl : $character->image->thumbnailUrl }}"
      class="ml-thumbnail" alt="Thumbnail for {{ $character->nameFallback }}" />
  </a>
  {{-- Owner --}}
  {!! $character->displayOwner !!}
  {{-- Character Number ID --}}
  <div class="slug">
    {{ Illuminate\Support\Str::limit($character->slug, 20, $end = '...') }}
  </div>

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
