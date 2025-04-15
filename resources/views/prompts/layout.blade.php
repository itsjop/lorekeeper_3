@extends('layouts.app', ['pageName' => '/prompts'])


@section('title')
  Prompts ::
  @yield('prompts-title')
@endsection

@section('sidebar')
  @include('prompts._sidebar')
@endsection

@section('content')
  @yield('prompts-content')
@endsection

@section('scripts')
  @parent
@endsection
