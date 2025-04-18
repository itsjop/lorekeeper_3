@extends('layouts.app', ['pageName' => '/welcome'])

@section('title')
  Home
@endsection

@section('content')
  @if (Auth::check())
    @include('pages._dashboard')
  @else
    @include('pages._logged_out')
  @endif
@endsection

@section('sidebar')
  @include('pages._sidebar')
@endsection
