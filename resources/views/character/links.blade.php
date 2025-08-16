@extends('character.layout', ['isMyo' => $character->is_myo_slot])

@section('profile-title')
  {{ $character->fullName }}'s Links
@endsection

@section('meta-img')
  {{ $character->image->thumbnailUrl }}
@endsection

@section('profile-content')
  {!! breadcrumbs([
      $character->category->masterlist_sub_id
          ? $character->category->sublist->name . ' Masterlist'
          : 'Character Masterlist' => $character->category->masterlist_sub_id
          ? 'sublist/' . $character->category->sublist->key
          : 'masterlist',
      $character->fullName => $character->url,
      'Profile' => $character->url . '/profile'
  ]) !!}

  @include('character._character_links', [
      'character' => $character,
      'types' => config('lorekeeper.character_relationships')
  ])

  @if (Auth::check() && ($character->user_id == Auth::user()->id || Auth::user()->hasPower('manage_characters')))
    <div class="text-right m-2 mr-5 mt-3">
      <a href="{{ $character->url . '/links/edit' }}" class="btn btn-outline-info btn-sm">
        <i class="fas fa-envelope"></i> Create Connections For {!! $character->fullName !!}
      </a>
    </div>
  @endif
@endsection
@section('scripts')
  <script>
    $(document).ready(function() {
      $('.delete-button').click(function() {
        loadModal("{{ $character->url }}/links/delete/" + $(this).data('id'), 'Delete Link?');
      });
    });
  </script>
@endsection
