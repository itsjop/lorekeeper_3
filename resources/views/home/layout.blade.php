@extends('layouts.app', ['pageName' => '/home'])

@section('title')
    Home ::
    @yield('home-title')
@endsection

@section('sidebar')
    @include('home._sidebar')
@endsection

@section('content')
    @yield('home-content')
@endsection

@section('scripts')
    @parent
@endsection
