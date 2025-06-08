@extends('layouts.app', ['pageName' => '/welcome'])

@section('title')
  Home
@endsection

@section('sidebar')
    @if(Auth::check())
       @include('frontpage._sidebar')
    @endif
@endsection

@section('content')
  @if (Auth::check())
    <lore-page generic-prop-name="BRAND NEW"></lore-page>
  {{-- TODO: Re-enable normal dashboard --}}
    {{-- @include('pages._dashboard') --}}
  @else
    @include('pages._logged_out')
  @endif
@endsection

@section('sidebar')
  @include('pages._sidebar')
@endsection
