<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ url(__('cultivation.cultivation')) }}" class="card-link"> {{ ucfirst(__('cultivation.cultivation')) }} </a>
  </div>

  <div class="details-sb" data-open>
    <summary class="sidebar-section-header"> Cultivation </summary>
    <div class="sb-item">
      <a href="{{ url(__('cultivation.cultivation') . '/guide') }}"
        class="{{ set_active(__('cultivation.cultivation') . '/guide') }} btn text-left"
      >
        Cultivation Guide
      </a>
    </div>
  </div>
  <div class="details-sb" data-open>
    <summary class="sidebar-section-header"> {{ ucfirst(__('cultivation.cultivation')) }} Areas </summary>
    @foreach ($areas as $area)
      <div class="sb-item">
        @if (isset($user) && in_array($area->id, $user->areas->pluck('id')->toArray()))
          <a href="{{ $area->idUrl }}" class="{{ set_active(__('cultivation.cultivation') . '/' . $area->id) }} btn text-left">
            {{ $area->name }}
            <i class="fa fa-unlock mr-2"></i>
          </a>
        @else
          <a href="{{ $area->idUrl }}"
            class="{{ set_active(__('cultivation.cultivation') . '/' . $area->id) }} btn disabled text-left"
          >
            {{ $area->name }}
            <i class="fa fa-lock mr-2"></i>
          </a>
        @endif
      </div>
    @endforeach
  </div>
</div>
