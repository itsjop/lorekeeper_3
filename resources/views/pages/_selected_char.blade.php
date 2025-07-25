@if (Auth::user())
  <div class="card p-2 grid pi-center pc-center">
    @include('widgets._selected_character', [
        'character' => Auth::user()->settings->selectedCharacter,
        'user' => Auth::user(),
        'fullImage' => true
    ])
  </div>
@endif
