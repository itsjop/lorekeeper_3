<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ $character->url }}" class="card-link">
      {{ $character->slug }}
    </a>
  </div>
  <div class="details-sb" data-open>
    <summary class="sidebar-section-header"> {{ ucfirst(__('lorekeeper.character')) }} </summary>
    <div class="sb-item">
      <a href="{{ $character->url }}" class="{{ set_active('character/' . $character->slug) }}">
        Information
      </a>
    </div>
    <div class="sb-item">
      <a href="{{ $character->url . '/images' }}" class="{{ set_active('character/' . $character->slug . '/images') }}">
        Images
      </a>
    </div>
    <div class="sb-item">
      <a href="{{ $character->url . '/profile' }}" class="{{ set_active('character/' . $character->slug . '/profile') }}">
        Profile
      </a>
    </div>
    <div class="sb-item">
      <a href="{{ $character->url . '/links' }}" class="{{ set_active('character/' . $character->slug . '/links') }}">
        Connections
      </a>
    </div>
    <div class="sb-item">
      <a href="{{ $character->url . '/gallery' }}" class="{{ set_active('character/' . $character->slug . '/gallery') }}">
        Gallery
      </a>
    </div>
    <div class="sb-item">
      <a href="{{ $character->url . '/pets' }}" class="{{ set_active('character/' . $character->slug . '/pets') }}">
        Pets
      </a>
    </div>
    <div class="sb-item">
      <a href="{{ $character->url . '/inventory' }}" class="{{ set_active('character/' . $character->slug . '/inventory') }}">
        Inventory
      </a>
    </div>
    <div class="sb-item">
      <a href="{{ $character->url . '/bank' }}" class="{{ set_active('character/' . $character->slug . '/bank') }}">
        Bank
      </a>
    </div>
    {{-- @if ($character->getLineageBlacklistLevel() < 2)
        <div class="sb-item">
          <a href="{{ $character->url . '/lineage' }}" class="{{ set_active('character/' . $character->slug . '/lineage') }}">
            Lineage
          </a>
        </div>
      @endif
      <div class="sb-item">
        <a href="{{ $character->url . '/' . __('awards.awardcase') }}"
          class="{{ set_active('character/' . $character->slug . '/' . __('awards.awardcase')) }}"
        > {{ ucfirst(__('awards.awards')) }}
        </a>
      </div> --}}
  </div>
  @if (Auth::check() && (Auth::user()->id == $character->user_id || Auth::user()->hasPower('manage_characters')))
    <div class="details-sb" data-open>
      <summary class="sidebar-section-header"> Settings </summary>
      <div class="sb-item">
        <a href="{{ $character->url . '/profile/edit' }}"
          class="{{ set_active('character/' . $character->slug . '/profile/edit') }}"
        >
          Edit Profile
        </a>
      </div>
      <div class="sb-item">
        <a href="{{ $character->url . '/links/edit' }}"
          class="{{ set_active('character/' . $character->slug . '/links/edit') }}"
        >
          Request Connection
        </a>
      </div>

      <div class="sb-item">
        <a href="{{ $character->url . '/transfer' }}" class="{{ set_active('character/' . $character->slug . '/transfer') }}">
          Transfer
        </a>
      </div>
      @if (Auth::user()->id == $character->user_id)
        <div class="sb-item">
          <a href="{{ $character->url . '/approval' }}" class="{{ set_active('character/' . $character->slug . '/approval') }}">
            Update Design
          </a>
        </div>
      @endif
    </div>
  @endif
  <div class="details-sb">
    <summary class="sidebar-section-header"> History </summary>
    <div class="sb-item">
      <a href="{{ $character->url . '/change-log' }}"
        class="{{ set_active('character/' . $character->slug . '/change-log') }}"> Change Log
      </a>
    </div>
    <div class="sb-item">
      <a href="{{ $character->url . '/ownership' }}"
        class="{{ set_active('character/' . $character->slug . '/ownership') }}"> Ownership History
      </a>
    </div>
    <div class="sb-item">
      <a href="{{ $character->url . '/item-logs' }}"
        class="{{ set_active('character/' . $character->slug . '/item-logs') }}"> Item
        Logs
      </a>
    </div>
    {{-- <div class="sb-item">
        <a href="{{ $character->url . '/currency-logs' }}"
          class="{{ set_active('character/' . $character->slug . '/currency-logs') }}"
        > Currency Logs
        </a>
      </div> --}}
    <div class="sb-item">
      <a href="{{ $character->url . '/submissions' }}"
        class="{{ set_active('character/' . $character->slug . '/submissions') }}"
      > Submissions
      </a>
    </div>
    {{-- <div class="sb-item">
        <a href="{{ $character->url . '/' . __('awards.award') . '-logs' }}"
          class="{{ set_active('character/' . $character->slug . '/' . __('awards.award') . '-logs') }}"
        >
          {{ ucfirst(__('awards.award')) }} Logs
        </a>
      </div> --}}
  </div>
</div>
