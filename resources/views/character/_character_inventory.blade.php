<div id="defView" class="">
    @foreach ($items as $categoryId => $categoryItems)
      <div class="card mb-3 inventory-category">
        <h5 class="card-header inventory-header">
          {!! isset($categories[$categoryId])
              ? '<a href="' . $categories[$categoryId]->searchUrl . '">' . $categories[$categoryId]->name . '</a>'
              : 'Miscellaneous' !!}
          <a
            class="small inventory-collapse-toggle collapse-toggle"
            href="#categoryId_{!! isset($categories[$categoryId]) ? $categories[$categoryId]->id : 'miscellaneous' !!}"
            data-bs-toggle="collapse"
          >
            Show
          </a>
        </h5>

        <div class="card-body inventory-item collapse show grid grid-4-col" id="categoryId_{!! isset($categories[$categoryId]) ? $categories[$categoryId]->id : 'miscellaneous' !!}">
          @foreach ($categoryItems as $itemId => $stack)
            <?php
            $canName = $stack->first()->category->can_name;
            $stackName = $stack->first()->pivot->pluck('stack_name', 'id')->toArray()[$stack->first()->pivot->id];
            $stackNameClean = htmlentities($stackName);
            ?>
            <a
              href="#"
              class="grid ji-center inventory-stack text-center img"
              data-id="{{ $stack->first()->pivot->id }}"
              data-name="{!! $canName && $stackName ? htmlentities($stackNameClean) . ' [' : null !!}{{ $character->name ? $character->name : $character->slug }}'s {{ $stack->first()->name }}{!! $canName && $stackName ? ']' : null !!}"
            >
              <img src="{{ $stack->first()->imageUrl }}" alt="{{ $stack->first()->name }}" />
              {{-- </a>
            <a
              href="#"
              class="{{ $canName ? 'text-muted' : '' }}"
              class="inventory-stack inventory-stack-name"
            > --}}
              {{ $stack->first()->name }} x{{ $stack->sum('pivot.count') }}
            </a>
            @if ($canName && $stackName)
              <span class="inventory-stack inventory-stack-name badge badge-info"
                style="font-size:95%; margin:5px;">"{{ $stackName }}"
              </span>
            @endif
          @endforeach
        </div>
      </div>
    @endforeach
  </div>
