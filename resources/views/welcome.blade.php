@extends('layouts.app', ['pageName' => '/welcome'])

@section('title')
  Home
@endsection

@section('content')
<sub-component propname="something"></sub-component>
  @if (Auth::check())
    @include('pages._dashboard')
  @else
    @include('pages._logged_out')
  @endif
@endsection

@section('sidebar')
  @include('pages._sidebar')
@endsection
