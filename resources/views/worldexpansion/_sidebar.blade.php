<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ url('world/info') }}" class="card-link">World Expanded</a>
  </div>
  <details class="sidebar-section">
    <summary class="sidebar-section-header">Encyclopedia</summary>
    <ul>
      <li class="sidebar-item">
        <a href="{{ url('world') }}">Encyclopedia</a>
      </li>
    </ul>
  </details>
  @if (Settings::get('WE_glossary'))
    <details class="sidebar-section">
      <summary class="sidebar-section-header">Encyclopedia</summary>
      <ul>
        <li class="sidebar-item">
          <a href="{{ url('world/glossary') }}" class="{{ set_active('world/glossary') }}">Glossary</a>
        </li>
      </ul>
    </details>
  @endif
  <details class="sidebar-section">
    <summary class="sidebar-section-header">Geography</summary>
    <ul>
      <li class="sidebar-item">
        <a href="{{ url('world/location-types') }}" class="{{ set_active('world/location-types*') }}">Location Types</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('world/locations') }}" class="{{ set_active('world/locations*') }}">All Locations</a>
      </li>
    </ul>
  </details>
  <details class="sidebar-section">
    <summary class="sidebar-section-header">History and Society</summary>
    <ul>
      <li class="sidebar-item">
        <a href="{{ url('world/event-categories') }}" class="{{ set_active('world/event-categories*') }}">Event Types</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('world/events') }}" class="{{ set_active('world/events*') }}">Events</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('world/figure-categories') }}" class="{{ set_active('world/figure-categories*') }}">Figure
          Types</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('world/figures') }}" class="{{ set_active('world/figures*') }}"> Figures</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('world/faction-types') }}" class="{{ set_active('world/faction-types*') }}">Faction Types</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('world/factions') }}" class="{{ set_active('world/factions*') }}">All Factions</a>
      </li>
    </ul>
  </details>
  <details class="sidebar-section">
    <summary class="sidebar-section-header">Nature</summary>
    <ul>
      <li class="sidebar-item">
        <a href="{{ url('world/fauna-categories') }}" class="{{ set_active('world/fauna-categories*') }}">Fauna
          Types</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('world/faunas') }}" class="{{ set_active('world/faunas*') }}">All Fauna</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('world/flora-categories') }}" class="{{ set_active('world/flora-categories*') }}">Flora
          Types</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('world/floras') }}" class="{{ set_active('world/floras*') }}">All Flora</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('world/concept-categories') }}" class="{{ set_active('world/concept-categories*') }}">Concept
          Types</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('world/concepts') }}" class="{{ set_active('world/concepts*') }}">All Concepts</a>
      </li>
    </ul>
  </details>
</div>
