<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ $user->url }}" class="card-link"> {{ Illuminate\Support\Str::limit($user->name, 10, $end = '...') }} </a>
  </div>
  <div class="details-sb" data-open>
    <summary class="sidebar-section-header"> Deactivated </summary>
    <div class="sb-item px-2"> This account has been deactivated </div>
  </div>
</div>
