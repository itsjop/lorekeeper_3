<div class=" mb-4">
  {{-- <div class="card-header d-flex flex-column flex-sm-row justify-content-between align-items-center">
    <h4 class="mb-0"><i class="fas fa-money-bill-wave"></i> Recent Sales</h4>
    <a href="{{ url('sales') }}" class="btn btn-primary">View All Sales <i class="fas fa-arrow-right"></i></a>
  </div> --}}

  <div class=" pt-0 px-2">
    @if ($saleses->count())
      @foreach ($saleses as $sales)
        <div class="grid {{ !$loop->last ? 'border-bottom' : '' }}">
          @if ($sales->characters->count())
            <a href="{{ $sales->url }}">
              <img
                src="{{ $sales->characters->first()->character->image->thumbnailUrl }}"
                alt="{!! $sales->characters->first()->character->fullName !!}"
                class="img-thumbnail mb-1"
              />
            </a>
          @endif

          <h5 class="mb-0">{!! $sales->displayName !!}</h5>
          <span class="ml-2 small">
            Posted {!! $sales->post_at ? pretty_date($sales->post_at) : pretty_date($sales->created_at) !!}
            {!! $sales->created_at != $sales->updated_at ? ' :: Last edited ' . pretty_date($sales->updated_at) : '' !!}
          </span>

          @if ($sales->characters->count())
            <div class="pl-3">
              <b>{!! $sales->characters->first()->price !!} ({{ $sales->characters->first()->displayType }})</b>
              @if ($sales->characters->first()->description)
                <br>{!! $sales->characters->first()->description !!}
              @endif
              <br>
              <p class="m-0">
                <b>Artist:</b>
                @foreach ($sales->characters->first()->character->image->artists as $artist)
                  <span class="pl-2">{!! $artist->displayLink() !!}</span>
                @endforeach
              </p>
              <p class="m-0">
                <b>Designer:</b>
                @foreach ($sales->characters->first()->character->image->designers as $designer)
                  <span class="pl-2">{!! $designer->displayLink() !!}</span>
                @endforeach
              </p>
              {{-- @if ($sales->characters->count() == 1)
                <a href="{{ $sales->url }}" class="btn btn-secondary">View Character For
                  {{ $sales->characters->first()->displayType }} <i class="fas fa-arrow-right"></i></a>
              @else
                <a href="{{ $sales->url }}" class="btn btn-secondary">View {!! $sales->characters->count() !!} Characters For
                  {{ $sales->characters->first()->displayType }} <i class="fas fa-arrow-right"></i></a>
              @endif --}}
            </div>
          @else
            <p class="pl-3 mb-0">
              {!! substr(strip_tags(str_replace('<br />', '&nbsp;', $sales->parsed_text)), 0, 300) !!}...
              <a href="{!! $sales->url !!}">
                View sale <i class="fas fa-arrow-right">
                </i>
              </a>
            </p>
          @endif
        </div>
      @endforeach
    @else
      <div class="text-center pt-3">
        <h5 class="mb-0">There are no sales.</h5>
      </div>
    @endif
  </div>
</div>
