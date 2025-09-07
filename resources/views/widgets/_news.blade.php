{{-- <div class="card-header">
        <h4 class="mb-0">
<i class="fas fa-newspaper"></i> Recent News</h4>
    </div> --}}
@if ($newses->count())
  @foreach ($newses as $news)
    <div class="grid ji-start js-start my-2 w-100 {{ !$loop->last ? 'border-bottom' : ' mt-2' }}">
      <h5 class="mb-0">
        {!! $news->displayName !!}
      </h5>
      <p class="m-0 small">
        Posted: {!! $news->post_at ? pretty_date($news->post_at) : pretty_date($news->created_at) !!}{!! $news->created_at != $news->updated_at ? ' - Edited: ' . pretty_date($news->updated_at) : '' !!}
      </p>
      <hr class="m-1 w-100">
      @if ($textPreview)
        <p class="text-left m-0">
          {!! substr(strip_tags(str_replace('<br />', '&nbsp;', $news->parsed_text)), 0, 200) !!}...
          <a href="{!! $news->url !!}">Read more <i class="fas fa-arrow-right"></i>
          </a>
        </p>
      @endif
    </div>
  @endforeach
@else
  <div class="text-center ">
    <h5 class="text-muted">There is no news.</h5>
  </div>
@endif
