<div class="profile-assets-content grid pi-center w-100 pb-2">
  <div class="selected-header card-title w-100 text-center br-top-10 p-1">Selected Character</div>
  @if ($character)
    <a class="grid pi-center" href="{{ $character->url }}">
      <img
        src="{{ isset($fullImage) && $fullImage ? $character->image->thumbnailUrl : $character->image->imageUrl }}"
        class="{{ isset($fullImage) && $fullImage ? '' : 'img-thumbnail' }} "
        alt="{{ $character->fullName }}"
      />
    </a>
    <a href="{{ $character->url }}" class="h5 ta-center mb-0">

      @if (!$character->is_visible)
        <i class="fas fa-eye-slash"></i>
      @endif
      {!! $character->formattedName !!}
    </a>
  @else
    <p class="ta-center">{{ Auth::check() && Auth::user()->id == $user->id ? 'You have' : 'This user has' }} no selected
      character.</p>
  @endif
  <div class="text-center">
    <a href="{{ $user->url . '/characters' }}" class="btn btn-primary">View All Characters</a>
  </div>
</div>
