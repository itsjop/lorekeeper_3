<header class="flex jc-between ai-center">
  <h2>
    {{ $character->name }}'s Connections
    <a class=" mr-2" href="{{ url('reports/new?url=') . $character->url . '/links' }}">
      <i
        class="fas fa-exclamation-triangle text-danger"
        data-bs-toggle="tooltip"
        title="Click here to report this character's connections."
        style="opacity: 50%;"
      ></i>
    </a>
  </h2>
  <a href="{{ $character->url . '/links' }}" class="btn btn-outline-info btn-sm">
    View all Connections
    <i class="fas fa-caret-right"></i>
  </a>
</header>
<br>
@if (count($character->links))
  <div class="container grid grid-4-col gap-1">
    @foreach ($character->links as $key => $link)
      @if ($key < 4)
        <div class="w-100 text-center">
          <h4 class="m-0">
            {!! $link->type !!}
          </h4>
          @include('character._link_character', ['character' => $link->getOtherCharacter($character->id)])
        </div>
      @endif
    @endforeach
  </div>
@else
  <div class="alert alert-info">
    <i class="fas fa-info-circle"></i> This character currently has no connections.
  </div>
@endif
