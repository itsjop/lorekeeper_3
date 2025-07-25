<nav class="navbar navbar-expand-md" id="header-nav">
  <button
    class="navbar-toggler collapsed"
    type="button"
    data-bs-toggle="collapse"
    data-bs-target="#navbarSupportedContent"
    aria-controls="navbarSupportedContent"
    aria-expanded="false"
    aria-label="{{ __('Toggle navigation') }}"
  >
    <span class="navbar-toggler-icon">
      <span class="line"></span>
      <span class="line"></span>
      <span class="line"></span>
    </span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    {{-- <div class="currency">
      <div class="col-lg-10 col-md-9 col-6">
        {{ $currency->quantity }}
        @if ($currency->has_icon)
          {!! $currency->displayIcon !!}
        @endif
      </div>
    </div> --}}
    <!-- Left Side Of Navbar -->
    <ul id="site-navbar" class=" navbar-nav">
      <li class="nav-item dropdown">
        <div
          id="inventoryDropdown"
          class="nav-link dropdown-toggle"
          href="#"
          role="button"
          data-bs-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
          v-pre
        >
          Updates
        </div>
        <div class="dropdown-menu dt-nav-page" aria-labelledby="inventoryDropdown">
          <div class="dt-nav-group">
            <a class="dt-nav-item" href="{{ url('news') }}">
              <i class="fas fa-newspaper"></i> News </a>
            <a class="dt-nav-item" href="{{ url('sales') }}">
              <i class="fas fa-store"></i> Sales </a>
            <a class="dt-nav-item" href="{{ url('raffles') }}">
              <i class="fas fa-gift"></i> Raffles </a>
          </div>
          </a>
      </li>
      @if (Auth::check())
        <li class="nav-item dropdown">
          <div
            id="inventoryDropdown"
            class="nav-link dropdown-toggle"
            href="#"
            role="button"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
            v-pre
          >
            Account
          </div>
          <div class="dropdown-menu dt-nav-page" aria-labelledby="inventoryDropdown">
            <div class="dt-nav-group">
              <a class="dt-nav-item" href="{{ url('inventory') }}">
                <i class="fas fa-gifts"></i> Inventory </a>
              <a class="dt-nav-item" href="{{ url('pets') }}">
                <i class="fas fa-cat"></i> Pets </a>
              <a class="dt-nav-item" href="{{ url('bank') }}">
                <i class="fas fa-piggy-bank"></i> Bank </a>
              <a class="dt-nav-item" href="{{ url('badge%20collection') }}">
                <i class="fas fa-award"></i> My Badges </a>
              @if (Auth::user()->shops()->count() && Settings::get('user_shop_limit') == 1)
                <a class="dt-nav-item" href="{{ url(Auth::user()->shops()->first()->editUrl) }}">
                  <i class="fas fa-shop"></i> My Shop </a>
              @else
                <a class="dt-nav-item" href="{{ url('user-shops') }}">
                  <i class="fas fa-shop"></i> My Shops </a>
              @endif
              <a class="dt-nav-item" href="{{ url('trades/open') }}">
                <i class="fas fa-right-left"></i> Trades </a>
            </div>
            <div class="dt-nav-group">
              <h2 class="dt-nav-header">Characters</h2>
              <a class="dt-nav-item" href="{{ url('characters') }}">
                <i class="fas fa-heart"></i> My Characters </a>
              <a class="dt-nav-item" href="{{ url('characters/myos') }}">
                <i class="fas fa-clipboard-user"></i> My MYO Slots </a>
              <a class="dt-nav-item" href="{{ url('designs') }}">
                <i class="fas fa-person-circle-check"></i> Design Approvals </a>
              <a class="dt-nav-item" href="{{ url('characters/transfers/incoming') }}">
                <i class="fas fa-people-arrows"></i> Character Transfers </a>
            </div>
            </a>
        </li>
      @endif
      <li class="nav-item dropdown">
        <div
          id="queueDropdown"
          class="nav-link dropdown-toggle"
          href="#"
          role="button"
          data-bs-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
          v-pre
        >
          Info
        </div>
        <div class="dropdown-menu dt-nav-page" aria-labelledby="inventoryDropdown">
          <div class="dt-nav-group">
            <h2 class="dt-nav-header _first">Species</h2>
            <a class="dt-nav-item strike" href="{{ url('info/about') }}">
              <i class="fas fa-star"></i> Somnivores </a>
            <a class="dt-nav-item strike" href="{{ url('⁉️dreams') }}">
              <i class="fas fa-cloud"></i> Dreams & Palates </a>
            <a class="dt-nav-item" href="{{ url('world/species/1/traits') }}">
              <i class="fas fa-scroll"></i> Somnivore Traits </a>
          </div>
          <div class="dt-nav-group">
            <h2 class="dt-nav-header">World & Lore</h2>
            <a class="dt-nav-item strike" href="{{ url('lore') }}">
              <i class="fas fa-book"></i> Lore Index </a>
            <a class="dt-nav-item strike" href="{{ url('world/locations') }}">
              <i class="fas fa-map-location-dot"></i> Reverie Locations </a>
          </div>

          <div class="dt-nav-group">
            <h2 class="dt-nav-header">Databases</h2>
            {{-- <a class="dt-nav-item" href="{{ url('world/pets') }}">
              <i class="fas fa-cat"></i> Pets & Trinkets </a> --}}
            <a class="dt-nav-item" href="{{ url('world') }}">
              <i class="fas fa-search"></i> Encyclopedia </a>
          </div>
        </div>
      </li>
      <li class="nav-item dropdown">
        <div
          id="browseDropdown"
          class="nav-link dropdown-toggle"
          href="#"
          role="button"
          data-bs-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
          v-pre
        >
          Guides
        </div>
        <div class="dropdown-menu dt-nav-page" aria-labelledby="inventoryDropdown">
          <div class="dt-nav-group">
            <h2 class="dt-nav-header _first">Gameplay</h2>
            <a class="dt-nav-item strike" href="{{ url('/guide/beginner') }}">
              <i class="fas fa-book"></i> Beginners Guide </a>
            <a class="dt-nav-item" href="{{ url('info/myo-submission') }}">
              <i class="fas fa-envelope"></i> MYO Submission </a>
            <a class="dt-nav-item" href="{{ url('info/prompt-submission') }}">
              <i class="fas fa-palette"></i>Gallery & Prompt Submission </a>
            <a class="dt-nav-item" href="{{ url('info/art-rewards') }}">
              <i class="fas fa-coins"></i> Currency & Art Rewards </a>
          </div>
          <div class="dt-nav-group">
            <h2 class="dt-nav-header">How to Draw:</h2>
            <a class="dt-nav-item strike" href="{{ url('info/anatomy') }}">
              <i class="fas fa-star"></i> Somnivore Anatomy</a>
            <a class="dt-nav-item strike" href="{{ url('info/essence') }}">
              <i class="fas fa-cloud"></i> Dream Essence</a>
            <a class="dt-nav-item strike" href="{{ url('info/scenery') }}">
              <i class="fas fa-cloud-moon"></i> Reverie Scenery</a>
          </div>
          <div class="dt-nav-group">
            <h2 class="dt-nav-header">Character Design</h2>
            <a class="dt-nav-item strike" href="{{ url('info/design') }}">
              <i class="fas fa-brush"></i>Somnivore Design Guide</a>
          </div>
        </div>
      </li>
      <li class="nav-item dropdown">
        <div
          id="loreDropdown"
          class="nav-link dropdown-toggle"
          href="#"
          role="button"
          data-bs-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
          v-pre
        >
          Masterlist
        </div>
        <div class="dropdown-menu dt-nav-page" aria-labelledby="inventoryDropdown">
          <div class="dt-nav-group">
            <a class="dt-nav-item" href="{{ url('sublist/npc') }}">
              <i class="fas fa-star"></i> NPCs </a>
            <a class="dt-nav-item" href="{{ url('sublist/BAT') }}">
              <i class="fas fa-star"></i> Official Somnivores </a>
            <a class="dt-nav-item" href="{{ url('sublist/MYO') }}">
              <i class="fas fa-star"></i> MYO Somnivores </a>
          </div>
        </div>
      </li>
      <li class="nav-item dropdown">
        <div
          id="playDropdown"
          class="nav-link dropdown-toggle"
          href="#"
          role="button"
          data-bs-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
          v-pre
        >
          Play
        </div>
        <div class="dropdown-menu dt-nav-page" aria-labelledby="inventoryDropdown">
          <div class="dt-nav-group">
            <a class="dt-nav-item" href="{{ url('prompts/prompts') }}">
              <i class="fas fa-paintbrush"></i> Prompts </a>
            <a class="dt-nav-item" href="{{ url('gallery') }}">
              <i class="fas fa-camera-retro"></i> Art Gallery </a>
            <hr>
            <a class="dt-nav-item" href="{{ url('dailies') }}">
              <i class="fas fa-clipboard-list"></i> Dailies </a>
            <a class="dt-nav-item" href="{{ url('shops') }}">
              <i class="fas fa-gifts"></i> Shops </a>
            {{-- <hr>
            <a class="dt-nav-item bold" style="font-size: 1.3em; font-weight: 700" href="{{ url('crafting') }}">
              <i class="fas fa-warning"></i> FREE SHIT!!! </a> --}}
            <hr>
            <a class="dt-nav-item" href="{{ url('crafting') }}">
              <i class="fas fa-tools"></i> Crafting </a>
            {{-- <a class="dt-nav-item" href="{{ url('____') }}">
              <i class="far fa-seedling"></i> Foraging (coming soon)</a>
            <hr>
            <a class="dt-nav-item" href="{{ url('____') }}">
              <i class="far fa-calendar-days"></i> Current Event (coming soon)</a> --}}
          </div>
        </div>
      </li>
      <li class="nav-item dropdown">
        <div
          id="communityDropdown"
          class="nav-link dropdown-toggle"
          href="#"
          role="button"
          data-bs-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
          v-pre
        >
          Community
        </div>
        <div class="dropdown-menu dt-nav-page" aria-labelledby="inventoryDropdown">
          <div class="dt-nav-group">
            <a class="dt-nav-item strike" href="{{ url('____') }}">
              <i class="fas fa-comments strike" style="cursor: alias;"></i> Discord </a>
            <a class="dt-nav-item" href="{{ url('info/terms') }}">
              <i class="fas fa-circle-exclamation"></i>Rules & ToS</a>
            <hr>
            <a class="dt-nav-item" href="{{ url('users') }}">
              <i class="fas fa-user-group"></i>User List</a>
            <hr>
            <a class="dt-nav-item strike" href="{{ url('forms/') }}">
              <i class="fas fa-list-check strike"></i> Feedback </a>
            <a class="dt-nav-item strike" href="{{ url('forms/') }}">
              <i class="fas fa-bug"></i>Bug Reports</a>
          </div>
        </div>
      </li>
    </ul>
    <!-- Right Side Of Navbar -->
    <ul id="site-navbar-auth" class="navbar-nav ml-auto">
      <!-- Authentication Links -->
      @guest
        <li class="nav-item dropdown">
          <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
        </li>
        @if (Route::has('register'))
          <li class="nav-item dropdown">
            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
          </li>
        @endif
      @else
        @if (Auth::user()->isStaff)
          <li class="nav-item admin">
            <a class="nav-link" href="{{ url('admin') }}">
              <i class="fas fa-crown"></i></a>
          </li>
        @endif
        @if (Auth::user()->notifications_unread)
          <li class="nav-item nav-notifications">
            <a class="nav-link" href="{{ url('notifications') }}"><span class="fas fa-envelope"></span>
              {{ Auth::user()->notifications_unread }}</a>
          </li>
        @endif
        <li class="nav-item dropdown">
          <div
            id="browseDropdown"
            class="nav-link dropdown-toggle"
            href="#"
            role="button"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
            v-pre
          >
            Submit
          </div>
          <div class="dropdown-menu dropdown-menu-right dt-nav-page" aria-labelledby="browseDropdown">
            <div class="dt-nav-group" aria-labelledby="browseDropdown">
              <a class="dt-nav-item" href="{{ url('submissions/new') }}">
                <i class="fas fa-paintbrush"></i> Submit Prompt </a>
              <a class="dt-nav-item" href="{{ url('claims/new') }}">
                <i class="fas fa-envelope"></i> Submit Claim </a>
              <a class="dt-nav-item" href="{{ url('reports/new') }}">
                <i class="fas fa-exclamation-circle"></i> Submit Report </a>
            </div>
          </div>
        </li>
        <li class="nav-item dropdown">
          <div
            id="navbarDropdown"
            class="nav-link dropdown-toggle"
            href="{{ Auth::user()->url }}"
            role="button"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
            v-pre
          >
            {{ Auth::user()->name }} <span class="caret"></span>
          </div>
          <div class="dropdown-menu dropdown-menu-right dt-nav-page" aria-labelledby="navbarDropdown">
            <div class="dt-nav-group">
              <a class="dt-nav-item" href="{{ Auth::user()->url }}">
                <i class="fas fa-user"></i> Profile </a>
              <a class="dt-nav-item" href="{{ url('notifications') }}">
                <i class="fas fa-envelope"></i> Notifications </a>
              <a class="dt-nav-item" href="{{ url('account/bookmarks') }}">
                <i class="fas fa-bookmark"></i> Bookmarks </a>
              <a class="dt-nav-item" href="{{ url('account/settings') }}">
                <i class="fas fa-cog"></i> Settings </a>
              <a
                class="dt-nav-item"
                href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
              >
                <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }} </a>
              </a>
              <form
                id="logout-form"
                action="{{ route('logout') }}"
                method="POST"
                style="display: none;"
              >
                @csrf
              </form>
            </div>
          </div>
        </li>
      @endguest
    </ul>
    <div class="clocktainer">
      @if (Auth::user())
        <div class="cash">
          @foreach (Auth::user()->getCurrencies(true)->where('id', 1) as $currency)
            {!! $currency->display($currency->quantity) !!}
          @break
        @endforeach
      </div>
    @endif
    <div class="clock">
      <i class="fa fa-clock"></i>
      <div id="clock">
        {{-- TODO: live server time initial --}}
        --:--:-- --
      </div>
    </div>
  </div>
</div>
</nav>
<script>
  let timeZone = "EST"

  function getdate() {
    const date = new Date;
    const now = date.getTime()
    document.getElementById("clock").textContent = date.toLocaleTimeString("en-US", {
      timeZone: "America/New_York",
      // timeZoneName: "short",
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit'
    });
  }
  setInterval(getdate, 1000);
</script>
