@extends('professions.layout')

@section('title')
  Professions
@endsection

@section('content')
  {!! breadcrumbs(['Professions' => 'professions']) !!}

  <h1> {{ $page->title }} </h1>

  <div class="site-page-content parsed-text">
    {!! $page->parsed_text !!}
  </div>
@endsection
