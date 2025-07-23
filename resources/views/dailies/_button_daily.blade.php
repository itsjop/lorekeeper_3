<div class="text-center">
  @if ($daily->has_image)
    <img
      src="{{ $daily->dailyImageUrl }}"
      style="max-width:100%"
      alt="{{ $daily->name }}"
    />
  @endif
  <p>{!! $daily->parsed_description !!}</p>
</div>

@if (Auth::user())
  @if ($daily->has_button_image)
    <div class="row justify-content-center mt-2">
      <form action="" method="post">
        @csrf
        <button
          class="btn"
          style="background-color:transparent;"
          name="daily_id"
          value="{{ $daily->id }}"
          @if ($isDisabled) disabled @endif
        >
          <img
            src="{{ $daily->buttonImageUrl }}"
            class="w-100 daily-button {{ Auth::check() && isset($cooldown) ? 'disabled' : ''}}"
            style="max-width:200px;"
          />
        </button>
      </form>
    </div>
  @else
    <div class="row justify-content-center mt-2">
      <form action="" method="post">
        @csrf
        <button
          class="btn btn-primary"
          name="daily_id"
          value="{{ $daily->id }}"
          @if ($isDisabled) disabled @endif
        >Collect Reward!</button>
      </form>
    </div>
  @endif
  <div class="text-center">
    <hr>
    <small>
      @if ($daily->daily_timeframe == 'lifetime')
        You will be able to collect rewards once.
      @else
        You will be able to collect rewards {!! $daily->daily_timeframe !!}.
      @endif
      @if (Auth::check() && isset($cooldown))
        You can collect rewards {!! pretty_date($cooldown) !!}!
      @endif
    </small>
  </div>
@else
  <div class="row mt-2 mb-2 justify-content-center">
    <div class="alert alert-danger" role="alert">
      You must be logged in to collect {{ __('dailies.dailies') }}!
    </div>
  </div>
@endif

@if ($daily->progress_display != 'none')
  <div class="card mt-5">
    <div class="card-header">
      <h4 class="m-0 align-items-center">Progress ({{ $timer->step ?? 0 }}/{{ $daily->maxStep }}) {!! add_help(
          $daily->is_streak
              ? 'Progress will reset if you miss collecting your reward in the given timeframe.'
              : 'Progress is safe even if you miss collecting your reward in the given timeframe.'
      ) !!}</h4>
    </div>

    <div class="all-dailies card-body w-100">
      @foreach ($daily->rewards()->get()->groupBy('step') as $step => $rewards)
        @if ($step > 0)
          <div class="daily {{ $step > ($timer->step ?? 0) ? 'inactive' : '' }}">
            <header>
              <h5 class="">
                @if ($step > ($timer->step ?? 0))
                  <i class="fa fa-x"></i>
                @else
                  <i class="fa fa-check"></i>
                @endif
                Day {{ $step }}
              </h5>
            </header>
            <div class="prizes {{ count($rewards) > 3 ? 'many' : 'few' }}">
              @if ($daily->progress_display == 'all' || $step <= ($timer->step ?? 0))
              @foreach ($rewards as $reward)
              <div class="prize">
                @if ($reward->rewardImage)
                      <div class="prize-box">
                        <img
                        src="{{ $reward->rewardImage }}"
                        data-img="{{ $reward->rewardImage }}"
                         alt="{{ $reward->reward()->first()->name }}" />
                        {{-- <img src="{{ asset('images/pages/bucket.png') }}" --}}

                      </div>
                    @endif
                    <div class="prize-label row justify-content-center">{{ $reward->quantity }} {{ $reward->reward()->first()->name }}</div>
                  </div>
                @endforeach
              @endif
            </div>
          </div>
        @endif
      @endforeach
    </div>
  </div>
@endif
