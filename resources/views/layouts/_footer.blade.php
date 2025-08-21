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
  {{-- <div class="copyright">
    &copy; {{ config('lorekeeper.settings.site_name', 'Lorekeeper') }}
    v{{ config('lorekeeper.settings.version') }} {{ Carbon\Carbon::now()->year }}
  </div> --}}
  <div
    id="debug"
    class="copyright"
    style="opacity: 0.4; font-size: .5rem;"
  >
    <pre id="" class="m-0">
      temp debugging info pls ignore:
    </pre>
    <pre id="wid" class="m-0"></pre>
  </div>
  @if (config('lorekeeper.extensions.scroll_to_top'))
    @include('widgets/_scroll_to_top')
  @endif
</footer>
<script>
  $(document).ready(function() {
    $('#wid').text(`
      availWidth: ${window.screen.availWidth}, ratio: ${window.devicePixelRatio}
    `);
  })
</script>
<style>
  #debug {
    text-align: end;
  }

  @container main-container (width > 600px) {
    #debug {
      display: none;
    }
  }
</style>
