@extends('world.layout', ['componentName' => 'world/index'])

@section('world-title')
  Home
@endsection

@section('content')
  {!! breadcrumbs(['Encyclopedia' => 'world']) !!}

  <h1>World</h1>
  <div class="row">
    <div class="col-md-6">
      <div class="card mb-4">
        <div class="card-body text-center br-top-15">
          <img class="w-80" src="{{ asset('images/somnivores/site/characters.png') }}" alt="Characters" />
          <h5 class="card-title">Characters</h5>
        </div>
        <ul class="list-group list-group-flush br-bot-15">
          <li class="list-group-item">
            <a href="{{ url('world/' . __('lorekeeper.specieses')) }}">{{ ucfirst(__('lorekeeper.specieses')) }}</a>
          </li>
          <li class="list-group-item">
            <a href="{{ url('world/' . __('lorekeeper.subtypes')) }}">{{ ucfirst(__('lorekeeper.subtypes')) }}</a>
          </li>
          <li class="list-group-item">
            <a href="{{ url('world/rarities') }}">Rarities</a>
          </li>
          <li class="list-group-item">
            <a href="{{ url('world/trait-categories') }}">Trait Categories</a>
          </li>
          <li class="list-group-item">
            <a href="{{ url('world/traits') }}">All Traits</a>
          </li>
          @if (config('lorekeeper.extensions.visual_trait_index.enable_universal_index'))
            <li class="list-group-item">
              <a href="{{ url('world/universaltraits') }}">Universal Trait Index</a>
            </li>
          @endif
          <li class="list-group-item">
            <a href="{{ url('world/character-categories') }}">Character Categories</a>
          </li>
          {{-- <li class="list-group-item">
            <a href="{{ url('world/' . __('transformations.transformations')) }}">{{ ucfirst(__('transformations.transformations')) }}</a>
          </li> --}}
        </ul>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card mb-4">
        <div class="card-body text-center br-top-15">
          <img class="w-80" src="{{ asset('images/somnivores/site/inventory.png') }}" alt="Items and {{ ucfirst(__('awards.awards')) }}" />
          <h5 class="card-title">Items & Pets & {{ ucfirst(__('awards.awards')) }}</h5>
        </div>
        <ul class="list-group list-group-flush br-bot-15">
          <li class="list-group-item">
            <a href="{{ url('world/item-categories') }}">Item Categories</a>
          </li>
          <li class="list-group-item">
            <a href="{{ url('world/items') }}">All Items</a>
          </li>
          {{-- <li class="list-group-item">
            <a href="{{ url('world/' . __('awards.award') . '-categories') }}">{{ ucfirst(__('awards.award')) }} Categories</a>
          </li> --}}
          <li class="list-group-item">
            <a href="{{ url('world/' . __('awards.awards')) }}">All
              {{ ucfirst(__('awards.awards')) }}</a>
          </li>
          <li class="list-group-item">
            <a href="{{ url('world/currencies') }}">Currencies</a>
          </li>
          <li class="list-group-item">
            <a href="{{ url('world/pet-categories') }}">Pet Categories</a>
          </li>
          <li class="list-group-item">
            <a href="{{ url('world/pets') }}">All Pets</a>
          </li>
          {{-- <li class="list-group-item">
            <a href="{{ url('world/maps') }}">Maps</a>
          </li> --}}
          <li class="list-group-item">
            <a href="{{ url('world/recipes') }}">All Recipes</a>
          </li>
          <li class="list-group-item">
            <a href="{{ url('world/character-titles') }}">All Character Titles</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
@endsection
