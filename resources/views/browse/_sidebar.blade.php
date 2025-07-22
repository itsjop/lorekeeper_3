<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ url('masterlist') }}" class="card-link">Masterlist</a>
  </div>
  <details class="sidebar-section" open>
    <summary class="sidebar-section-header">Masterlist</summary>
    <ul>
      <li class="sidebar-item">
        <a href="{{ url('masterlist') }}" class="{{ set_active('masterlist*') }}">Characters</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('myos') }}" class="{{ set_active('myos*') }}">MYO Slots</a>
      </li>
    </ul>
  </details>
  @if (Settings::get('character_likes_leaderboard_enable') && Auth::check())
    <details class="sidebar-section" open>
      <summary class="sidebar-section-header">Character {{ ucfirst(__('character_likes.likes')) }}</summary>
      <li class="sidebar-item">
        <a href="{{ url(__('character_likes.likes') . '-leaderboard') }}" class="{{ set_active(__('character_likes.likes') . '-leaderboard*') }}">
          {{ ucfirst(__('character_likes.likes')) }} Leaderboard</a>
      </li>
      </ul>
    </details>
  @endif
  @if (isset($sublists) && $sublists->count() > 0)
    <details class="sidebar-section" open>
      <summary class="sidebar-section-header">Sub Masterlists</summary>
      <ul>
        @foreach ($sublists as $sublist)
          <li class="sidebar-item">
            <a href="{{ url('sublist/' . $sublist->key) }}" class="{{ set_active('sublist/' . $sublist->key) }}">{{ $sublist->name }}</a>
          </li>
        @endforeach
        </li>
      </ul>
    </details>
  @endif
</div>
