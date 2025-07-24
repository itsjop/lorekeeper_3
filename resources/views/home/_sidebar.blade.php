<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ url('/') }}" class="card-link">Home</a>
  </div>
  <details class="sidebar-section" open>
    <summary class="sidebar-section-header">Inventory</summary>
    <ul>
      <li class="sidebar-item">
        <a href="{{ url('characters') }}" class="{{ set_active('characters') }}">My Characters</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('characters/myos') }}" class="{{ set_active('characters/myos') }}">My MYO Slots</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('pets') }}" class="{{ set_active('pets*') }}">My Pets</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('inventory') }}" class="{{ set_active('inventory*') }}">Inventory</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url(__('awards.awardcase')) }}"
          class="{{ set_active(__('awards.awardcase') . '*') }}">{{ __('awards.awardcase') }}</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('bank') }}" class="{{ set_active('bank*') }}">Bank</a>
      </li>
    </ul>
  </details>
  <details class="sidebar-section" open>
    <summary class="sidebar-section-header">Activity</summary>
    <ul>
      <li class="sidebar-item">
        <a href="{{ url('submissions') }}" class="{{ set_active('submissions*') }}">Prompt Submissions</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('claims') }}" class="{{ set_active('claims*') }}">Claims</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('characters/transfers/incoming') }}" class="{{ set_active('characters/transfers*') }}">Character
          Transfers</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('characters/pairings') }}" class="{{ set_active('characters/pairings') }}">Character
          Pairings</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('trades/open') }}" class="{{ set_active('trades/open*') }}">Trades</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('comments/liked') }}" class="{{ set_active('comments/liked*') }}">Liked Comments</a>
      </li>
    </ul>
  </details>
  <details class="sidebar-section" open>
    <summary class="sidebar-section-header">Crafting</summary>
    </ul>
    <li class="sidebar-item">
      <a href="{{ url('crafting') }}" class="{{ set_active('crafting') }}">My Recipes</a>
    </li>
    <li class="sidebar-item">
      <a href="{{ url('world/recipes') }}" class="{{ set_active('world/recipes') }}">All
        Recipes</a>
    </li>
    <li class="sidebar-section">
      <div class="sidebar-section-header">Mail</div>
      <div class="sidebar-item"><a href="{{ url('mail') }}" class="{{ set_active('mail*') }}">All Mail</a></div>
    </li>
    </ul>
  </details>
  <details class="sidebar-section" open>
    <summary class="sidebar-section-header">Reports</summary>
    <ul>
      <li class="sidebar-item">
        <a href="{{ url('reports') }}" class="{{ set_active('reports*') }}">Reports</a>
      </li>
    </ul>
  </details>
</div>
