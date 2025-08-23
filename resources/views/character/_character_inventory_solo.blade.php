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
  @foreach ($items as $stackItem)
    @if ($totalItems < 4)
      <?php
      $item = $stackItem->first();
      $canName = $item->can_name;
      $stackName = $item->pivot->pluck('stack_name', 'id')->toArray()[$item->pivot->id];
      $stackNameClean = htmlentities($stackName);
      $totalItems++; ?>
      <a
        href="#"
        class="grid ji-center inventory-stack text-center img"
        data-id="{{ $item->pivot->id }}"
        data-name="{!! $canName && $stackName ? htmlentities($stackNameClean) . ' [' : null !!}{{ $character->name ? $character->name : $character->slug }}'s {{ $item->name }}{!! $canName && $stackName ? ']' : null !!}"
      >
        <img
          class="img-thumbnail"
          style="display: block"
          src="{{ $item->imageUrl }}"
          alt="{{ $item->name }}"
        />
        {{ $item->name }}
      </a>
      @if ($canName && $stackName)
        <span class="inventory-stack inventory-stack-name badge badge-info"
          style="font-size:95%; margin:5px;">"{{ $stackName }}"
        </span>
      @endif
    @endif
  @endforeach
</div>
