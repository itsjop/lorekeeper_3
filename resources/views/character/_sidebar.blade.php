<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ $character->url }}" class="card-link">
      {{ $character->slug }}
    </a>
  </div>
  <details class="sidebar-section" open>
    <summary class="sidebar-section-header">{{ ucfirst(__('lorekeeper.character')) }}</summary>
    <ul>
      <li class="sidebar-item">
        <a href="{{ $character->url }}" class="{{ set_active('character/' . $character->slug) }}">
          Information
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $character->url . '/profile' }}" class="{{ set_active('character/' . $character->slug . '/profile') }}">
          Profile
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $character->url . '/links' }}" class="{{ set_active('character/' . $character->slug . '/links') }}">
          Connections
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $character->url . '/gallery' }}" class="{{ set_active('character/' . $character->slug . '/gallery') }}">
          Gallery
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $character->url . '/pets' }}" class="{{ set_active('character/' . $character->slug . '/pets') }}"> Pets

        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $character->url . '/inventory' }}" class="{{ set_active('character/' . $character->slug . '/inventory') }}">
          Inventory
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $character->url . '/bank' }}" class="{{ set_active('character/' . $character->slug . '/bank') }}">
          Bank
        </a>
      </li>
      @if ($character->getLineageBlacklistLevel() < 2)
        <li class="sidebar-item">
          <a href="{{ $character->url . '/lineage' }}" class="{{ set_active('character/' . $character->slug . '/lineage') }}">
            Lineage
          </a>
        </li>
      @endif
      <li class="sidebar-item">
        <a href="{{ $character->url . '/' . __('awards.awardcase') }}"
          class="{{ set_active('character/' . $character->slug . '/' . __('awards.awardcase')) }}"
        >{{ ucfirst(__('awards.awards')) }}
        </a>
      </li>
      @if ($character->getLineageBlacklistLevel() < 2)
        <li class="sidebar-item">
          <a href="{{ $character->url . '/lineage' }}" class="{{ set_active('character/' . $character->slug . '/lineage') }}">
            Lineage
          </a>
        </li>
      @endif
    </ul>
  </details>
  <details class="sidebar-section" open>
    <summary class="sidebar-section-header">History</summary>
    <ul>
      <li class="sidebar-item">
        <a href="{{ $character->url . '/images' }}" class="{{ set_active('character/' . $character->slug . '/images') }}">
          Images
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $character->url . '/change-log' }}"
          class="{{ set_active('character/' . $character->slug . '/change-log') }}"
        >Change Log
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $character->url . '/ownership' }}"
          class="{{ set_active('character/' . $character->slug . '/ownership') }}">Ownership History
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $character->url . '/item-logs' }}"
          class="{{ set_active('character/' . $character->slug . '/item-logs') }}">Item
          Logs
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $character->url . '/currency-logs' }}"
          class="{{ set_active('character/' . $character->slug . '/currency-logs') }}"
        >Currency Logs
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $character->url . '/submissions' }}"
          class="{{ set_active('character/' . $character->slug . '/submissions') }}"
        > Submissions
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $character->url . '/' . __('awards.award') . '-logs' }}"
          class="{{ set_active('character/' . $character->slug . '/' . __('awards.award') . '-logs') }}"
        >
          {{ ucfirst(__('awards.award')) }} Logs
        </a>
      </li>
    </ul>
  </details>
  @if (Auth::check() && (Auth::user()->id == $character->user_id || Auth::user()->hasPower('manage_characters')))
    <details class="sidebar-section" open>
      <summary class="sidebar-section-header">Settings</summary>
      <ul>
        <li class="sidebar-item">
          <a href="{{ $character->url . '/profile/edit' }}"
            class="{{ set_active('character/' . $character->slug . '/profile/edit') }}"
          >
            Edit Profile
          </a>
        </li>
        <li class="sidebar-item">
          <a href="{{ $character->url . '/links/edit' }}"
            class="{{ set_active('character/' . $character->slug . '/links/edit') }}"
          >
            Request Link
          </a>
        </li>

        <li class="sidebar-item">
          <a href="{{ $character->url . '/transfer' }}" class="{{ set_active('character/' . $character->slug . '/transfer') }}">
            Transfer
          </a>
        </li>
        @if (Auth::user()->id == $character->user_id)
          <li class="sidebar-item">
            <a href="{{ $character->url . '/approval' }}"
              class="{{ set_active('character/' . $character->slug . '/approval') }}"
            >
              Update Design
            </a>
          </li>
        @endif
      </ul>
    </details>
  @endif
</div>
