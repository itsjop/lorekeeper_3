<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ $character->url }}" class="card-link">{{ $character->fullName }}</a>
  </div>
  <div class="details-sb" data-open>
    <summary class="sidebar-section-header">{{ ucfirst(__('lorekeeper.character')) }} </summary>
    <div class="sb-item">
      <a href="{{ $character->url . '/profile' }}" class="{{ set_active('myo/' . $character->id . '/profile') }}">Profile</a>
    </div>
  </div>
  @if (Auth::check() && (Auth::user()->id == $character->user_id || Auth::user()->hasPower('manage_characters')))
    <div class="details-sb" data-open>
      <summary class="sidebar-section-header">Settings</summary>
      <div class="sb-item">
        <a href="{{ $character->url . '/profile/edit' }}" class="{{ set_active('myo/' . $character->id . '/profile/edit') }}">
          Edit Profile
        </a>
      </div>
      <div class="sb-item">
        <a href="{{ $character->url . '/transfer' }}" class="{{ set_active('myo/' . $character->id . '/transfer') }}">Transfer</a>
      </div>
      @if (Auth::user()->id == $character->user_id)
        <div class="sb-item">
          <a href="{{ $character->url . '/approval' }}" class="{{ set_active('myo/' . $character->id . '/approval') }}">
            Submit MYO Design
          </a>
        </div>
      @endif
    </div>
  @endif
  <div class="details-sb" data-open>
    <summary class="sidebar-section-header">History</summary>
    <div class="sb-item">
      <a href="{{ $character->url . '/change-log' }}" class="{{ set_active('myo/' . $character->id . '/change-log') }}">
        Change Log
      </a>
    </div>
    <div class="sb-item">
      <a href="{{ $character->url . '/ownership' }}" class="{{ set_active('myo/' . $character->id . '/ownership') }}">
        Ownership History
      </a>
    </div>
  </div>
</div>
