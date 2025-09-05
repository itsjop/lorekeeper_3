<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ url('shops') }}" class="card-link">Shops</a>
  </div>

  @if (Auth::check())
    <div class="details-sb" data-open>
      <summary class="sidebar-section-header">History</summary>
      <div class="sb-item">
        <a href="{{ url('shops/history') }}" class="{{ set_active('shops/history') }}">
          My Purchase History
        </a>
      </div>
    </div>
    <div class="details-sb" data-open>
      <summary class="sidebar-section-header">My Currencies</summary>
      @foreach (Auth::user()->getCurrencies(true) as $currency)
        <div class="sb-item pr-3">
          {!! $currency->display($currency->quantity) !!}
        </div>
      @endforeach
  @endif
  <div class="details-sb" data-open>
    <summary class="sidebar-section-header">Shops</summary>
    @foreach ($shops as $shop)
      @if ($shop->is_staff)
        @if (Auth::check() && Auth::user()->isstaff)
          <div class="sb-item">
            <a href="{{ $shop->url }}" class="{{ set_active('shops/' . $shop->id) }}">
              {{ $shop->name }}
            </a>
          </div>
        @endif
      @else
        <div class="sb-item">
          <a href="{{ $shop->url }}" class="{{ set_active('shops/' . $shop->id) }}">{{ $shop->name }}</a>
        </div>
      @endif
    @endforeach
    {{-- <div class="sb-item">
      <a href="{{ url('shops/donation-shop') }}" class="{{ set_active('shops/donation-shop') }}">
        Donation Shop
      </a>
    </div> --}}
  </div>
</div>
