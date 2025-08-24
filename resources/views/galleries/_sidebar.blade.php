<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ url('gallery') }}" class="card-link">Gallery</a>
  </div>

  @auth
    <div class="details-sb" data-open>
      <summary class="sidebar-section-header">My Submissions</summary>
      <div class="sb-item">
        <a href="{{ url('gallery/submissions/pending') }}" class="{{ set_active('gallery/submissions*') }}">My Submission Queue</a>
      </div>
      <div class="sb-item">
        <a href="{{ url('user/' . Auth::user()->name . '/gallery') }}"
          class="{{ set_active('user/' . Auth::user()->name . '/gallery') }}"
        >My Gallery</a>
      </div>
      <div class="sb-item">
        <a href="{{ url('user/' . Auth::user()->name . '/favorites') }}"
          class="{{ set_active('user/' . Auth::user()->name . '/favorites') }}"
        >My Favorites</a>
      </div>
    </div>
  @endauth
  @if (config('lorekeeper.extensions.show_all_recent_submissions.enable') &&
          config('lorekeeper.extensions.show_all_recent_submissions.links.sidebar')
  )
    <div class="details-sb" data-open>
      <summary class="sidebar-section-header">Submissions</summary>
      <div class="sb-item">
        <a href="{{ url('gallery/all') }}" class="{{ set_active('gallery/all') }}">All Recent Submissions</a>
      </div>
    </div>
  @endif

  @if ($galleryPage && $sideGallery->children->count())
    <div class="details-sb" data-open>
      <summary class="sidebar-section-header">{{ $sideGallery->name }}: Sub-Galleries</summary>
      @foreach ($sideGallery->children()->visible()->get() as $child)
        <div class="sb-item">
          <a href="{{ url('gallery/' . $child->id) }}"
            class="{{ set_active('gallery/' . $child->id) }}">{{ $child->name }}</a>
        </div>
      @endforeach
    </div>
  @endif

  @if ($galleryPage && $sideGallery->siblings() && $sideGallery->siblings->count())
    <div class="details-sb" data-open>
      <summary class="sidebar-section-header">{{ $sideGallery->parent->name }}: Sub-Galleries</summary>
      @foreach ($sideGallery->siblings()->visible()->get() as $sibling)
        <div class="sb-item">
          <a href="{{ url('gallery/' . $sibling->id) }}" class="{{ set_active('gallery/' . $sibling->id) }}">
            {{ $sibling->name }}</a>
        </div>
      @endforeach
    </div>
  @endif

  @if ($galleryPage && $sideGallery->avunculi() && $sideGallery->avunculi->count())
    <div class="details-sb" data-open>
      <summary class="sidebar-section-header">{{ $sideGallery->parent->parent->name }}: Sub-Galleries</summary>
      @foreach ($sideGallery->avunculi()->visible()->get() as $avunculus)
        <div class="sb-item">
          <a href="{{ url('gallery/' . $avunculus->id) }}"
            class="{{ set_active('gallery/' . $avunculus->id) }}">{{ $avunculus->name }}</a>
        </div>
      @endforeach
    </div>
  @endif

  <div class="details-sb" data-open>
    <summary class="sidebar-section-header">Galleries</summary>
    @foreach ($sidebarGalleries as $gallery)
      <div class="sb-item">
        <a href="{{ url('gallery/' . $gallery->id) }}"
          class="{{ set_active('gallery/' . $gallery->id) }}">{{ $gallery->name }}</a>
      </div>
    @endforeach
  </div>
</div>
