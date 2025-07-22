<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ $character->url }}" class="card-link">{{ $character->fullName }}</a>
  </div>
  <details class="sidebar-section" open>
    <summary class="sidebar-section-header">{{ ucfirst(__('lorekeeper.character')) }} </summary>
    <ul>
      <li class="sidebar-item">
        <a href="{{ $character->url . '/profile' }}" class="{{ set_active('myo/' . $character->id . '/profile') }}">Profile</a>
      </li>
    </ul>
  </details>
  @if (Auth::check() && (Auth::user()->id == $character->user_id || Auth::user()->hasPower('manage_characters')))
    <details class="sidebar-section" open>
      <summary class="sidebar-section-header">Settings</summary>
      <ul>
        <li class="sidebar-item">
          <a href="{{ $character->url . '/profile/edit' }}" class="{{ set_active('myo/' . $character->id . '/profile/edit') }}">
            Edit Profile
          </a>
        </li>
        <li class="sidebar-item">
          <a href="{{ $character->url . '/transfer' }}"
            class="{{ set_active('myo/' . $character->id . '/transfer') }}">Transfer</a>
        </li>
        @if (Auth::user()->id == $character->user_id)
          <li class="sidebar-item">
            <a href="{{ $character->url . '/approval' }}" class="{{ set_active('myo/' . $character->id . '/approval') }}">
              Submit MYO Design
            </a>
          </li>
        @endif
      </ul>
    </details>
  @endif
  <details class="sidebar-section" open>
    <summary class="sidebar-section-header">History
      <ul>
        <li class="sidebar-item">
          <a href="{{ $character->url . '/change-log' }}" class="{{ set_active('myo/' . $character->id . '/change-log') }}">
            Change Log
          </a>
        </li>
        <li class="sidebar-item">
          <a href="{{ $character->url . '/ownership' }}" class="{{ set_active('myo/' . $character->id . '/ownership') }}">
            Ownership History
          </a>
        </li>
      </ul>
  </details>
</div>
