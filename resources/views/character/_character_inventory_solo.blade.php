<div id="defView" class="grid grid-4-col">
  <header class="flex jc-between ai-center grid-span mb-3">
    <h2>
      {{ $character->name }}'s Inventory
    </h2>
    <a href="{{ $character->url . '/inventory' }}" class="btn btn-outline-info btn-sm">
      View Inventory
      <i class="fas fa-caret-right"></i>
    </a>
  </header>

  <?php $totalItems = 0; ?>
  @foreach ($items as $categoryId => $categoryItems)
    @foreach ($categoryItems as $itemId => $stack)
      @if ($totalItems < 4)
        <?php
        $canName = $stack->first()->category->can_name;
        $stackName = $stack->first()->pivot->pluck('stack_name', 'id')->toArray()[$stack->first()->pivot->id];
        $stackNameClean = htmlentities($stackName);
        $totalItems++; ?>
        <a
          href="#"
          class="grid ji-center inventory-stack text-center img"
          data-id="{{ $stack->first()->pivot->id }}"
          data-name="{!! $canName && $stackName ? htmlentities($stackNameClean) . ' [' : null !!}{{ $character->name ? $character->name : $character->slug }}'s {{ $stack->first()->name }}{!! $canName && $stackName ? ']' : null !!}"
        >
          <img
            src="{{ $stack->first()->imageUrl }}"
            alt="{{ $stack->first()->name }}"
            class="w-80"
          />
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
      @endif
    @endforeach
  @endforeach
</div>
