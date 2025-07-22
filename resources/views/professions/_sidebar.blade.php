<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ url('professions') }}" class="card-link"></a>
  </div>
  <details class="sidebar-section" open>
    <summary class="sidebar-section-header">Professions</summary>
    <ul>
      @foreach ($categories as $category)
        <li class="sidebar-item">
          <a href="{{ url('/professions/' . $category->id) }}" class="{{ set_active('professions/' . $category->id . '*') }}">{{ $category->name }}</a>
        </li>
      @endforeach
      <div class="sidebar-header">
        <a href="{{ url('professions') }}" class="card-link">Characters</a>
      </div>
    </ul>
  </details>
  <details class="sidebar-section" open>
    <summary class="sidebar-section-header">Categories</summary>
    <ul>
      <li class="sidebar-item">
        @foreach ($categories as $category)
          <a href="{{ url('/professions/characters/' . $category->id) }}" class="{{ set_active('professions/characters/' . $category->id . '*') }}">{{ $category->name }}</a>
        @endforeach
      </li>
    </ul>
  </details>
</div>
