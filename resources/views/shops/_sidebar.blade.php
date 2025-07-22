<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ url('shops') }}" class="card-link">Shops</a>
  </div>

  @if (Auth::check())
    <details class="sidebar-section" open>
      <summary class="sidebar-section-header">History</summary>
      <ul>
        <li class="sidebar-item">
          <a href="{{ url('shops/history') }}" class="{{ set_active('shops/history') }}">
            My Purchase History
          </a>
        </li>
      </ul>
    </details>
    <details class="sidebar-section" open>
      <summary class="sidebar-section-header">My Currencies</summary>
      <ul>
        @foreach (Auth::user()->getCurrencies(true) as $currency)
          <li class="sidebar-item pr-3">
            {!! $currency->display($currency->quantity) !!}
          </li>
        @endforeach
      </ul>
    </details>
  @endif
  <details class="sidebar-section" open>
    <summary class="sidebar-section-header">Shops</summary>
    <ul>
      @foreach ($shops as $shop)
        @if ($shop->is_staff)
          @if (Auth::check() && Auth::user()->isstaff)
            <li class="sidebar-item">
              <a href="{{ $shop->url }}" class="{{ set_active('shops/' . $shop->id) }}">
                {{ $shop->name }}
              </a>
            </li>
          @endif
        @else
          <li class="sidebar-item">
            <a href="{{ $shop->url }}" class="{{ set_active('shops/' . $shop->id) }}">{{ $shop->name }}</a>
          </li>
        @endif
      @endforeach
      <li class="sidebar-item">
        <a href="{{ url('shops/donation-shop') }}" class="{{ set_active('shops/donation-shop') }}">
          Donation Shop
        </a>
      </li>
    </ul>
  </details>
</div>
