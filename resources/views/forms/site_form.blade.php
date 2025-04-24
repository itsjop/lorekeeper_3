@extends('layouts.app')

@section('title')
  {{ $form->title }}
@endsection

@section('content')
  {!! breadcrumbs(['Site Forms & Polls' => 'forms', $form->title => $form->url]) !!}
  @include('forms._site_form', ['form' => $form, 'page' => true])
  <hr>
  <br><br>
  @comments(['model' => $form, 'perPage' => 5])
@endsection
