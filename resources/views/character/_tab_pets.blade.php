<div class="grid grid-4-col gap-1">
  <header class="flex grid-span jc-between ai-center">
    <h2>
      {{ $character->name }}'s Pets
    </h2>
    <a href="{{ $character->url . '/pets' }}" class="btn btn-outline-info btn-sm">
      View all Pets
      <i class="fas fa-caret-right"></i>
    </a>
  </header>
  {{-- get one random pet --}}
  @foreach ($pets as $pet)
    @if (config('lorekeeper.pets.pet_bonding_enabled'))
      @include('character._pet_bonding_info', ['pet' => $pet, 'character' => $character])
    @else
      <a class="ml-2 mr-3">
        <img src="{{ $pet->pet->image($pet->id) }}" class="w-75" />
        <br>
        <span class="text-light badge badge-dark" style="font-size:95%;">{!! $pet->pet_name !!}</span>
      </a>
    @endif
  @endforeach
</div>
