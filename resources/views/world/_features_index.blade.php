@foreach ($features as $categoryId => $categoryFeatures)
  @if (!isset($categories[$categoryId]) || (Auth::check() && Auth::user()->hasPower('edit_data')) || $categories[$categoryId]->is_visible)
    <div class="card mb-3 inventory-category">
      <h5 class="card-header inventory-header">
        @if (isset($categories[$categoryId]) && !$categories[$categoryId]->is_visible)
          <i class="fas fa-eye-slash mr-1"></i>
        @endif
        {!! isset($categories[$categoryId]) ? '<a href="' . $categories[$categoryId]->searchUrl . '">' . $categories[$categoryId]->name . '</a>' : 'Miscellaneous' !!}
      </h5>
      <div class="card-body inventory-body">
        <div class="grid grid-4-col gap-2">
          @foreach ($categoryFeatures as $featureId => $feature)
            <div class="inventory-item pi-center pc-center">
              <div class="title">{!! $feature->first()->title !!}</div>
              <div class="{{ 'card-bg_animated ' . lcfirst(__($feature->first()->rarity->name)) }}">
                <div class="stars"></div>
              </div>
              @if ($feature->first()->has_image)
                <a class="badge" style="border-radius:.5em; ">
                  <img class="my-1 modal-image" src="{{ $feature->first()->imageUrl }}" alt="{{ $feature->first()->name }}" data-id="{{ $feature->first()->id }}" />
                </a>
              @else
                <a class="badge" style="border-radius:.5em; ">
                </a>
              @endif

              @if (!$feature->first()->is_visible)
                <i class="fas fa-eye-slash mr-1"></i>
              @endif
              <div class="rarity flex gap-_5 pi-center pc-center">{!! $feature->first()->rarityName !!}</div>
              @if ($showSubtype && $feature->first()->subtype)
                <br />({!! $feature->first()->subtype->twolineDisplayName !!} Subtype)
              @endif
            </div>
          @endforeach
        </div>
      </div>
    </div>
  @endif
@endforeach
