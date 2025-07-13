<div id="home-dashboard">
  <h1 class="welcome-banner">Welcome, {!! Auth::user()->displayName !!}!</h1>
  {{-- <div class="card mb-4 timestamp">
    <div class="card-body"> <i class="far fa-clock"></i> {!! format_date(Carbon\Carbon::now()) !!} </div> </div> --}}
  <div class="bubblebox current-event">
    <h2 class="flex gap-1 ai-center"> <i class="fas fa-heart"></i>
      <span>Current Event</span>
    </h2>
    <div class="bubble ">
      <img
        src=""
        alt=""
        class="w-100"
      >
      <div class="grid ai-center">
        <h3> LAUNCH PARTY </h3>
        <h4 class="flex">
          <a href=""> event daily </a>
          <i class="fas fa-heart"></i>
          <a href=""> event shop </a>
        </h4>
      </div>
    </div>
  </div>
  <div class="bubblebox dailies">
    <h2 class="flex gap-1 ai-center"> <i class="fas fa-heart"></i>
      <span>Dailies</span>
    </h2>
    <div class="bubble jobs">
      <div class="wishing-well">
        <a href="/dailies/1">
          <img src="{{ asset('images/pages/daily-wishingwell.png') }}" alt="">
          <h3>Wishing Well</h3>
        </a>
      </div>
      <div class="starlit-acres">
        <a href="/dailies/2">
          <img src="{{ asset('images/pages/daily-starlitacres.png') }}" alt="">
          <h3>Starlit Acres</h3>
        </a>
      </div>
      <div class="foraging">
        <a href="/dailies/3">
          <img src="{{ asset('images/pages/nav-inventory.png') }}" alt="">
          <h3>Foraging (coming soon)</h3>
        </a>
      </div>
    </div>
  </div>
  <div class="bubblebox newsfeed">
    <h2 class="flex gap-1 ai-center"> <i class="fas fa-heart"></i>
      <span>Newsfeed</span>
    </h2>
    <div class="bubble">
      <div class="news-item">
        <h3>FAKE NEWS HEADLINE</h3>
        <p>this is the news this is the news this is the news this is the news this is the news...</p>
      </div>
      <div class="news-item">
        <h3>FAKE NEWS HEADLINE</h3>
        <p>this is the news this is the news this is the news this is the news this is the news...</p>
      </div>
    </div>
  </div>
  <div class="bubblebox sales">
    <h2 class="flex gap-1 ai-center"> <i class="fas fa-heart"></i>
      <span>Sales</span>
    </h2>
    {{-- INSERT LIVE SALE VALUES HERE --}}
    <div class="bubble sale-info grid-2-col">
      <div class="character-picture">
        <img src="{{ asset('/images/somnivores/jax2.png') }}" alt="">
      </div>
      <div class="character-info">
        <div class="sale-type h3"> sale_type </div>
        <div class="sale-price h3"> $ sale_price </div>
        <div class="sale-title"> <a href="">
            design_title
          </a>
        </div>
        <div class="sale-artist"> by
          <a href=""> artist_name </a>
        </div>
        <a class="sale-details" href="sale_link"> View More > </a>
      </div>
    </div>
  </div>
  {{-- SUBMISSION GALLERY --}}
  <div class="bubblebox recent-submissions">
    <h2 class="flex gap-1 ai-center"> <i class="fas fa-heart"></i>
      <span>Recent Gallery Submissions</span>
    </h2>
    <div class="bubble">
      <div class="gallery"></div>
    </div>
  </div>
  @include('widgets._recent_gallery_submissions', ['gallerySubmissions' => $gallerySubmissions])
</div>
