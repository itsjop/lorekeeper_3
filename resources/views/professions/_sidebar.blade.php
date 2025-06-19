<div id="sidebar-ul">
  <li class="sidebar-header">
    <a href="{{ url('professions') }}" class="card-link">Professions</a>
  </li>
  <details class="sidebar-section">
    <ul>
      @foreach ($categories as $category)
        <li class="sidebar-item">
          <a href="{{ url('/professions/' . $category->id) }}"
            class="{{ set_active('professions/' . $category->id . '*') }}">{{ $category->name }}</a>
        </li>
      @endforeach
      <li class="sidebar-header">
        <a href="{{ url('professions') }}" class="card-link">Characters</a>
      </li>
    </ul>
  </details>
  <details class="sidebar-section">
    <li class="sidebar-item">
      @foreach ($categories as $category)
        <a href="{{ url('/professions/characters/' . $category->id) }}"
          class="{{ set_active('professions/characters/' . $category->id . '*') }}"
        >{{ $category->name }}</a>
      @endforeach
    </li>
  </details>
</div>
