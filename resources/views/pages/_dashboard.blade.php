<div class="home-dashboard">
  <h1 class="welcome-banner">Welcome back to Reverie, {!! Auth::user()->displayName !!}! ✨</h1>
  {{-- <div class="card mb-4 timestamp">
    <div class="card-body"> <i class="far fa-clock"></i> {!! format_date(Carbon\Carbon::now()) !!} </div> </div> --}}
  <div class="bubblebox current-event">
    <h2 class="flex gap-_5 ai-center">
      <i class="fas fa-heart"></i>
      Current Event
    </h2>
    <div class="bubble event">
      <img
        src="images/lore_pages/homepage/characters.png"
        alt=""
        class="w-66"
      >
      <div class="grid ai-center event-buttons">
        <p class="event-title m-0"> Coming Soon! </p>
        <a class="frontpage-button" href=""> daily </a>
        <a class="frontpage-button" href=""> shop </a>
      </div>
    </div>
  </div>

  <div class="bubblebox dailies">
    <h2 class="flex gap-_5 ai-center">
      <i class="fas fa-gifts"></i>
      Dailies
    </h2>
    <div class="bubble jobs gap-_5">
      <a class="wishing-well" href="/dailies/1">
        <img src="{{ asset('images/pages/daily-wishingwell.png') }}" alt="Go to the Wishing Well" />
        <p class="frontpage-button m-0"> Wishing Well</p>
      </a>
      <a class="starlit-acres" href="/dailies/2">
        <img src="{{ asset('images/pages/daily-starlitacres.png') }}" alt="Go to Starlit Acres daily" />
        <p class="frontpage-button m-0"> Starlit Acres</p>
      </a>
      <a class="foraging" href="/dailies/3">
        <img src="{{ asset('images/pages/nav-inventory.png') }}" alt="Go to the Foraging zone" />
        <p class="frontpage-button m-0 bw-disabled"> Foraging
        </p>
      </a>
    </div>
  </div>
  <div class="bubblebox newsfeed">
    <h2 class="flex gap-_5 ai-center">
      <i class="fas fa-newspaper"></i>
      Newsfeed

    </h2>
    <div class="bubble px-4">
      @include('widgets._news', ['textPreview' => true])
    </div>
  </div>
  <div class="bubblebox sales">
    <h2 class="flex gap-_5 ai-center">
      <i class="fas fa-store"></i> Sales
    </h2>
    <div class="bubble sale-info">
      @include('widgets._sales')
    </div>
  </div>
  {{-- SUBMISSION GALLERY --}}
  <div class="bubblebox recent-submissions">
    <h2 class="flex gap-_5 ai-center">
      <a href="gallery/all" class="color-unset ai-center">
        <i class="fas fa-palette"></i>
        Recent Gallery Submissions
        <i class="fa-solid fa-caret-right"></i>
      </a>
    </h2>
    <div class="bubble p-0">
      @include('widgets._recent_gallery_submissions', ['gallerySubmissions' => $gallerySubmissions])
    </div>
  </div>
</div>
