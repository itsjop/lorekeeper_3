@if (Auth::user())
  <div class="card">
    <div class="card-body">
      @include('widgets._selected_character', [
          'character' => Auth::user()->settings->selectedCharacter,
          'user' => Auth::user(),
          'fullImage' => true
      ])
    </div>
  </div>
@endif
