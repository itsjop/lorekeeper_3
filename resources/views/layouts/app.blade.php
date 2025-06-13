<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php
  header('Permissions-Policy: interest-cohort=()');
  ?>

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- ReCaptcha v3 -->
  {!! RecaptchaV3::initJs() !!}

  <title>{{ config('lorekeeper.settings.site_name', 'Lorekeeper') }} -@yield('title')</title>

  <!-- Primary Meta Tags -->
  <meta name="title" content="{{ config('lorekeeper.settings.site_name', 'Lorekeeper') }} -@yield('title')">
  <meta name="description" content="@if (View::hasSection('meta-desc')) @yield('meta-desc') @else {{ config('lorekeeper.settings.site_desc', 'A Lorekeeper ARPG') }} @endif">

  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ config('app.url', 'http://localhost') }}">
  <meta property="og:image" content="@if (View::hasSection('meta-img')) @yield('meta-img') @else {{ asset('images/lorekeeper/meta-image.png') }} @endif">
  <meta property="og:title" content="{{ config('lorekeeper.settings.site_name', 'Lorekeeper') }} -@yield('title')">
  <meta property="og:description" content="@if (View::hasSection('meta-desc')) @yield('meta-desc') @else {{ config('lorekeeper.settings.site_desc', 'A Lorekeeper ARPG') }} @endif">

  <!-- Twitter -->
  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:url" content="{{ config('app.url', 'http://localhost') }}">
  <meta property="twitter:image" content="@if (View::hasSection('meta-img')) @yield('meta-img') @else {{ asset('images/lorekeeper/meta-image.png') }} @endif">
  <meta property="twitter:title" content="{{ config('lorekeeper.settings.site_name', 'Lorekeeper') }} -@yield('title')">
  <meta property="twitter:description" content="@if (View::hasSection('meta-desc')) @yield('meta-desc') @else {{ config('lorekeeper.settings.site_desc', 'A Lorekeeper ARPG') }} @endif">

  <!-- No AI scraping directives -->
  <meta name="robots" content="noai">
  <meta name="robots" content="noimageai">

  <!------------------------------ LOREKEEPER RESOURCES ----------------------------->
  <!-- Scripts -->
  <script src="{{ mix('js/app.js') }}"></script>
  <script src="{{ mix('js/app-deferred.js') }}"></script>
  <!-- Styles -->
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">

  <!------------------------------ EXTERNAL RESOURCES ----------------------------->
  <!-- Scripts -->
  <script src="{{ asset('js/vendor/jquery-ui.min.js') }}"></script>
  <script src="{{ asset('js/vendor/jquery.tinymce.min.js') }}"></script>
  <script src="{{ asset('js/vendor/jquery.ui.touch-punch.min.js') }}"></script>
  <script src="{{ asset('js/vendor/tinymce.min.js') }}"></script>
  <script defer src="{{ asset('js/vendor/bootstrap4-toggle.min.js') }}"></script>
  <script defer src="{{ asset('js/vendor/lightbox.min.js') }}"></script>
  <script defer src="{{ asset('js/vendor/selectize.min.js') }}"></script>
  <script defer src="{{ asset('js/vendor/bs-custom-file-input.min.js') }}"></script>
  <script defer src="{{ asset('js/vendor/bootstrap-colorpicker.min.js') }}"></script>
  <script defer src="{{ asset('js/vendor/jquery-ui-timepicker-addon.js') }}"></script>
  <script defer src="{{ asset('js/site.js') }}"></script>
  <script defer src="{{ asset('js/vendor/croppie.min.js') }}"></script>

  <!-- Scripts for wheel of fortune dailies -->
  <script src="{{ asset('js/winwheel.min.js') }}"></script>
  <script src="{{ asset('js/tweenmax.min.js') }}"></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
  {{-- <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400..800&family=Chewy&display=swap" rel="stylesheet"> --}}
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400..800&family=Jua&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Potta+One&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&family=Stylish&display=swap" rel="stylesheet">
  <!-- Styles -->
  <link href="{{ asset('css/vendor/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/vendor/selectize.bootstrap4.css') }}" rel="stylesheet">
  <link href="{{ asset('css/vendor/lorekeeper.css?v=' . filemtime(public_path('css/vendor/lorekeeper.css'))) }}" rel="stylesheet">
  <link defer href="{{ faVersion() }}" rel="stylesheet">
  <link defer href="{{ asset('css/vendor/jquery-ui.min.css') }}" rel="stylesheet">
  <link defer href="{{ asset('css/vendor/bootstrap4-toggle.min.css') }}" rel="stylesheet">
  <link defer href="{{ asset('css/vendor/lightbox.min.css') }}" rel="stylesheet">
  <link defer href="{{ asset('css/vendor/bootstrap-colorpicker.min.css') }}" rel="stylesheet">
  <link defer href="{{ asset('css/vendor/jquery-ui-timepicker-addon.css') }}" rel="stylesheet">
  <link href="{{ asset('css/vendor/croppie.css') }}" rel="stylesheet">
  <link defer href="{{ asset('css/vendor/selectize.bootstrap4.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous"
    referrerpolicy="no-referrer" />

  <!----------- Laravel Includes ----------->
  @include('js._app_inline_js') {{-- JS typically at the bottom of the file moved here --}}
  @include('feed::links')
  @include('js._external_link_alert_js')
  @yield('head')
</head>

<body>
  <div id="app" {{ isset($componentName) ? 'data-component-path=' . $componentName : '' }} {{ isset($pageName) ? 'data-page=' . $pageName : '' }}>
    <div id="site-wrapper" class="{{ View::hasSection('sidebar') ? 'has-sidebar' : '' }}">
      <div class="site-background"></div>
      {{-- Header Logo --}}
      <a id="site-logo-header" href="{{ url('/') }}">
        <picture>
          <source srcset="{{ asset('images/somnivores/raw/logo_raw.webp') }}" media="(min-width: 1200px)" />
          <source srcset="{{ asset('images/somnivores/logo.webp') }}" media="(min-width: 768px)" />
          <img src="{{ asset('images/somnivores/logo.webp') }}" alt="" />
        </picture>
      </a>

      {{-- Navbar --}}
      @include('layouts._nav')

      {{-- Sidebar Container --}}
      <div id="sidebar-container">
        {{-- Mobile Sidebar (conditional) --}}
        @if (View::hasSection('sidebar'))
          <div id="site-mobile-header">
            <button class="btn btn-sm btn-outline-dark" id="mobileMenuButton">
              Menu
              <i class="fas fa-caret-right ml-1"> </i>
            </button>
          </div>
        @endif
        {{-- Actual Sidebar --}}
        <div id="sidebar" class="sidebar">
          @yield('sidebar')
        </div>
      </div>

      <div id="main-content" class="main-content p-4">

        @if (Settings::get('is_maintenance_mode'))
          <div class="alert alert-secondary">
            The site is currently in maintenance mode!
            @if (!Auth::check() || !Auth::user()->hasPower('maintenance_access'))
              You can browse public content, but cannot make any submissions.
            @endif
          </div>
        @endif
        @if (Auth::check() && !config('lorekeeper.extensions.navbar_news_notif'))
          @if (Auth::user()->is_news_unread)
            <div class="alert alert-info">
              <a href="{{ url('news') }}">There is a new news post!</a>
            </div>
          @endif
          @if (Auth::user()->is_sales_unread)
            <div class="alert alert-info">
              <a href="{{ url('sales') }}">There is a new sales post!</a>
            </div>
          @endif
        @endif
        @if (Auth::check() && Auth::user()->is_polls_unread)
          <div class="alert alert-info">
            <a href="{{ url('forms') }}">There is a new site poll!</a>
          </div>
        @endif
        @include('flash::message')
        @yield('content')

        @include('layouts._footer')

      </div>

      </main>

      <dialog class="modal fade" id="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <span class="modal-title h5 mb-0"></span>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            </div>
          </div>
        </div>
      </dialog>
      @yield('scripts')
      @include('layouts._pagination_js')
    </div>
</body>

</html>
