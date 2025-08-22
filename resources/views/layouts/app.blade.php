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
  <meta name="description"
    content="@if (View::hasSection('meta-desc')) @yield('meta-desc') @else {{ config('lorekeeper.settings.site_desc', 'A Lorekeeper ARPG') }} @endif"
  >

  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ config('app.url', 'http://localhost') }}">
  <meta property="og:image"
    content="@if (View::hasSection('meta-img')) @yield('meta-img') @else {{ asset('images/somnivores/site/meta-image.png') }} @endif"
  >
  <meta property="og:title" content="{{ config('lorekeeper.settings.site_name', 'Lorekeeper') }} -@yield('title')">
  <meta property="og:description"
    content="@if (View::hasSection('meta-desc')) @yield('meta-desc') @else {{ config('lorekeeper.settings.site_desc', 'A Lorekeeper ARPG') }} @endif"
  >

  <!-- Twitter -->
  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:url" content="{{ config('app.url', 'http://localhost') }}">
  <meta property="twitter:image"
    content="@if (View::hasSection('meta-img')) @yield('meta-img') @else {{ asset('images/somnivores/site/meta-image.png') }} @endif"
  >
  <meta property="twitter:title" content="{{ config('lorekeeper.settings.site_name', 'Lorekeeper') }} -@yield('title')">
  <meta property="twitter:description"
    content="@if (View::hasSection('meta-desc')) @yield('meta-desc') @else {{ config('lorekeeper.settings.site_desc', 'A Lorekeeper ARPG') }} @endif"
  >

  <!-- No AI scraping directives -->
  <meta name="robots" content="noai">
  <meta name="robots" content="noimageai">

  <!------------------------------ LOREKEEPER RESOURCES ----------------------------->
  <!-- Scripts -->
  <script src="{{ mix('js/app.js') }}"></script>
  <!-- Styles -->
  {{-- <link href="{{ mix('css/app.css') }}" rel="stylesheet"> --}}
  <link href="{{ asset('css/app.css') . '?v=' . filemtime(public_path('css/app.css')) }}" rel="stylesheet">

  <!------------------------------ EXTERNAL RESOURCES ----------------------------->
  <!-- Scripts -->
  {{-- <script src="{{ asset('js/vendor/jquery.tinymce.min.js') }}"></script> --}}
  <script src="{{ asset('js/vendor/jquery.ui.touch-punch.min.js') }}"></script>
  <script src="{{ asset('js/vendor/tinymce/tinymce.min.js') }}"></script>
  <script defer src="{{ asset('js/vendor/bootstrap4-toggle.min.js') }}"></script>
  <script defer src="{{ asset('js/vendor/lightbox.min.js') }}"></script>
  <script defer src="{{ asset('js/vendor/selectize.min.js') }}"></script>
  <script defer src="{{ asset('js/vendor/bs-custom-file-input.min.js') }}"></script>
  <script defer src="{{ asset('js/vendor/bootstrap-colorpicker.min.js') }}"></script>
  <script defer src="{{ asset('js/vendor/jquery-ui-timepicker-addon.js') }}"></script>
  <script defer src="{{ asset('js/site.js') }}"></script>
  <script defer src="{{ asset('js/vendor/croppie.min.js') }}"></script>

  <!-- Scripts for wheel of fortune dailies -->
  <script src="{{ asset('js/vendor/winwheel.min.js') }}"></script>
  <script src="{{ asset('js/vendor/tweenmax.min.js') }}"></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link
    rel="preconnect"
    href="https://fonts.gstatic.com"
    crossorigin
  >
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito"
    rel="stylesheet"
    type="text/css"
  >
  {{-- <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400..800&family=Chewy&display=swap" rel="stylesheet"> --}}
  <link
    href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400..800&family=Jua&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Potta+One&Fredoka:wght@300..700&family=Stylish&display=swap"
    rel="stylesheet"
  >
  <!-- Styles -->
  <link href="{{ asset('css/vendor/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/vendor/selectize.bootstrap4.css') }}" rel="stylesheet">
  <link href="{{ asset('css/vendor/lorekeeper.css?v=' . filemtime(public_path('css/vendor/lorekeeper.css'))) }}"
    rel="stylesheet">
  <link
    defer
    href="{{ faVersion() }}"
    rel="stylesheet"
  >
  <link
    defer
    href="{{ asset('css/vendor/bootstrap.css') }}"
    rel="stylesheet"
  >
  <link
    defer
    href="{{ asset('css/vendor/jquery-ui.min.css') }}"
    rel="stylesheet"
  >
  <link
    defer
    href="{{ asset('css/vendor/bootstrap4-toggle.min.css') }}"
    rel="stylesheet"
  >
  <link
    defer
    href="{{ asset('css/vendor/lightbox.min.css') }}"
    rel="stylesheet"
  >
  <link
    defer
    href="{{ asset('css/vendor/bootstrap-colorpicker.min.css') }}"
    rel="stylesheet"
  >
  <link
    defer
    href="{{ asset('css/vendor/jquery-ui-timepicker-addon.css') }}"
    rel="stylesheet"
  >
  <link href="{{ asset('css/vendor/croppie.css') }}" rel="stylesheet">
  <link
    defer
    href="{{ asset('css/vendor/selectize.bootstrap4.css') }}"
    rel="stylesheet"
  >
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  />

  <!----------- Laravel Includes ----------->
  @include('js._app_inline_js') {{-- JS typically at the bottom of the file moved here --}}
  @include('feed::links')
  @include('js._external_link_alert_js')
  @yield('head')
</head>

<body style="background-color: light-dark(#eee, #222);">
  <div
    id="app"
    class="app"
    {{ isset($componentName) ? 'data-component-path=' . $componentName : '' }}
    {{ isset($pageName) ? 'data-page=' . $pageName : '' }}
  >
    {{-- <div id="site-wrapper" class="{{ View::hasSection('sidebar') ? 'has-sidebar' : '' }}"> --}}
    <div id="site-wrapper" class="has-sidebar">
      <div class="site-background"></div>
      {{-- Header Logo --}}
      <a id="site-logo-header" href="{{ url('/') }}">
        <picture>
          <source srcset="{{ asset('css/images/somnivores/raw/logo_raw.webp') }}"
            media="(prefers-color-scheme: light) and (min-width: 1200px)"
          />
          <source srcset="{{ asset('css/images/somnivores/logo.webp') }}"
            media="(prefers-color-scheme: light) and (min-width: 800px)"
          />
          <img
            src="   {{ asset('css/images/somnivores/logo.webp') }}"
            alt="Somnivores Logo"
            media="(prefers-color-scheme: light)"
          />
          {{-- <source srcset="{{ asset('css/images/somnivores/logo_raw_dark.webp') }}" media="(prefers-color-scheme: dark) and (min-width: 1200px)"  />
          <source srcset="{{ asset('css/images/somnivores/logo_raw_dark.webp') }}" media="(prefers-color-scheme: dark) and (min-width: 800px)"   />
          <img    src="   {{ asset('css/images/somnivores/logo_raw_dark.webp') }}" alt="Somnivores Logo"  media="(prefers-color-scheme: dark)"   /> --}}
        </picture>
      </a>

      {{-- Navbar --}}
      @include('layouts._nav')

      {{-- Sidebar Container --}}
      @if (View::hasSection('sidebar'))
        <div id="sidebar-container">
          {{-- Mobile Sidebar (conditional) --}}
          <div id="site-mobile-header">
            <button class="btn btn-sm btn-outline-dark" id="mobileMenuButton">
              Menu
              <i class="fas fa-caret-right ml-1"> </i>
            </button>
          </div>
          {{-- Actual Desktop Sidebar --}}
          <aside id="sidebar" class="sidebar sidebar-desktop">
            @yield('sidebar')
          </aside>
          {{-- Actual Sidebar --}}
          <aside id="sidebar" class="sidebar sidebar-mobile">
            @yield('sidebar')
          </aside>
        </div>
        {{-- Featured Character --}}
        <aside id="selected-character" class="selected-character-sidebar">
          @include('pages._selected_char')
        </aside>
      @endif

      <main id="main-content" class="main-content">
        <div class="main-backdrop"></div>
        <div class="content-wrapper">

          @if (Settings::get('is_maintenance_mode'))
            <div class="alert alert-secondary">
              The site is currently in maintenance mode!
              @if (!Auth::check() || !Auth::user()->hasPower('maintenance_access'))
                You can browse public content, but cannot make any submissions.
              @endif
            </div>
          @endif

          @if (Auth::check() && Auth::user()->hasUnseenMail && !Auth::user()->is_banned)
            <div class="alert alert-danger">
              <h5 class="mb-0"><i class="fas fa-exclamation"></i> <i class="fas fa-envelope"></i> - You have unread messages
                from staff. <a href="{{ url('mail#modMail') }}">View here.</a></h5>
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
        </div>
      </main>

      @include('layouts._footer')

      @include('layouts._terms_modal')

      <dialog
        class="modal fade"
        id="modal"
        tabindex="-1"
        role="dialog"
      >
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <span class="modal-title h5 mb-0"></span>
              <button
                type="button"
                class="close"
                data-bs-dismiss="modal"
              >&times;</button>
            </div>
            <div class="modal-body">
              {{-- Add all dialogs to top-level --}}
            </div>
          </div>
        </div>
      </dialog>
      @yield('scripts')
      @include('layouts._pagination_js')
    </div>
</body>

</html>
