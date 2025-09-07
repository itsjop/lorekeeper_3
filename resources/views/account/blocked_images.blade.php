@extends('account.layout')

@section('account-title')
  Blocked Images
@endsection

@section('account-content')
  {!! breadcrumbs(['My Account' => Auth::user()->url, 'Blocked Images' => 'blocked-images']) !!}

  <h1> Blocked Images </h1>

  <p> This is a list of images that you have blocked yourself from viewing on this site. Other users or even admins cannot see this-- this is for your eyes only!</p>

  {!! Form::open(['method' => 'GET']) !!}
  <div class="form-inline justify-content-end mb-3">
    <div class="form-inline justify-content-end">
      <div class="form-group ml-3 mb-3">
        {!! Form::text('name', Request::get('name'), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
      </div>
    </div>
    <div class="form-group mr-3">
      {!! Form::label('sort', 'Sort: ', ['class' => 'mr-2']) !!}
      {!! Form::select(
          'sort',
          [
              'desc' => 'Oldest',
              'asc' => 'Newest',
          ],
          Request::get('sort'),
          ['class' => 'form-control'],
      ) !!}
    </div>
    {!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
  </div>
  {!! Form::close() !!}

  {!! $images->render() !!}
  @if (!count($images))
    <div class="text-center"> You haven't blocked any images yet. </div>
  @else
    <div class="row">
      @foreach ($images as $image)
        <div class="col-md-4 mb-4">
          <div class="card">
            @if ($image->objectImageUrl())
              <div class="card-header text-center">
                <a href="{{ $image->objectUrl() }}">
                  <img src="{{ $image->objectImageUrl() }}" class="img-fluid" style ="max-width: 40%;">
                </a>
              </div>
            @endif
            <div class="card-body text-center">
              <h5 class="mt-3">
                {!! $image->objectDisplayName() !!}
              </h5>
              @include('widgets._object_block', ['object' => $image->object])
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif

  {!! $images->render() !!}
@endsection
