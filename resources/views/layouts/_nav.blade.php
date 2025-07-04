<nav class="navbar navbar-expand-md" id="header-nav">
  <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
    <span class="navbar-toggler-icon">
      <span class="line"></span>
      <span class="line"></span>
      <span class="line"></span>
    </span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <!-- Left Side Of Navbar -->
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a id="inventoryDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
          Site
        </a>
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
          <a id="inventoryDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Account
          </a>
          <div class="dropdown-menu dt-nav-page" aria-labelledby="inventoryDropdown">
            <div class="dt-nav-group">
              <a class="dt-nav-item" href="{{ url('inventory') }}">
                <i class="fas fa-gifts"></i> Inventory </a>
              <a class="dt-nav-item" href="{{ url('pets') }}">
                <i class="fas fa-cat"></i> Pets </a>
              <a class="dt-nav-item" href="{{ url('bank') }}">
                <i class="fas fa-piggy-bank"></i> Bank </a>
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
        <a id="queueDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
          Info
        </a>
        <div class="dropdown-menu dt-nav-page" aria-labelledby="inventoryDropdown">
          <div class="dt-nav-group">
            <h2 class="dt-nav-header _first">Species</h2>
            <a class="dt-nav-item" href="{{ url('info/about') }}">
              <i class="fas fa-star"></i> Somnivores </a>
            <a class="dt-nav-item" href="{{ url('⁉️dreams') }}">
              <i class="fas fa-cloud"></i> Dreams & Palates </a>
          </div>
          <div class="dt-nav-group">
            <h2 class="dt-nav-header">World & Lore</h2>
            <a class="dt-nav-item" href="{{ url('lore') }}">
              <i class="fas fa-book"></i> Somnivore Lore Index </a>
            <a class="dt-nav-item" href="{{ url('world/locations') }}">
              <i class="fas fa-map-location-dot"></i> Reverie Locations </a>
            <a class="dt-nav-item" href="{{ url('world/pets') }}">
              <i class="fas fa-cat"></i> Companions & Trinkets </a>
            <a class="dt-nav-item" href="{{ url('world') }}">
              <i class="fas fa-circle-info"></i> Encyclopedia </a>
          </div>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a id="browseDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
          Guides
        </a>
        <div class="dropdown-menu dt-nav-page" aria-labelledby="inventoryDropdown">
          <div class="dt-nav-group">
            <h2 class="dt-nav-header _first">Gameplay</h2>
            <a class="dt-nav-item" href="{{ url('/guide/beginner') }}">
              <i class="fas fa-book"></i> Beginners Guide </a>
            <a class="dt-nav-item" href="{{ url('guide/myo') }}">
              <i class="fas fa-envelope"></i> MYO Submission </a>
            <a class="dt-nav-item" href="{{ url('guide/prompts') }}">
              <i class="fas fa-palette"></i> Prompt Submission </a>
            <a class="dt-nav-item" href="{{ url('guide/currency') }}">
              <i class="fas fa-coins"></i> Currency Guide </a>
          </div>
          <div class="dt-nav-group">
            <h2 class="dt-nav-header">How to Draw:</h2>
            <a class="dt-nav-item" href="{{ url('guide/anatomy') }}">
              <i class="fas fa-star"></i> Somnivores </a>
            <a class="dt-nav-item" href="{{ url('guide/essence') }}">
              <i class="fas fa-cloud"></i> Dream Essence </a>
            <a class="dt-nav-item" href="{{ url('guide/scenery') }}">
              <i class="fas fa-cloud-moon"></i> Reverie Scenery </a>
          </div>
          <div class="dt-nav-group">
            <h2 class="dt-nav-header">Character Design</h2>
            <a class="dt-nav-item" href="{{ url('guide/design') }}">
              <i class="fas fa-brush"></i> Somnivore Design Guide </a>
            <a class="dt-nav-item" href="{{ url('world/traits') }}">
              <i class="fas fa-scroll"></i> Somnivore Traits </a>
          </div>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a id="loreDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
          Masterlist
        </a>
        <div class="dropdown-menu dt-nav-page" aria-labelledby="inventoryDropdown">
          <div class="dt-nav-group">
            <a class="dt-nav-item" href="{{ url('sublist/npc') }}">
              <i class="fas fa-star"></i> NPCs </a>
            {{-- <a class="dt-nav-item" href="{{ url('masterlist') }}">
              <i class="fas fa-star"></i> Official Somnivores </a>
            <a class="dt-nav-item" href="{{ url('sublist/MYO') }}">
              <i class="fas fa-star"></i> MYO Somnivores </a>
            <hr>
            <a class="dt-nav-item" href="{{ url('characters/myos') }}">
              <i class="far fa-star"></i> MYO Slots </a> --}}
          </div>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a id="playDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
          Play
        </a>
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
              <i class="far fa-gifts"></i> Shops </a>
            {{-- <a class="dt-nav-item" href="{{ url('____') }}">
              <i class="far fa-seedling"></i> Foraging (coming soon)</a>
            <hr>
            <a class="dt-nav-item" href="{{ url('____') }}">
              <i class="far fa-calendar-days"></i> Current Event (coming soon)</a> --}}
          </div>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a id="communityDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
          Community
        </a>
        <div class="dropdown-menu dt-nav-page" aria-labelledby="inventoryDropdown">
          <div class="dt-nav-group">
            <a class="dt-nav-item" href="{{ url('____') }}">
              <i class="fas fa-comments" style="cursor: alias;"></i>Discord</a>
            <a class="dt-nav-item" href="{{ url('info/terms') }}">
              <i class="fas fa-circle-exclamation"></i>Rules & ToS</a>
            <hr>
            <a class="dt-nav-item" href="{{ url('staff') }}">
              <i class="fas fa-clipboard-user"></i>Staff</a>
            <a class="dt-nav-item" href="{{ url('users') }}">
              <i class="fas fa-user-group"></i>User List</a>
            <hr>
            <a class="dt-nav-item" href="{{ url('forms/') }}">
              <i class="fas fa-list-check"></i>Feedback</a>
            <a class="dt-nav-item" href="{{ url('forms/') }}">
              <i class="fas fa-bug"></i>Bug Reports</a>
          </div>
        </div>
      </li>
    </ul>
    <!-- Right Side Of Navbar -->
    <ul class="navbar-nav ml-auto">
      <!-- Authentication Links -->
      @guest
        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
        </li>
        @if (Route::has('register'))
          <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
          </li>
        @endif
      @else
        @if (Auth::user()->isStaff)
          <li class="nav-item">
            <a class="nav-link" href="{{ url('admin') }}">
              <i class="fas fa-crown"></i></a>
          </li>
        @endif
        @if (Auth::user()->notifications_unread)
          <li class="nav-item nav-notifications">
            <a class="nav-link btn btn-secondary btn-sm" href="{{ url('notifications') }}"><span class="fas fa-envelope"></span>
              {{ Auth::user()->notifications_unread }}</a>
          </li>
        @endif
        <li class="nav-item dropdown">
          <a id="browseDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Submit
          </a>
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
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="{{ Auth::user()->url }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            {{ Auth::user()->name }} <span class="caret"></span>
          </a>
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
              <a class="dt-nav-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }} </a>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </div>
          </div>
        </li>
      @endguest
    </ul>
  </div>
</nav>
