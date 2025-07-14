<div id="home-dashboard">
  <h1 class="welcome-banner">Welcome back to Reverie, {!! Auth::user()->displayName !!}! ✨</h1>
  {{-- <div class="card mb-4 timestamp">
    <div class="card-body"> <i class="far fa-clock"></i> {!! format_date(Carbon\Carbon::now()) !!} </div> </div> --}}
  <div class="bubblebox current-event">
    <h2 class="flex gap-_5 ai-center"> <i class="fas fa-heart"></i>
      <span>Current Event</span>
    </h2>
    <div class="bubble ">
      <img
        src="images/lore_pages/homepage/characters.png"
        alt=""
        class="w-66"
      >
      <div class="grid ai-center">
        <h3> (Coming Soon!) </h3>
        <h4 class="flex jc-center">
          <a href="">daily</a>
          <i class="fas fa-star px-2"></i>
          <a href="">shop</a>
        </h4>
      </div>
    </div>
  </div>
  <div class="bubblebox dailies">
    <h2 class="flex gap-_5 ai-center"> <i class="fas fa-gifts"></i>
      <span>Dailies</span>
    </h2>
    <div class="bubble jobs">
      <div class="wishing-well">
        <a href="/dailies/1">
          <img src="{{ asset('images/pages/daily-wishingwell.png') }}" alt="Go to the Wishing Well">
          <h3>Wishing Well</h3>
        </a>
      </div>
      <div class="starlit-acres">
        <a href="/dailies/2">
          <img src="{{ asset('images/pages/daily-starlitacres.png') }}" alt="Go to Starlit Acres daily">
          <h3>Starlit Acres</h3>
        </a>
      </div>
      <div class="foraging">
        <a href="/dailies/3">
          <img src="{{ asset('images/pages/nav-inventory.png') }}" alt="Go to the Foraging zone">
          <h3>Foraging (coming soon)</h3>
        </a>
      </div>
    </div>
  </div>
  <div class="bubblebox newsfeed">
    <h2 class="flex gap-_5 ai-center"> <i class="fas fa-newspaper"></i>
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
    <h2 class="flex gap-_5 ai-center"> <i class="fas fa-store"></i>
      <span>Sales</span>
    </h2>
    {{-- INSERT LIVE SALE VALUES HERE --}}
    <div class="bubble sale-info grid-2-col">
      <div class="character-picture">
        <img src="{{ asset('/images/somnivores/jax2.png') }}" alt="">
      </div>
      <div class="character-info">
        <div class="sale-type h4"> Flat Sale Raffle </div>
        <div class="sale-price h3"> $80 </div>
        <div class="sale-title"> <a href="">
            The Real Jax
          </a>
        </div>
        <div class="sale-artist"> by
          <a href=""> notwyspic </a>
        </div>
        <a class="sale-details" href="sale_link"> View More > </a>
      </div>
    </div>
  </div>
  {{-- SUBMISSION GALLERY --}}
  <div class="bubblebox recent-submissions">
    <h2 class="flex gap-_5 ai-center"> <i class="fas fa-palette"></i>
      <span>Recent Gallery Submissions</span>
    </h2>
    <div class="bubble p-0">
      <div class="gallery"></div>
    </div>
  </div>
  @include('widgets._recent_gallery_submissions', ['gallerySubmissions' => $gallerySubmissions])
</div>
