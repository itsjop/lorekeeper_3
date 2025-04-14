@extends('layouts.app', ['pageName' => '/admin'])


@section('title')
    Admin ::
    @yield('admin-title')
@endsection

@section('sidebar')
    @include('admin._sidebar')
@endsection

@section('content')
    @yield('admin-content')
@endsection

@section('scripts')
    @parent
@endsection
