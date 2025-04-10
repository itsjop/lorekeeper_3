@extends('activities.layout')

@section('activities-title')
    Activities Index
@endsection

@section('activities-content')
    {!! breadcrumbs(['Activities' => 'activities']) !!}

    <h1>
        Activities
    </h1>

    @include('activities._activities_list')
@endsection
