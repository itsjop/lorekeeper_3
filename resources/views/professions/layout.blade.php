@extends('layouts.app')

@section('title') 
    Professions :: 
    @yield('profession-title')
@endsection

@section('sidebar')
    @include('professions._sidebar')
@endsection

@section('content')
    @yield('profession-content')
@endsection

@section('scripts')
@parent
@endsection