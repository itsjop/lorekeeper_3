<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ url('news') }}" class="card-link">News</a>
  </div>
  @if (isset($newses))
    <div class="details-sb" data-open>
      <summary class="sidebar-section-header">On This Page</summary>
      @foreach ($newses as $news)
        @php $newslink = 'news/'.$news->slug; @endphp
        <div class="sb-item">
          <a href="{{ $news->url }}" class="{{ set_active($newslink) }}">{{ $news->title }}</a>
        </div>
      @endforeach
    </div>
  @else
    <div class="details-sb" data-open>
      <summary class="sidebar-section-header">Recent News</summary>
      @foreach ($recentnews as $news)
        @php $newslink = 'news/'.$news->slug; @endphp
        <div class="sb-item">
          <a href="{{ $news->url }}" class="{{ set_active($newslink) }}">{{ $news->title }}</a>
        </div>
      @endforeach
    </div>
  @endif
</div>
