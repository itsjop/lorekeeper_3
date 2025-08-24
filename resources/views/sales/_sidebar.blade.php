<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ url('sales') }}" class="card-link">Sales</a>
  </div>
  <div class="details-sb" data-open>
    <summary class="sidebar-section-header">For Sale</summary>
    @foreach ($forsale as $sales)
      @php $salelink = 'sales/'.$sales->slug; @endphp
      <div class="sb-item">
        <a href="{{ $sales->url }}" class="{{ set_active($salelink) }}">{{ $sales->title }}</a>
      </div>
    @endforeach
  </div>
  @if (isset($saleses))
    <div class="details-sb" data-open>
      <summary class="sidebar-section-header">On This Page</summary>
      @foreach ($saleses as $sales)
        @php $salelink = 'sales/'.$sales->slug; @endphp
        <div class="sb-item">
          <a href="{{ $sales->url }}"
            class="{{ set_active($salelink) }}">{{ '[' . ($sales->is_open ? 'OPEN' : 'CLOSED') . '] ' . $sales->title }}</a>
        </div>
      @endforeach
    </div>
  @else
    <div class="details-sb" data-open>
      <summary class="sidebar-section-header">Recent Sales</summary>
      @foreach ($recentsales as $sales)
        @php $salelink = 'sales/'.$sales->slug; @endphp
        <div class="sb-item">
          <a href="{{ $sales->url }}"
            class="{{ set_active($salelink) }}">{{ '[' . ($sales->is_open ? 'OPEN' : 'CLOSED') . '] ' . $sales->title }}</a>
        </div>
      @endforeach
    </div>
  @endif
</div>
