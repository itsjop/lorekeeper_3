<div class="gallery-recents grid-4-col singlerow ji-between text-center w-100">
  @foreach ($myos as $character)
    @include('browse._masterlist_content_entry', [
        'char_image' =>
            $character->image->canViewFull(Auth::user() ?? null) &&
            file_exists(public_path($character->image->imageDirectory . ' /  ' . $character->image->fullsizeFileName))
                ? $character->image->thumbnailUrl
                : $character->image->thumbnailUrl
    ])
  @endforeach
</div>
