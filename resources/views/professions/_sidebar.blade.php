


<ul>
    <li class="sidebar-header"><a href="{{ url('professions') }}" class="card-link">Professions</a></li>

    <li class="sidebar-section">
        <div class="sidebar-item">
        @foreach($categories as $category )
            <a href="{{ url('/professions/'.$category->id) }}" class="{{ set_active('professions/'.$category->id.'*') }}">{{ $category->name }}</a>
        @endforeach
        </div>
    </li>
</ul>