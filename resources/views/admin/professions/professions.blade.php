@extends('admin.layout')

@section('admin-title') Professions @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', 'Professions' => 'admin/data/professions']) !!}

<h1>Professions</h1>

<p>This is a list of professions that can be attached to characters. These professions can be freely chosen by the user on their profile. </p>

<div class="text-right mb-3">
    <a class="btn btn-primary" href="{{ url('admin/data/profession-categories') }}"><i class="fas fa-folder"></i> Profession Categories</a>
    <a class="btn btn-primary" href="{{ url('admin/data/profession-subcategories') }}"><i class="fas fa-folder"></i> Profession Subcategories</a>

    <a class="btn btn-primary" href="{{ url('admin/data/professions/create') }}"><i class="fas fa-plus"></i> Create New Profession</a>
</div>

<div>
    {!! Form::open(['method' => 'GET', 'class' => 'form-inline justify-content-end']) !!}
        <div class="form-group mr-3 mb-3">
            {!! Form::text('name', Request::get('name'), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
        </div>
        <div class="form-group mr-3 mb-3">
            {!! Form::select('species_id', $specieses, Request::get('species_id'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group mr-3 mb-3">
            {!! Form::select('category_id', $categories, Request::get('category_id'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group mr-3 mb-3">
            {!! Form::select('subcategory_id', $subcategories, Request::get('subcategory_id'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group mb-3">
            {!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
</div>

@if(!count($professions))
    <p>No professions found.</p>
@else
    {!! $professions->render() !!}
      <div class="row ml-md-2">
        <div class="d-flex row flex-wrap col-12 pb-1 px-0 ubt-bottom">
          <div class="col-12 col-md-3 font-weight-bold">Name</div>
          <div class="col-6 col-md-2 font-weight-bold">Category</div>
          <div class="col-6 col-md-2 font-weight-bold">Subcategory</div>
          <div class="col-6 col-md-2 font-weight-bold">Species</div>
        </div>
        @foreach($professions as $profession)
        <div class="d-flex row flex-wrap col-12 mt-1 pt-1 px-0 ubt-top">
          <div class="col-12 col-md-3">{{ $profession->name }}</div>
          <div class="col-6 col-md-2">{{ $profession->category ? $profession->category->name : '---' }}</div>
          <div class="col-6 col-md-2">{{ $profession->subcategory ? $profession->subcategory->name : '---' }}</div>
          <div class="col-6 col-md-2">{{ $profession->species ? $profession->species->name : '---' }}</div>
          <div class="col-12 col-md-1"><a href="{{ url('admin/data/professions/edit/'.$profession->id) }}" class="btn btn-primary py-0 px-1 w-100">Edit</a></div>
        </div>
        @endforeach
      </div>
    {!! $professions->render() !!}
    <div class="text-center mt-4 small text-muted">{{ $professions->total() }} result{{ $professions->total() == 1 ? '' : 's' }} found.</div>
@endif

@endsection

@section('scripts')
@parent
@endsection
