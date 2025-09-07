<ul class="nav nav-tabs flex gap-_5">
  <li class="nav-item">
    <a class="nav-link {{ set_active('admin/masterlist/transfers/incoming*') }}" href="{{ url('admin/masterlist/transfers/incoming') }}"> Incoming Transfers @if ($transferCount)
        <span class="badge badge-primary"> {{ $transferCount }} </span>
      @endif
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ set_active('admin/masterlist/trades/incoming*') }}" href="{{ url('admin/masterlist/trades/incoming') }}"> Incoming Trades @if ($tradeCount)
        <span class="badge badge-primary"> {{ $tradeCount }} </span>
      @endif
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ set_active('admin/masterlist/transfers/completed*') }}" href="{{ url('admin/masterlist/transfers/completed') }}"> Completed Transfers </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ set_active('admin/masterlist/trades/completed*') }}" href="{{ url('admin/masterlist/trades/completed') }}"> Completed Trades </a>
  </li>
</ul>
