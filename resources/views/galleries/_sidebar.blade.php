<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ url('gallery') }}" class="card-link">Gallery</a>
  </div>

  @auth
    <details class="sidebar-section" open>
      <summary class="sidebar-section-header">My Submissions</summary>
      <ul>
        <li class="sidebar-item">
          <a href="{{ url('gallery/submissions/pending') }}" class="{{ set_active('gallery/submissions*') }}">My Submission Queue</a>
        </li>
        <li class="sidebar-item">
          <a href="{{ url('user/' . Auth::user()->name . '/gallery') }}" class="{{ set_active('user/' . Auth::user()->name . '/gallery') }}">My Gallery</a>
        </li>
        <li class="sidebar-item">
          <a href="{{ url('user/' . Auth::user()->name . '/favorites') }}" class="{{ set_active('user/' . Auth::user()->name . '/favorites') }}">My Favorites</a>
        </li>
      </ul>
    </details>
  @endauth
  @if (config('lorekeeper.extensions.show_all_recent_submissions.enable') && config('lorekeeper.extensions.show_all_recent_submissions.links.sidebar'))
    <details class="sidebar-section" open>
      <summary class="sidebar-section-header">Submissions</summary>
      <ul>
        <li class="sidebar-item">
          <a href="{{ url('gallery/all') }}" class="{{ set_active('gallery/all') }}">All Recent Submissions</a>
        </li>
      </ul>
    </details>
  @endif

  @if ($galleryPage && $sideGallery->children->count())
    <details class="sidebar-section" open>
      <summary class="sidebar-section-header">{{ $sideGallery->name }}: Sub-Galleries</summary>
      <ul>
        @foreach ($sideGallery->children()->visible()->get() as $child)
          <li class="sidebar-item">
            <a href="{{ url('gallery/' . $child->id) }}" class="{{ set_active('gallery/' . $child->id) }}">{{ $child->name }}</a>
          </li>
        @endforeach
      </ul>
    </details>
  @endif

  @if ($galleryPage && $sideGallery->siblings() && $sideGallery->siblings->count())
    <details class="sidebar-section" open>
      <summary class="sidebar-section-header">{{ $sideGallery->parent->name }}: Sub-Galleries</summary>
      <ul>
        @foreach ($sideGallery->siblings()->visible()->get() as $sibling)
          <li class="sidebar-item">
            <a href="{{ url('gallery/' . $sibling->id) }}" class="{{ set_active('gallery/' . $sibling->id) }}">
              {{ $sibling->name }}</a>
          </li>
        @endforeach
        </li>
      </ul>
    </details>
  @endif

  @if ($galleryPage && $sideGallery->avunculi() && $sideGallery->avunculi->count())
    <details class="sidebar-section" open>
      <summary class="sidebar-section-header">{{ $sideGallery->parent->parent->name }}: Sub-Galleries</summary>
      <ul>
        @foreach ($sideGallery->avunculi()->visible()->get() as $avunculus)
          <li class="sidebar-item">
            <a href="{{ url('gallery/' . $avunculus->id) }}" class="{{ set_active('gallery/' . $avunculus->id) }}">{{ $avunculus->name }}</a>
          </li>
        @endforeach
      </ul>
    </details>
  @endif

  <details class="sidebar-section" open>
    <summary class="sidebar-section-header">Galleries</summary>
    <ul>
      @foreach ($sidebarGalleries as $gallery)
        <li class="sidebar-item">
          <a href="{{ url('gallery/' . $gallery->id) }}" class="{{ set_active('gallery/' . $gallery->id) }}">{{ $gallery->name }}</a>
        </li>
      @endforeach
    </ul>
  </details>
</div>
