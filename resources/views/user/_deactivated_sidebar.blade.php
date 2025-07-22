<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ $user->url }}" class="card-link">{{ Illuminate\Support\Str::limit($user->name, 10, $end = '...') }}</a>
  </div>
  <details class="sidebar-section" open>
    <summary class="sidebar-section-header">Deactivated</summary>
    <li class="sidebar-item px-2">This account has been deactivated</li>
  </details>
</div>
