<div class="col-md-7">
  <div class="text-center">
    @if ($warnings)
      @include('widgets._cw_img', [
          'src' =>
              $image->canViewFull(Auth::check() ? Auth::user() : null) &&
              file_exists(public_path($image->imageDirectory . '/' . $image->fullsizeFileName))
                  ? $image->fullsizeUrl
                  : $image->imageUrl,
          'class' => 'image',
          'alt' => $character->fullName,
          'warning' => $warnings
      ])
    @else
      <a
        href="{{ $image->canViewFull(Auth::check() ? Auth::user() : null) && file_exists(public_path($image->imageDirectory . '/' . $image->fullsizeFileName)) ? $image->fullsizeUrl : $image->imageUrl }}"
        data-lightbox="entry"
        data-title="{{ $character->fullName }}"
      >
        <img
          src="{{ $image->canViewFull(Auth::check() ? Auth::user() : null) && file_exists(public_path($image->imageDirectory . '/' . $image->fullsizeFileName)) ? $image->fullsizeUrl : $image->imageUrl }}"
          class="image"
          alt="{{ $character->fullName }}"
        />
      </a>
    @endif
  </div>
  @if (
      $image->canViewFull(Auth::check() ? Auth::user() : null) &&
          file_exists(public_path($image->imageDirectory . '/' . $image->fullsizeFileName))
  )
    <div class="text-right">You are viewing the full-size image. <a href="{{ $image->imageUrl }}">View watermarked image</a>?</div>
  @endif
</div>
@include('character._image_info', ['image' => $image])
