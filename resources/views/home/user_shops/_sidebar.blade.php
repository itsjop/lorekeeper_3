<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ url('/') }}" class="card-link">User Shops</a>
  </div>
  @if (Auth::check())
    <div class="details-sb" data-open>
      <summary class="sidebar-section-header">History</summary>
      <div class="sb-item">
        <a href="{{ url('user-shops/history') }}" class="{{ set_active('user-shops/history*') }}">Purchase History</a>
      </div>
    </div>
    <div class="details-sb" data-open>
      <summary class="sidebar-section-header">My Currencies</summary>
      @foreach (Auth::user()->getCurrencies(true) as $currency)
        <div class="sb-item pr-3">
          {!! $currency->display($currency->quantity) !!}
        </div>
      @endforeach
    </div>
  @endif

  <div class="details-sb" data-open>
    <summary class="sidebar-section-header">User Shops</summary>
    @auth
      @if (Auth::user()->shops()->count() && Settings::get('user_shop_limit') == 1)
        <div class="sb-item">
          <a href="{{ url(Auth::user()->shops()->first()->editUrl) }}"
            class="{{ set_active(Auth::user()->shops()->first()->editUrl) }}"
          >My Shop</a>
        </div>
      @else
        <div class="sb-item">
          <a href="{{ url('user-shops') }}" class="{{ set_active('user-shops') }}">My Shops</a>
        </div>
      @endif
    @endauth
    <div class="sb-item">
      <a href="{{ url('user-shops/shop-index') }}" class="{{ set_active('user-shops/shop-index*') }}">All User Shops</a>
    </div>
    <div class="sb-item">
      <a href="{{ url('user-shops/item-search') }}" class="{{ set_active('user-shops/item-search*') }}">Search For Item</a>
    </div>
  </div>
</div>
