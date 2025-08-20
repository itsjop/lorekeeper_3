@extends('shops.layout', ['componentName' => 'shops/index'])

@section('shops-title')
  Shop Index
@endsection

@section('shops-content')
  {!! breadcrumbs(['Shops' => 'shops']) !!}

  <h1>
    Shops
  </h1>

  <div class="shops-row grid grid-4-col ai-center">
    @foreach ($shops as $shop)
      @if ($shop->is_staff)
        @if (Auth::check() && Auth::user()->isstaff)
          @include('shops._shop')
        @endif
      @else
        @include('shops._shop')
      @endif
    @endforeach
  </div>
@endsection
