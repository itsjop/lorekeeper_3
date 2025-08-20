@extends('dailies.layout')

@section('dailies-title')
  Daily Index
@endsection

@section('dailies-content')
  {!! breadcrumbs([ucfirst(__('dailies.dailies')) => ucfirst(__('dailies.dailies'))]) !!}

  <h1>
    {{ ucfirst(__('dailies.dailies')) }}
  </h1>

  <div class="shops-row grid grid-4-col ai-center">
    @foreach ($dailies as $daily)
      <div class="text-center">
        @if ($daily->has_image)
          <div class="daily-image hover-preview">
            <a href="{{ $daily->url }}">
              <img src="{{ $daily->dailyImageUrl }}" alt="{{ $daily->name }}" /></a>
          </div>
        @endif
        <div class="daily-name mt-1">
          <a href="{{ $daily->url }}" class="h5 mb-0">{{ $daily->name }}</a>
        </div>
      </div>
    @endforeach
  </div>
@endsection
