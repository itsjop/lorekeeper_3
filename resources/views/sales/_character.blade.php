<div class="card grid pi-center pc-center {{ $total < 3 ? 'grid-2-col' : '' }}">
  <a href="{{ $character->character->url }}">
    <img
      src="{{ $loop->count == 1 ? $character->image->imageUrl : $character->image->thumbnailUrl }}"
      class="mw-100 img-thumbnail hover-preview_105"
      alt="{{ $character->fullName }}"
    />
    {{-- @include('browse._masterlist_content_entry', [
          'char_image' =>
              $character->image->canViewFull(Auth::user() ?? null) &&
              file_exists(public_path($character->image->imageDirectory . ' /  ' . $character->image->fullsizeFileName))
                  ? $character->image->thumbnailUrl
                  : $character->image->thumbnailUrl
      ]) --}}
  </a>
  <div class="card-basic p-3 m-0 ta-center">
    <div class="mt-2">
      <h5>
        {{ $character->displayType }}: <a href="{{ $character->character->url }}"> {!! $character->character->slug !!} </a> ・ <span
          class="{{ $character->is_open && $character->sales->is_open ? 'text-success' : '' }}"
        >[{{ $character->is_open && $character->sales->is_open ? 'Open' : 'Closed' }}]</span>
        <br />
        <small>
          {!! $character->image->species->displayName !!} ・ {!! $character->image->rarity->displayName !!} <br />
        </small>
      </h5>

      @if ($loop->count == 1)
        <div class="mb-2">
          @if (config('lorekeeper.extensions.traits_by_category'))
            <div>
              @php
                $traitgroup = $character->image->features()->get()->groupBy('feature_category_id');
              @endphp
              @if ($character->image->features()->count())
                @foreach ($traitgroup as $key => $group)
                  <div>
                    @if ($group->count() > 1)
                      <strong class="w-100 ta-start"> {!! $key ? $group->first()->feature->category->displayName : 'Miscellaneous' !!}:</strong>
                      <ul>
                        @foreach ($group as $feature)
                          <li class="ta-start my-0">
                            {!! $feature->feature->displayName !!}@if ($feature->data)
                              ({{ $feature->data }})
                            @endif
                            {{-- {{ !$loop->last ? ' ' : '' }} --}}
                          </li>
                        @endforeach
                      </ul>
                    @else
                      <strong class="w-100 ta-start"> {!! $key ? $group->first()->feature->category->displayName : 'Miscellaneous' !!}:</strong>
                      <ul>
                        <li class="ta-start my-0">
                          {!! $group->first()->feature->displayName !!}
                          @if ($group->first()->data)
                            ({{ $group->first()->data }})
                        </li>
                      </ul>
                    @endif
                @endif
            </div>
          @endforeach
        @else
          <div> No traits listed. </div>
      @endif
    </div>
  @else
    <div>
      <?php $features = $character->image->features()->with('feature.category')->get(); ?>
      @if ($features->count())
        @foreach ($features as $feature)
          <div>
            @if ($feature->feature->feature_category_id)
              <strong> {!! $feature->feature->category->displayName !!}:</strong>
              @endif {!! $feature->feature->displayName !!} @if ($feature->data)
                ({{ $feature->data }})
              @endif
          </div>
        @endforeach
      @else
        <div> No traits listed. </div>
      @endif
    </div>
    @endif
  </div>
  @endif

  <h6>
    <div class="mb-2">
      Design:
      @foreach ($character->image->designers as $designer)
        {!! $designer->displayLink() !!}{{ !$loop->last ? ', ' : '' }}
      @endforeach ・
      Art:
      @foreach ($character->image->artists as $artist)
        {!! $artist->displayLink() !!}{{ !$loop->last ? ', ' : '' }}
      @endforeach
    </div>

    {!! $character->price !!}
    {!! isset($character->link) || isset($character->data['end_point']) ? '<br/>' : '' !!}
    @if (isset($character->data['end_point']))
      {{ $character->data['end_point'] }}
    @endif
    {{ isset($character->link) && (!isset($character->sales->comments_open_at) || (Auth::check() && Auth::user()->hasPower('edit_pages')) || $character->sales->comments_open_at < Carbon\Carbon::now()) && isset($character->data['end_point']) ? ' ・ ' : '' }}
    @if (isset($character->link) &&
            (!isset($character->sales->comments_open_at) ||
                (Auth::check() && Auth::user()->hasPower('edit_pages')) ||
                $character->sales->comments_open_at < Carbon\Carbon::now())
    )
      <a href="{{ $character->link }}"> {{ $character->typeLink }} </a>
    @endif
  </h6>

  <p> {!! $character->description !!} </p>
</div>
</div>
</div>
