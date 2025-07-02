@extends('lore.layout', ['componentName' => 'lore/activity'])

@section('lore-title')
  {{-- {{ $activity->name }} --}}
  looooreee
@endsection

@section('activities-content')
  <x-admin-edit title="Activity" :object="$activity" />
  {!! breadcrumbs(['Lore' => 'lore']) !!}
  {{-- {!! breadcrumbs(['Activities' => 'activities', $activity->name => $activity->url]) !!} --}}

  <h1>
    {{-- {{ $activity->name }} --}}
    lore 2!!
  </h1>

  {{-- @if (View::exists('activities.modules._' . $activity->module))
    @include('activities.modules._' . $activity->module, ['settings' => $activity->data])
  @endif --}}
@endsection

@section('scripts')
  @parent
@endsection
