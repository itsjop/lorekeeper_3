@extends('_guide.layout', ['componentName' => 'guide/guide'])

@section('guide-title')
  {{-- {{ $activity->name }} --}}
  guideeeee
@endsection

@section('guide-content')
  <x-admin-edit title="Activity" :object="$activity" />
  {!! breadcrumbs(['Guides' => 'guides']) !!}
  {{-- {!! breadcrumbs(['Guides' => 'guides', $activity->name => $activity->url]) !!} --}}

  <h1>
    {{-- {{ $activity->name }} --}}
    guide2
  </h1>
{{--
  @if (View::exists('activities.modules._' . $activity->module))
    @include('activities.modules._' . $activity->module, ['settings' => $activity->data])
  @endif --}}
@endsection

@section('scripts')
  @parent
@endsection
