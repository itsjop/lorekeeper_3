@extends('activities.layout')

@section('activities-title')
    {{ $activity->name }}
@endsection

@section('activities-content')
    <x-admin-edit title="Activity" :object="$activity" />
    {!! breadcrumbs(['Activities' => 'activities', $activity->name => $activity->url]) !!}

    <h1>
        {{ $activity->name }}
    </h1>

    <div class="text-center">
        <p>{!! $activity->parsed_description !!}</p>
    </div>

    @if (View::exists('activities.modules._' . $activity->module))
        @include('activities.modules._' . $activity->module, ['settings' => $activity->data])
    @endif
@endsection

@section('scripts')
    @parent
@endsection
