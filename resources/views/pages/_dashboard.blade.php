<div class="home-dashboard">
  <div class="welcome-banner">
    <h1 class="welcome-banner">
      Welcome back to Reverie, {!! Auth::user()->displayName !!}! ✨
    </h1>
    {{-- <div class="colors flex jc-center ai-center ac-center ji-center" style="--clr_mode: oklab; border: 2px black solid; padding: 0px; width: max-content; grid-auto-flow: column;">
      <div class="label ta-center ac-center" style="width: 70px; height: 50px;">OKLAB</div>
      <div class="c25 ta-center ac-center" style="background-color: var(--clr_raw_purple-25-new); width: 50px; height: 50px;">25</div>
      <div class="c50 ta-center ac-center" style="background-color: var(--clr_raw_purple-50-new); width: 50px; height: 50px;">50</div>
      <div class="c100 ta-center ac-center" style="background-color: var(--clr_raw_purple-100-new); width: 50px; height: 50px;">100</div>
      <div class="c200 ta-center ac-center" style="background-color: var(--clr_raw_purple-200-new); width: 50px; height: 50px;">200</div>
      <div class="c300 ta-center ac-center" style="background-color: var(--clr_raw_purple-300-new); width: 50px; height: 50px;">300</div>
      <div class="c400 ta-center ac-center" style="background-color: var(--clr_raw_purple-400-new); width: 50px; height: 50px;">400</div>
      <div class="c500 ta-center ac-center" style="background-color: var(--clr_raw_purple-500-new); width: 50px; height: 50px;">500</div>
      <div class="c600 ta-center ac-center" style="background-color: var(--clr_raw_purple-600-new); width: 50px; height: 50px;">600</div>
      <div class="c700 ta-center ac-center" style="background-color: var(--clr_raw_purple-700-new); width: 50px; height: 50px;">700</div>
      <div class="c800 ta-center ac-center" style="background-color: var(--clr_raw_purple-800-new); width: 50px; height: 50px;">800</div>
      <div class="c900 ta-center ac-center" style="background-color: var(--clr_raw_purple-900-new); width: 50px; height: 50px;">900</div>
      <div class="c950 ta-center ac-center" style="background-color: var(--clr_raw_purple-950-new); width: 50px; height: 50px;">950</div>
    </div> --}}
  </div>
  {{-- <div class="card mb-4 timestamp">
    <div class="card-body"> <i class="far fa-clock"></i> {!! format_date(Carbon\Carbon::now()) !!} </div> </div> --}}
  <div class="bubblebox current-event">
    <h2 class="h2 flex gap-_5 ai-center">
      <i class="fas fa-heart"></i>
      Current Event
    </h2>
    <div class="bubble event">
      <img
        src="images/somnivores/event/launchicon.png"
        alt=""
        class="w-66"
      >
      <div class="grid ai-center event-buttons">
        <p class="event-title m-0"> Somnivores Launch Party! </p>
        <a class="frontpage-button" href="/dailies/4"> daily </a>
        <a class="frontpage-button" href="/shops/8"> shop </a>
      </div>
    </div>
  </div>

  <div class="bubblebox dailies">
    <a href="/dailies" class="h2 flex gap-_5 ai-center">
      <i class="fas fa-gifts"></i>
      Dailies
    </a>
    <div class="bubble jobs gap-_5">
      <a class="wishing-well" href="/dailies/1">
        <img src="{{ asset('images/pages/daily-wishingwell.png') }}" alt="Go to the Wishing Well" />
        <p class="frontpage-button m-0"> Wishing Well </p>
      </a>
      <a class="starlit-acres" href="/dailies/2">
        <img src="{{ asset('images/pages/daily-starlitacres.png') }}" alt="Go to Starlit Acres daily" />
        <p class="frontpage-button m-0"> Starlit Acres </p>
      </a>
      <a class="foraging">
        {{-- <a class="foraging" href="/dailies/3"> --}}
        <img src="{{ asset('images/pages/nav-inventory.png') }}" alt="Go to the Foraging zone" />
        <p class="frontpage-button m-0 bw-disabled"> Foraging
        </p>
      </a>
    </div>
  </div>
  {{-- NEWSFEED --}}
  <div class="bubblebox newsfeed">
    <a href="/news" class="h2 flex gap-_5 ai-center ac-center">
      <i class="fas fa-newspaper"></i>
      Newsfeed
      {{-- <i class="fas fa-caret-right"></i> --}}
    </a>
    <div class="bubble px-4">
      @if (Auth::user()->is_news_unread)
        <div class="newbadge frontpage-button" style="animation-delay: {{ rand(0, 1000) }}ms;"> New!</div>
      @endif
      @include('widgets._news', ['textPreview' => true])
    </div>
  </div>
  {{-- SALES --}}
  <div class="bubblebox sales">
    <a href="/sales" class="h2 flex gap-_5 ai-center ac-center">
      <i class="fas fa-store"></i>
      Sales
      {{-- <i class="fas fa-caret-right"></i> --}}
    </a>
    <div class="bubble sale-info">
      @if (Auth::user()->is_sales_unread)
        <div class="newbadge frontpage-button" style="animation-delay: {{ rand(0, 1000) }}ms;"> New!</div>
      @endif
      @include('widgets._sales')
    </div>
  </div>
  {{-- RECENT MYOS --}}
  <div class="bubblebox recent-myos">
    <a href="sublist/MYO" class="h2 flex gap-_5 ai-center ac-center">
      <i class="fas fa-star"></i>
      Recent MYO Submissions
      {{-- <i class="fa-solid fa-caret-right"></i> --}}
    </a>
    <div class="bubble p-0">
      @include('widgets._recent_MYO_submissions', ['myos' => $myos])
    </div>
  </div>
  {{-- SUBMISSION GALLERY --}}
  <div class="bubblebox recent-submissions">
    <a href="gallery/all" class="h2 flex gap-_5 ai-center ac-center">
      <i class="fas fa-palette"></i>
      Recent Gallery Submissions
      {{-- <i class="fa-solid fa-caret-right"></i> --}}
    </a>
    <div class="bubble p-0">
      @include('widgets._recent_gallery_submissions', ['gallerySubmissions' => $gallerySubmissions])
    </div>
  </div>
</div>
