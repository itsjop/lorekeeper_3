<nav class="navbar navbar-expand-md" id="header-nav">
  @if (Auth::check() && (Auth::user()->is_news_unread || Auth::user()->is_sales_unread))
    <div class="news-sales-container">
      @if (Auth::user()->is_news_unread)
        <a href="{{ url('news') }}" class="newbadge">
          <i class="fa-solid fa-newspaper"></i> new news!
        </a>
      @endif
      @if (Auth::user()->is_sales_unread)
        <a href="{{ url('sales') }}" class="newbadge">
          <i class="fa-solid fa-coins"></i> new sales!
        </a>
      @endif
      @if (Auth::user()->is_polls_unread)
        <a href="{{ url('sales') }}" class="newbadge">
          <i class="fa-solid fa-square-poll-horizontal"></i> new poll!
        </a>
      @endif
    </div>
  @endif
  <div class="mobile-topnav w-100 jc-between ai-center">
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
        <span class="line">
        </span>
        <span class="line">
        </span>
        <span class="line">
        </span>
      </span>
    </button>
    <button id="mobile-sidebar-toggle" class="mobile-menu-button">menu </button>
  </div>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
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

      <li class="nav-item dropdown">
        <div
          id="somnivoresDropdown"
          class="nav-link dropdown-toggle"
          href="#"
          role="button"
          data-bs-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
          v-pre
        >
          Somnivores
        </div>
        <div class="dropdown-menu dt-nav-page grid-2-col" aria-labelledby="somnivoresDropdown">
          <div class="dt-nav-group">
            <h2 class="dt-nav-header"> Species </h2>
            <a class="dt-nav-item" href="{{ url('info/somnivores') }}">
              <i class="fas fa-star"></i> Overview </a>
            <a class="dt-nav-item m-small" href="{{ url('info/palate') }}">
              <i class="fas fa-moon"></i> Dreams & Palates </a>
            <a class="dt-nav-item" href="{{ url('world/species/1/traits') }}">
              <i class="fas fa-scroll"></i> Trait Index </a>

            <h2 class="dt-nav-header"> World </h2>
            <a class="dt-nav-item m-small" href="{{ url('world/locations') }}">
              <i class="fas fa-map "></i> Reverie Locations </a>
            <a class="dt-nav-item" href="{{ url('info/lore-index') }}">
              <i class="fas fa-book"></i> Lore Library </a>
          </div>
          <div class="dt-nav-group">
            <h2 class="dt-nav-header br-tr-15"> How to Draw </h2>
            <a class="dt-nav-item m-small" href="{{ url('info/somnivore-anatomy') }}">
              <i class="fas fa-paw"></i> Somnivore Anatomy </a>
            <a class="dt-nav-item" href="{{ url('info/dream-essence') }}">
              <i class="fas fa-cloud"></i> Dream Essence </a>
            <a class="dt-nav-item" href="{{ url('info/reverie-scenery') }}">
              <i class="fas fa-seedling"></i> Reverie Scenery </a>

            <h2 class="dt-nav-header"> Design Guides </h2>
            <a class="dt-nav-item m-small" href="{{ url('info/bat-form') }}">
              <i class="fas fa-brush"></i> Design Guide : Bats </a>
            <a class="dt-nav-item m-small" href="{{ url('info/demon-form') }}">
              <i class="fas fa-brush"></i> Design Guide : Demons </a>
          </div>
          </a>
      </li>
      <li class="nav-item dropdown">
        <div
          id="infoDropdown"
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
        <div class="dropdown-menu dt-nav-page" aria-labelledby="infoDropdown">
          <div class="dt-nav-group">
            <h2 class="dt-nav-header _first"> Site Guides </h2>
            <a class="dt-nav-item" href="{{ url('/info/beginner-guide') }}">
              <i class="fas fa-seedling"></i> Beginner’s Guide </a>
            <hr>
            <a class="dt-nav-item" href="{{ url('/info/image-guidelines') }}">
              <i class="fas fa-images"></i> Masterlist Images </a>
            <a class="dt-nav-item" href="{{ url('/info/myo-submission') }}">
              <i class="fas fa-envelope"></i> MYO Submission </a>
            <a class="dt-nav-item" href="{{ url('/info/design-updates') }}">
              <i class="fas fa-paint-roller"></i> Design Updates </a>
            <hr>
            <a class="dt-nav-item" href="{{ url('/info/prompt-submission') }}">
              <i class="fas fa-paper-plane"></i> Gallery & Prompt Submission </a>
            <a class="dt-nav-item" href="{{ url('/info/submission-rewards') }}">
              <i class="fas fa-coins"></i> Art / Submission Rewards </a>
            <h2 class="dt-nav-header"> Database </h2>
            <a class="dt-nav-item" href="{{ url('/world') }}">
              <i class="fas fa-search"></i> Encyclopedia </a>
          </div>
        </div>
      </li>
      <li class="nav-item dropdown">
        <div
          id="masterlistDropdown"
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
        <div class="dropdown-menu dt-nav-page" aria-labelledby="masterlistDropdown">
          <div class="dt-nav-group">
            <a class="dt-nav-item" href="{{ url('sublist/MYO') }}">
              <i class="fas fa-star"></i> MYO Somnivores </a>
            <a class="dt-nav-item" href="{{ url('sublist/BAT') }}">
              <i class="fas fa-star"></i> Official Somnivores </a>
            <a class="dt-nav-item" href="{{ url('sublist/npc') }}">
              <i class="fas fa-star"></i> NPCs </a>
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
        <div class="dropdown-menu dt-nav-page" aria-labelledby="playDropdown">
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
        <div class="dropdown-menu dt-nav-page" aria-labelledby="communityDropdown">
          <div class="dt-nav-group">
            <a class="dt-nav-item" href="{{ url('https://discord.gg/VPVv7MKZZA') }}">
              <i class="fas fa-comments" style="cursor: alias;"></i> Discord </a>
            <a class="dt-nav-item" href="{{ url('info/terms') }}">
              <i class="fas fa-circle-exclamation"></i> Rules & ToS</a>
            <hr>
            <a class="dt-nav-item" href="{{ url('users') }}">
              <i class="fas fa-user-group"></i> User List </a>
            {{-- <a class="dt-nav-item" href="{{ url('forms/') }}">
              <i class="fas fa-list-check"></i> Feedback </a>
            <a class="dt-nav-item" href="{{ url('forms/') }}">
              <i class="fas fa-bug"></i> Bug Reports </a> --}}
          </div>
        </div>
      </li>
    </ul>
    <!-- Right Side Of Navbar -->
    <ul id="site-navbar-auth" class="navbar-nav ml-auto">
      <!-- Authentication Links -->
      @guest
        <li class="nav-item dropdown">
          <a class="nav-link" href="{{ route('login') }}"> {{ __('Login') }} </a>
        </li>
        @if (Route::has('register'))
          <li class="nav-item dropdown">
            <a class="nav-link" href="{{ route('register') }}"> {{ __('Register') }} </a>
          </li>
        @endif
      @else
        @if (Auth::user()->isStaff)
          <li class="nav-item admin">
            <a class="nav-link" href="{{ url('admin') }}">
              <i class="fas fa-crown"></i>
            </a>
          </li>
        @endif
        @if (Auth::user()->notifications_unread)
          <li class="nav-item nav-notifications">
            <a class="nav-link" href="{{ url('notifications') }}">
              <i class="fas fa-envelope"></i>
              {{ Auth::user()->notifications_unread }} </a>
          </li>
        @endif
        <li class="nav-item dropdown">
          <div
            id="submitDropdown"
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
          <div class="dropdown-menu dropdown-menu-right dt-nav-page" aria-labelledby="submitDropdown">
            <div class="dt-nav-group" aria-labelledby="submitDropdown">
              <a class="dt-nav-item" href="{{ url('submissions/new') }}">
                <i class="fas fa-paintbrush"></i> Submit Prompt </a>
              <a class="dt-nav-item" href="{{ url('/submissions') }}">
                <i class="fas fa-file"></i> My Submissions </a>
              <hr>
              <a class="dt-nav-item" href="{{ url('claims/new') }}">
                <i class="fas fa-envelope"></i> Submit Claim </a>
              <a class="dt-nav-item" href="{{ url('reports/new') }}">
                <i class="fas fa-exclamation-circle"></i> Submit Report </a>
            </div>
          </div>
        </li>
        <li class="nav-item dropdown">
          <div
            id="accountDropdown"
            class="nav-link dropdown-toggle"
            href="{{ Auth::user()->url }}"
            role="button"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
            v-pre
          >
            {{ Auth::user()->name }} <span class="caret">
            </span>
          </div>
          <div class="dropdown-menu dropdown-menu-right dt-nav-page grid-3-col" aria-labelledby="accountDropdown">
            <div class="dt-nav-group character">
              <h2 class="dt-nav-header br-tl-15"> My Characters </h2>
              <a class="dt-nav-item" href="{{ url('characters') }}">
                <i class="fas fa-heart"></i> Character List </a>
              <a class="dt-nav-item" href="{{ url('characters/myos') }}">
                <i class="fas fa-id-badge"></i> MYO Slots </a>
              <a class="dt-nav-item" href="{{ url('designs') }}">
                <i class="fas fa-user-check"></i> Design Approvals </a>
              <a class="dt-nav-item" href="{{ url('characters/transfers/incoming') }}">
                <i class="fas fa-people-arrows"></i> Character Transfers </a>
            </div>
            <div class="dt-nav-group stuff">
              <h2 class="dt-nav-header"> My Stuff </h2>
              <a class="dt-nav-item" href="{{ url('inventory') }}">
                <i class="fas fa-gifts"></i> Inventory </a>
              <a class="dt-nav-item" href="{{ url('bank') }}">
                <i class="fas fa-piggy-bank"></i> Bank </a>
              <a class="dt-nav-item" href="{{ url('pets') }}">
                <i class="fas fa-cat"></i> Pets </a>
              <a class="dt-nav-item" href="{{ url('badge-collection') }}">
                <i class="fas fa-award"></i> Badges </a>
              <a class="dt-nav-item" href="{{ url('trades/open') }}">
                <i class="fas fa-right-left"></i> Trades </a>
              @if (Auth::user()->shops()->count() && Settings::get('user_shop_limit') == 1)
                <a class="dt-nav-item" href="{{ url(Auth::user()->shops()->first()->editUrl) }}">
                  <i class="fas fa-shop"></i> My Shop </a>
              @else
                <a class="dt-nav-item" href="{{ url('user-shops') }}">
                  <i class="fas fa-shop"></i> My Shops </a>
              @endif
            </div>
            <div class="dt-nav-group account ">
              <h2 class="dt-nav-header "> My Account </h2>
              <a class="dt-nav-item" href="{{ Auth::user()->url }}">
                <i class="fas fa-user"></i> Profile </a>
              <a class="dt-nav-item" href="{{ url('notifications') }}">
                <i class="fas fa-bell"></i> Notifications </a>
              <a class="dt-nav-item" href="{{ url('mail') }}">
                <i class="fas fa-envelope"></i> Mail </a>
              <a class="dt-nav-item" href="{{ url('account/bookmarks') }}">
                <i class="fas fa-bookmark"></i> Bookmarks </a>
              <a class="dt-nav-item" href="{{ url('account/settings') }}">
                <i class="fas fa-cog"></i> Account Settings </a>
              <a
                class="dt-nav-item text-danger"
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
      <a class="cash color-white" href="/bank">
        @if (Auth::user())
          @foreach (Auth::user()->getCurrencies(true)->where('id', 1) as $currency)
            {!! $currency->display($currency->quantity) !!}
          @break
        @endforeach
      @else
        - - - -
      @endif
    </a>
    <?php
    // set default timezone
    date_default_timezone_set('America/New_York'); // EDT
    $current_date = date('h:i:s A');
    ?>
    <div class="clock">
      <i class="fa fa-clock"></i>
      <div id="clock">
        {{ $current_date }}
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
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit'
    });
  }
  setInterval(getdate, 1000);
</script>
