<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ url('/') }}" class="card-link">Home</a>
  </div>
  <details class="sidebar-section" open>
    <summary class="sidebar-section-header">Account</summary>
    <ul>
      <li class="sidebar-item">
        <a href="{{ url('notifications') }}" class="{{ set_active('notifications') }}">Notifications</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('account/settings') }}" class="{{ set_active('account/settings') }}">Settings</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('account/aliases') }}" class="{{ set_active('account/aliases') }}">Aliases</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('account/bookmarks') }}" class="{{ set_active('account/bookmarks') }}">Bookmarks</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('account/deactivate') }}" class="{{ set_active('account/deactivate') }}">Deactivate</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('account/blocked-images') }}" class="{{ set_active('account/blocked-images') }}">Blocked Images</a>
      </li>
    </ul>
  </details>
</div>
