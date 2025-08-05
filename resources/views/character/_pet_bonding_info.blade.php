<div class="pet-card card ji-center ai-center gap-_5">
  <img
    src="{{ $pet->pet->image($pet->id) }}"
    class="rounded img-fluid"
    style="max-width: 150px;"
  />

  @if ($pet->pet_name)
    <div class="title grid br-15 jc-center ji-center ">
      <div class="petname w-min br-15 py-1 px-2 h4" style="color: white; background-color:rgba(119, 76, 198, 0.599);">
        {!! $pet->pet_name !!}
      </div>
    </div>
  @else
    <div class="title grid br-15 jc-center ji-center ">
      <div class=" small text-secondary w-min br-15 py-1 px-2" style="font-size:95%;">
        ---
      </div>
    </div>
  @endif

  <div
    class="name flex gap-_5 h-100 jc-center ai-end text-center h3"style="font-style: italic; color:rgb(103, 77, 156); font-size:1rem;"
  >
    {!! $pet->pet->displayName !!}
  </div>

  <div class="progress as-end h-90 br-15 w-60">
    <div
      class="progress-bar progress-bar-striped progress-bar-animated"
      role="progressbar"
      style="width: {{ ($pet->level?->nextLevel?->bonding_required ? ($pet->level?->bonding / $pet->level?->nextLevel?->bonding_required) * 100 : 1 * 100) . '%' }}"
      aria-valuenow="{{ $pet->level?->bonding }}"
      aria-valuemin="0"
      aria-valuemax="{{ $pet->level?->nextLevel?->bonding_required ?? 100 }}"
    >
      {{ $pet->level?->nextLevel?->bonding_required ? $pet->level?->bonding . '/' . $pet->level?->nextLevel?->bonding_required : 'Max' }}
    </div>
  </div>
  <div class="level h3" style="font-style: italic; color:rgb(103, 77, 156); font-size:1rem;">
    {{ $pet->level?->levelName }}
  </div>
</div>
