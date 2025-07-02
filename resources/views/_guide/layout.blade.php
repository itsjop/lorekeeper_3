@extends('layouts.app', ['pageName' => '/guide'])


@section('title')
  Guides ::
  @yield('guide-title')
@endsection

@section('content')
  @yield('guide-content')
@endsection

@section('scripts')
  @parent
@endsection
