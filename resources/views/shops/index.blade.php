@extends('shops.layout', ['componentName' => 'shops/index'])

@section('shops-title')
  Shop Index
@endsection

@section('shops-content')
  {!! breadcrumbs(['Shops' => 'shops']) !!}

  <h1>
    Shops
  </h1>

  <div class="row shops-row">
    @foreach ($shops as $shop)
      <div class="col-md-3 col-6 mb-3 text-center">
        @if ($shop->has_image)
          <div class="shop-image">
            <a href="{{ $shop->url }}"><img src="{{ $shop->shopImageUrl }}" alt="{{ $shop->name }}" /></a>
          </div>
        @endif
        <div class="shop-name mt-1">
          <a href="{{ $shop->url }}" class="h5 mb-0">{{ $shop->name }}</a>
        </div>
        @if ($shop->is_staff)
          @if (Auth::check() && Auth::user()->isstaff)
            @include('shops._shop')
          @endif
        @else
          @include('shops._shop')
        @endif
      </div>
    @endforeach
  </div>
@endsection
