<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ url('masterlist') }}" class="card-link"> Masterlist </a>
  </div>
  <div class="details-sb" data-open>
    <summary class="sidebar-section-header"> Masterlist </summary>
    <div class="sb-item">
      <a href="{{ url('masterlist') }}" class="{{ set_active('masterlist*') }}"> Characters </a>
    </div>
    <div class="sb-item">
      <a href="{{ url('myos') }}" class="{{ set_active('myos*') }}"> MYO Slots </a>
    </div>
  </div>
  @if (Settings::get('character_likes_leaderboard_enable') && Auth::check())
    <div class="details-sb" data-open>
      <summary class="sidebar-section-header"> Character {{ ucfirst(__('character_likes.likes')) }} </summary>
      <div class="sb-item">
        <a href="{{ url(__('character_likes.likes') . '-leaderboard') }}"
          class="{{ set_active(__('character_likes.likes') . '-leaderboard*') }}"
        >
          {{ ucfirst(__('character_likes.likes')) }} Leaderboard </a>
      </div>
    </div>
  @endif
  @if (isset($sublists) && $sublists->count() > 0)
    <div class="details-sb" data-open>
      <summary class="sidebar-section-header"> Sub Masterlists </summary>
      @foreach ($sublists as $sublist)
        <div class="sb-item">
          <a href="{{ url('sublist/' . $sublist->key) }}"
            class="{{ set_active('sublist/' . $sublist->key) }}"> {{ $sublist->name }} </a>
        </div>
      @endforeach
    </div>
  @endif
</div>
