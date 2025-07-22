<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ url('/') }}" class="card-link">User Shops</a>
  </div>
  @if (Auth::check())
    <details class="sidebar-section" open>
      <summary class="sidebar-section-header">History</summary>
      <ul>
        <li class="sidebar-item">
          <a href="{{ url('user-shops/history') }}" class="{{ set_active('user-shops/history*') }}">Purchase History</a>
        </li>
      </ul>
    </details>
    <details class="sidebar-section" open>
      <summary class="sidebar-section-header">My Currencies</summary>
      <ul>
        @foreach (Auth::user()->getCurrencies(true) as $currency)
          <div class="sidebar-item pr-3">{!! $currency->display($currency->quantity) !!}</div>
        @endforeach
        </li>
      </ul>
    </details>
  @endif

  <details class="sidebar-section" open>
    <summary class="sidebar-section-header">User Shops</summary>
    <ul>
      @auth
        @if (Auth::user()->shops()->count() && Settings::get('user_shop_limit') == 1)
          <li class="sidebar-item">
            <a href="{{ url(Auth::user()->shops()->first()->editUrl) }}" class="{{ set_active(Auth::user()->shops()->first()->editUrl) }}">My Shop</a>
          </li>
        @else
          <li class="sidebar-item">
            <a href="{{ url('user-shops') }}" class="{{ set_active('user-shops') }}">My Shops</a>
          </li>
        @endif
      @endauth
      <li class="sidebar-item">
        <a href="{{ url('user-shops/shop-index') }}" class="{{ set_active('user-shops/shop-index*') }}">All User Shops</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('user-shops/item-search') }}" class="{{ set_active('user-shops/item-search*') }}">Search For Item</a>
      </li>
    </ul>
  </details>
</div>
