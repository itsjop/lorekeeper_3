@extends('layouts.app', ['pageName' => '/activities'])


@section('title')
  Activities ::
  @yield('activities-title')
@endsection

@section('content')
  @yield('activities-content')
@endsection

@section('scripts')
  @parent
@endsection
