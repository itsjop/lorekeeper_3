<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ url('/') }}" class="card-link">Home</a>
  </div>
  <div class="details-sb" data-open>
    <summary class="sidebar-section-header">Account</summary>
    <div class="sb-item">
      <a href="{{ url('notifications') }}" class="{{ set_active('notifications') }}">Notifications</a>
    </div>
    <div class="sb-item">
      <a href="{{ url('account/settings') }}" class="{{ set_active('account/settings') }}">Settings</a>
    </div>
    <div class="sb-item">
      <a href="{{ url('account/aliases') }}" class="{{ set_active('account/aliases') }}">Aliases</a>
    </div>
    <div class="sb-item">
      <a href="{{ url('account/bookmarks') }}" class="{{ set_active('account/bookmarks') }}">Bookmarks</a>
    </div>
    <div class="sb-item">
      <a href="{{ url('account/deactivate') }}" class="{{ set_active('account/deactivate') }}">Deactivate</a>
    </div>
    <div class="sb-item">
      <a href="{{ url('account/blocked-images') }}" class="{{ set_active('account/blocked-images') }}">Blocked Images</a>
    </div>
  </div>
</div>
