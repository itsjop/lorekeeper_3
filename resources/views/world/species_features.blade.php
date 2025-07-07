@extends('world.layout', ['componentName' => 'world/species-features'])

@section('world-title')
  {{ $species->name }} Traits
@endsection

@section('content')
  {!! breadcrumbs([
      'World' => 'world',
      ucfirst(__('lorekeeper.species')) => 'world/species',
      $species->name => $species->url,
      'Traits' => 'world/species/' . $species->id . 'traits',
  ]) !!}
  <h1>{{ $species->name }} Traits</h1>

  <p>This is a visual index of all {!! $species->displayName !!}-specific traits. Click a trait to view more info on it!</p>
  @include('world._features_index', ['features' => $features, 'showSubtype' => true])
@endsection

@section('scripts')
  @if (config('lorekeeper.extensions.visual_trait_index.trait_modals'))
    @include('world._features_index_modal_js')
  @endif
  @if (config('lorekeeper.extensions.species_trait_index.trait_modals'))
    <script>
      $(document).ready(function() {
        $('.modal-image').on('click', function(e) {
          e.preventDefault();

          loadModal("{{ url('world/species/' . $species->id . '/trait') }}/" + $(this).data('id'), 'Trait Detail');
        });
      })
    </script>
  @endif
@endsection
