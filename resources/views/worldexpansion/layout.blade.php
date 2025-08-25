@extends('layouts.app', ['pageName' => '/worldexpansion'])

@section('title')
  World ::
  @yield('worldexpansion-title')
@endsection

@section('sidebar')
  {{-- Fakes the World Locations being in the lore guide section  --}}
  @if (Route::current()->uri !==('world/locations'))
    @include('worldexpansion._sidebar')
  @else
    @include('pages._sidebar_page')
  @endif
@endsection

@section('content')
  @yield('worldexpansion-content')
@endsection

@section('scripts')
  @parent
@endsection
