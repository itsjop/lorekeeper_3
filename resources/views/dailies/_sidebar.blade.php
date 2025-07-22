<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ url(__('dailies.dailies')) }}" class="card-link">{{ __('dailies.dailies') }}</a>
  </div>
  <details class="sidebar-section" open>
    <summary class="sidebar-section-header">Dailies</summary>
    <ul>
      @foreach ($dailies as $daily)
        <li class="sidebar-item">
          <a href="{{ $daily->url }}" class="{{ set_active('dailies/' . $daily->id) }}">{{ $daily->name }}</a>
        </li>
      @endforeach
    </ul>
  </details>
</div>
