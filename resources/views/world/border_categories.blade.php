@extends('world.layout', ['componentName' => 'world/border-categories'])

@section('title')
  Border Categories
@endsection

@section('content')
  {!! breadcrumbs(['World' => 'world', 'Border Categories' => 'world/border-categories']) !!}
  <h1>Border Categories</h1>

  <div>
    {!! Form::open(['method' => 'GET', 'class' => 'form-inline justify-content-end']) !!}
    <div class="form-group mr-3 mb-3">
      {!! Form::text('name', Request::get('name'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group mb-3">
      {!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
  </div>

  {!! $categories->render() !!}
  @foreach ($categories as $category)
    <div class="card mb-3">
      <div class="card-body">
        @include('world._entry', [
            'imageUrl' => $category->categoryImageUrl,
            'name' => $category->displayName,
            'description' => $category->parsed_description,
            'searchUrl' => $category->searchUrl,
            'visible' => $category?->is_visible ?? false,
        ])
      </div>
    </div>
  @endforeach
  {!! $categories->render() !!}

  <div class="text-center mt-4 small text-muted">{{ $categories->total() }}
    result{{ $categories->total() == 1 ? '' : 's' }} found.</div>
@endsection
