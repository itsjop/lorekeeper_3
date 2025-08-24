<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ url('professions') }}" class="card-link"></a>
  </div>
  <div class="details-sb" data-open>
    <summary class="sidebar-section-header">Professions</summary>
    @foreach ($categories as $category)
      <div class="sb-item">
        <a href="{{ url('/professions/' . $category->id) }}"
          class="{{ set_active('professions/' . $category->id . '*') }}">{{ $category->name }}</a>
      </div>
    @endforeach
    <div class="sidebar-header">
      <a href="{{ url('professions') }}" class="card-link">Characters</a>
    </div>
  </div>
  <div class="details-sb" data-open>
    <summary class="sidebar-section-header">Categories</summary>
    <div class="sb-item">
      @foreach ($categories as $category)
        <a href="{{ url('/professions/characters/' . $category->id) }}"
          class="{{ set_active('professions/characters/' . $category->id . '*') }}"
        >{{ $category->name }}</a>
      @endforeach
    </div>
  </div>
</div>
