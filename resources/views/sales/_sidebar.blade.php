<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ url('sales') }}" class="card-link">Sales</a>
  </div>
  <details class="sidebar-section" open>
    <summary class="sidebar-section-header">For Sale</summary>
    <ul>
      @foreach ($forsale as $sales)
        @php $salelink = 'sales/'.$sales->slug; @endphp
        <li class="sidebar-item">
          <a href="{{ $sales->url }}" class="{{ set_active($salelink) }}">{{ $sales->title }}</a>
        </li>
      @endforeach
    </ul>
  </details>
  @if (isset($saleses))
    <details class="sidebar-section" open>
      <summary class="sidebar-section-header">On This Page</summary>
      <ul>
        @foreach ($saleses as $sales)
          @php $salelink = 'sales/'.$sales->slug; @endphp
          <li class="sidebar-item">
            <a href="{{ $sales->url }}" class="{{ set_active($salelink) }}">{{ '[' . ($sales->is_open ? 'OPEN' : 'CLOSED') . '] ' . $sales->title }}</a>
          </li>
        @endforeach
        </li>
      </ul>
    </details>
  @else
    <details class="sidebar-section" open>
      <summary class="sidebar-section-header">Recent Sales</summary>
      <ul>
        @foreach ($recentsales as $sales)
          @php $salelink = 'sales/'.$sales->slug; @endphp
          <li class="sidebar-item">
            <a href="{{ $sales->url }}" class="{{ set_active($salelink) }}">{{ '[' . ($sales->is_open ? 'OPEN' : 'CLOSED') . '] ' . $sales->title }}</a>
          </li>
        @endforeach
        </li>
      </ul>
    </details>
  @endif
</div>
