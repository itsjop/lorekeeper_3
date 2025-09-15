<div class="card submission flex-fill text-center mb-1">
  <a href="{{ $submission->url }}" class="img {{ isset($submission->hash) ? '' : 'noborder' }}">
    @include('widgets._gallery_thumb', ['submission' => $submission])
  </a>
  <?php if (isset($submission->hash) && !isset($submission->content_warning)) {
      $width = 200;
  } else {
      $width = 200;
  } ?>
  <div class="title mt-1 mx-auto"
    style="max-width:{{ max(200, $width) }}px; overflow: hidden; text-overflow: ellipsis;   line-height: 1em;"
  >
    {{ substr($submission->displayTitle, 0, 40) . '' . (strlen($submission->displayTitle) > 40 ? '...' : '') }}
    @if (isset($submission->content_warning))
      <p class="m-0">
        <strong class="text-danger"> CW:</strong>
        {!! nl2br(htmlentities($submission->content_warning)) !!}
      </p>
    @endif
    <a href="{{ $submission->url }}" class="h5 mb-0">
      @if (!$submission->isVisible)
        <i class="fas fa-eye-slash"></i>
      @endif
    </a>
  </div>
  <div class="details small">
    @if (Auth::check() &&
            ($submission->user->id != Auth::user()->id &&
                $submission->collaborators->where('user_id', Auth::user()->id)->first() == null) &&
            $submission->isVisible
    )
      {!! Form::open(['url' => '/gallery/favorite/' . $submission->id]) !!}
      @if (isset($gallery) && !$gallery)
        In {!! $submission->gallery->displayName !!} ・
      @endif
      By {!! $submission->credits !!}
      @if (isset($gallery) && !$gallery)
        <br />
      @else
        ・
      @endif
      {{ $submission->favorites_count }} {!! Form::button('<i class="fas fa-star"></i> ', [
          'style' => 'border:0; border-radius:.5em; color: var(--primary-clr_600);',
          'class' => $submission->favorites->where('user_id', Auth::user()->id)->first() != null ? 'btn-success' : '',
          'data-toggle' => 'tooltip',
          'title' =>
              ($submission->favorites->where('user_id', Auth::user()->id)->first() == null ? 'Add to' : 'Remove from') .
              ' your Favorites',
          'type' => 'submit'
      ]) !!} ・
      {{ $submission->comments->where('type', 'User-User')->count() }}
      <i class="fas fa-comment" style=" color: var(--primary-clr_600);"></i>
      {!! Form::close() !!}
    @else
      @if (isset($gallery) && !$gallery)
        In {!! $submission->gallery->displayName !!} ・
      @endif
      By {!! $submission->credits !!}
      @if (isset($gallery) && !$gallery)
        <br />
      @else
        ・
      @endif
      {{ $submission->favorites_count }}
      <i
        class="fas fa-star"
        data-bs-toggle="tooltip"
        title="Favorites"
      >
      </i> ・
      {{ $submission->comments->where('type', 'User-User')->count() }} <i
        class="fas fa-comment"
        data-bs-toggle="tooltip"
        title="Comments"
      ></i>
    @endif
  </div>
</div>
