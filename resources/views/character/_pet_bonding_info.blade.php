<div class="pet-card card ji-center ai-center gap-_5">
  <img src="{{ $pet->pet->image($pet->id) }}" class="rounded img-fluid" />
  @if ($pet->pet_name)
    <div class="title grid br-15 jc-center ji-center ">
      <div class="petname w-min br-15 py-1 px-2" style="font-size:95%;">
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
  <div class="name flex gap-_5 h-100 jc-center ai-end text-center">
    {!! $pet->pet->displayName !!}
  </div>
  <div class="progress as-end h-80 br-15 w-90">
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
  <div class="level">
    {{ $pet->level?->levelName }}
  </div>
</div>
