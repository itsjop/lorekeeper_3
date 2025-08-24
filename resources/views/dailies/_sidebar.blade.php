<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ url(__('dailies.dailies')) }}" class="card-link">{{ __('dailies.dailies') }}</a>
  </div>
  <div class="details-sb" data-open>
    <summary class="sidebar-section-header">Dailies</summary>
    @foreach ($dailies as $daily)
      <div class="sb-item">
        <a href="{{ $daily->url }}" class="{{ set_active('dailies/' . $daily->id) }}">{{ $daily->name }}</a>
      </div>
    @endforeach
  </div>
</div>
