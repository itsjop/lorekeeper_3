<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ $user->url }}" class="card-link">
      {{ Illuminate\Support\Str::limit($user->name, 10, $end = '...') }}
    </a>
  </div>
  <details class="sidebar-section" open>
    <summary class="sidebar-section-header">
      Gallery
    </summary>
    <ul>
      <li class="sidebar-item">
        <a href="{{ $user->url . '/gallery' }}" class="{{ set_active('user/' . $user->name . '/gallery*') }}">
          Gallery
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $user->url . '/character-designs' }}" class="{{ set_active('user/' . $user->name . '/character-designs*') }}">
          Character Designs
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $user->url . '/character-art' }}" class="{{ set_active('user/' . $user->name . '/character-art*') }}">
          Character Art
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $user->url . '/favorites' }}" class="{{ set_active('user/' . $user->name . '/favorites*') }}">
          Favorites
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $user->url . '/favorites/own-characters' }}" class="{{ set_active('user/' . $user->name . '/favorites/own-characters*') }}">
          Own Character Favorites
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $user->url . '/borders' }}" class="{{ set_active('user/' . $user->name . '/borders*') }}">
          Borders
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $user->url . '/shops' }}" class="{{ set_active('user/' . $user->name . '/shops*') }}">
          User Shops
        </a>
      </li>
    </ul>
  </details>
  <details class="sidebar-section" open>
    <summary class="sidebar-section-header">
      User
    </summary>
    <ul>
      <li class="sidebar-item">
        <a href="{{ $user->url . '/aliases' }}" class="{{ set_active('user/' . $user->name . '/aliases*') }}">
          Aliases
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $user->url . '/characters' }}" class="{{ set_active('user/' . $user->name . '/characters*') }}">
          Characters
        </a>
      </li>
      @if (isset($sublists) && $sublists->count() > 0)
        @foreach ($sublists as $sublist)
          <li class="sidebar-item">
            <a href="{{ $user->url . '/sublist/' . $sublist->key }}" class="{{ set_active('user/' . $user->name . '/sublist/' . $sublist->key) }}">
              {{ $sublist->name }}
            </a>
          </li>
        @endforeach
      @endif
      <li class="sidebar-item">
        <a href="{{ $user->url . '/myos' }}" class="{{ set_active('user/' . $user->name . '/myos*') }}">
          MYO Slots
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $user->url . '/inventory' }}" class="{{ set_active('user/' . $user->name . '/inventory*') }}">
          Inventory
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $user->url . '/' . __('awards.awardcase') }}" class="{{ set_active('user/' . $user->name . '/awardcase*') }}">
          {{ ucfirst(ucfirst(__('awards.awardcase'))) }}
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $user->url . '/bank' }}" class="{{ set_active('user/' . $user->name . '/bank*') }}">
          Bank
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $user->url . '/borders' }}" class="{{ set_active('user/' . $user->name . '/borders*') }}">
          Borders
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $user->url . '/shops' }}" class="{{ set_active('user/' . $user->name . '/shops*') }}">
          User Shops
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $user->url . '/pets' }}" class="{{ set_active('user/' . $user->name . '/pets*') }}">
          Pets
        </a>
      </li>
    </ul>
  </details>
  <details class="sidebar-section" open>
    <summary class="sidebar-section-header">
      History
    </summary>
    <ul>
      <li class="sidebar-item">
        <a href="{{ $user->url . '/ownership' }}" class="{{ set_active('user/' . $user->name . '/ownership*') }}">
          Ownership History
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $user->url . '/item-logs' }}" class="{{ $user->url . '/currency-logs*' }}">
          Item Logs
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $user->url . '/pet-logs' }}" class="{{ set_active($user->url . '/pet-logs*') }}">
          Pet Logs
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $user->url . '/currency-logs' }}" class="{{ set_active($user->url . '/currency-logs*') }}">
          Currency Logs
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $user->url . '/' . __('awards.award') . '-logs' }}" class="{{ set_active($user->url . '/award-logs*') }}">
          {{ ucfirst(ucfirst(__('awards.award'))) }} Logs
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $user->url . '/submissions' }}" class="{{ set_active($user->url . '/submissions*') }}">
          Submissions
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ $user->url . '/recipe-logs' }}" class="{{ set_active($user->url . '/recipe-logs*') }}">
          Recipe Logs
        </a>
      </li>
    </ul>
  </details>
  @if (Auth::check() && Auth::user()->hasPower('edit_user_info'))
    <details class="sidebar-section" open>
      <summary class="sidebar-section-header"> Admin </summary>
      <li class="sidebar-item">
        <a href="{{ $user->adminUrl }}">
          Edit User
        </a>
      </li>
      </ul>
    </details>
  @endif
</div>
