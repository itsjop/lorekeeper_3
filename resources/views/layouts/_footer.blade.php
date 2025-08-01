<footer id="footer">
  <ul class="navbar-ul">
    <li class="footer-nav-item">
      <a href="{{ url('info/terms') }}" class="nav-link">Terms</a>
    </li>
    <li class="footer-nav-item">
      <a href="{{ url('info/privacy') }}" class="nav-link">Privacy</a>
    </li>
    <li class="footer-nav-item">
      <a href="mailto:{{ env('CONTACT_ADDRESS') }}" class="nav-link">Contact</a>
    </li>
    <li class="footer-nav-item">
      <a href="https://github.com/corowne/lorekeeper" class="nav-link">Lorekeeper</a>
    </li>
    <li class="footer-nav-item">
      <a href="{{ url('credits') }}" class="nav-link">Credits</a>
    </li>
  </ul>
  <div class="copyright">&copy; {{ config('lorekeeper.settings.site_name', 'Lorekeeper') }}
    v{{ config('lorekeeper.settings.version') }} {{ Carbon\Carbon::now()->year }}
  </div>
  @if (config('lorekeeper.extensions.scroll_to_top'))
    @include('widgets/_scroll_to_top')
  @endif
</footer>
