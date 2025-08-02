@if (Auth::user())
  <div class="card grid pi-center">
    @include('widgets._selected_character', [
        'character' => Auth::user()->settings->selectedCharacter,
        'user' => Auth::user(),
        'fullImage' => true
    ])
  </div>
@endif
