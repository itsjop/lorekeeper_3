@extends('galleries.layout', ['componentName' => 'galleries/showall'])

@section('gallery-title')
  All Recent Submissions
@endsection

@section('gallery-content')
  {!! breadcrumbs(['Gallery' => 'gallery', 'All Recent Submissions' => 'gallery/all']) !!}

  <h1>
    All Recent Submissions
  </h1>

  <p> This page displays all recent submissions, regardless of gallery. </p>
  @if (!$submissions->count())
    <p> There are no submissions. </p>
  @endif

  {!! Form::open(['method' => 'GET', 'class' => 'flex flex-wrap gap-1 form-inline justify-content-end']) !!}
  <div class="form-group m-0">
    {!! Form::text('title', Request::get('title'), ['class' => 'form-control', 'placeholder' => 'Title']) !!}
  </div>
  <div class="form-group m-0">
    {!! Form::select('prompt_id', $prompts, Request::get('prompt_id'), ['class' => 'form-control']) !!}
  </div>
  <div class="form-group m-0">
    {!! Form::select(
        'sort',
        [
            'newest' => 'Newest First',
            'oldest' => 'Oldest First',
            'alpha' => 'Sort Alphabetically (A-Z)',
            'alpha-reverse' => 'Sort Alphabetically (Z-A)',
            'prompt' => 'Sort by Prompt (Newest to Oldest)',
            'prompt-reverse' => 'Sort by Prompt (Oldest to Newest)'
        ],
        Request::get('sort') ?: 'category',
        ['class' => 'form-control']
    ) !!}
  </div>
  <div class="form-group m-0 mb-3">
    {!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
  </div>
  {!! Form::close() !!}

  @if ($submissions->count())
    {!! $submissions->render() !!}

    <div class="gallery-all grid-4-col">
      @foreach ($submissions as $submission)
        @include('galleries._thumb', ['submission' => $submission, 'gallery' => true])
      @endforeach
    </div>

    {!! $submissions->render() !!}
  @else
    <p> No submissions found!</p>
  @endif

@endsection
