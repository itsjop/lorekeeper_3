<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ url('news') }}" class="card-link">News</a>
  </div>
  @if (isset($newses))
    <details class="sidebar-section" open>
      <summary class="sidebar-section-header">On This Page</summary>
      <ul>
        @foreach ($newses as $news)
          @php $newslink = 'news/'.$news->slug; @endphp
          <li class="sidebar-item">
            <a href="{{ $news->url }}" class="{{ set_active($newslink) }}">{{ $news->title }}</a>
          </li>
        @endforeach
      </ul>
    </details>
  @else
    <details class="sidebar-section" open>
      <summary class="sidebar-section-header">Recent News</summary>
      <ul>
        @foreach ($recentnews as $news)
          @php $newslink = 'news/'.$news->slug; @endphp
          <li class="sidebar-item">
            <a href="{{ $news->url }}" class="{{ set_active($newslink) }}">{{ $news->title }}</a>
          </li>
        @endforeach
      </ul>
    </details>
  @endif
</div>
