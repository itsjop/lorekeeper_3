@extends('admin.layout', ['componentName' => 'admin/worldexpansion/create-edit-faction-type'])

@section('admin-title')
  Faction Types
@endsection

@section('admin-content')
  {!! breadcrumbs(['Admin Panel' => 'admin', 'Faction Types' => 'admin/world/faction-types', ($type->id ? 'Edit' : 'Create') . ' Faction Type' => $type->id ? 'admin/world/faction-types/edit/' . $type->id : 'admin/world/faction-types/create']) !!}

  <h1>{{ $type->id ? 'Edit' : 'Create' }} Faction Type
    @if ($type->id)
      ({!! $type->displayName !!})
      <a href="#" class="btn btn-danger float-right delete-type-button">Delete Faction Type</a>
    @endif
  </h1>

  {!! Form::open(['url' => $type->id ? 'admin/world/faction-types/edit/' . $type->id : 'admin/world/faction-types/create', 'files' => true]) !!}

  <div class="card mb-3">
    <h2 class="card-header h3">Basic Information</h2>
    <div class="card-body">
      <div class="row mx-0 px-0 ">
        <div class="form-group col-md-6 px-0 pr-md-1">
          {!! Form::label('Name - Singular') !!}
          {!! Form::text('name', $type->name, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6 px-0 pl-md-1">
          {!! Form::label('Name - Plural') !!}
          {!! Form::text('names', $type->names, ['class' => 'form-control']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('Summary (Optional)') !!}
        {!! Form::text('summary', $type->summary, ['class' => 'form-control']) !!}
      </div>
    </div>
  </div>

  <div class="card mb-3">
    <h2 class="card-header h3">Images</h2>
    <div class="card-body row">
      <div class="form-group col-md-6">
        @if ($type->thumb_extension)
          <a href="{{ $type->thumbUrl }}" data-lightbox="entry" data-title="{{ $type->name }}">
            <img src="{{ $type->thumbUrl }}" class="mw-100 float-left mr-3" style="max-height:125px"></a>
        @endif
        {!! Form::label('Thumbnail Image (Optional)') !!} {!! add_help('This thumbnail is used on the faction type index.') !!}
        <div>{!! Form::file('image_th') !!}</div>
        <div class="text-muted">Recommended size: 200x200</div>
        @if (isset($type->thumb_extension))
          <div class="form-check">
            {!! Form::checkbox('remove_image_th', 1, false, ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'data-off' => 'Leave Thumbnail As-Is', 'data-on' => 'Remove Thumbnail Image']) !!}
          </div>
        @endif
      </div>
      <div class="form-group col-md-6">
        @if ($type->image_extension)
          <a href="{{ $type->imageUrl }}" data-lightbox="entry" data-title="{{ $type->name }}">
            <img src="{{ $type->imageUrl }}" class="mw-100 float-left mr-3" style="max-height:125px"></a>
        @endif
        {!! Form::label('Type Image (Optional)') !!} {!! add_help('This image is used on the faction type page as a header.') !!}
        <div>{!! Form::file('image') !!}</div>
        <div class="text-muted">Recommended size: None (Choose a standard size for all type header images.)</div>
        @if (isset($type->image_extension))
          <div class="form-check">
            {!! Form::checkbox('remove_image', 1, false, ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'data-off' => 'Leave Header Image As-Is', 'data-on' => 'Remove Current Header Image']) !!}
          </div>
        @endif
      </div>
    </div>
  </div>

  <div class="card mb-3">
    <div class="card-header h3">
      {!! Form::label('Description (Optional)') !!}
    </div>
    <div class="card-body">
      <div class="form-group" style="clear:both">
        {!! Form::textarea('description', $type->description, ['class' => 'form-control wysiwyg']) !!}
      </div>
    </div>
  </div>

  <div class="text-right">
    {!! Form::submit($type->id ? 'Edit' : 'Create', ['class' => 'btn btn-primary']) !!}
  </div>

  {!! Form::close() !!}
@endsection

@section('scripts')
  @parent
  <script>
    $(document).ready(function() {
      $('.delete-type-button').on('click', function(e) {
        e.preventDefault();
        loadModal("{{ url('admin/world/faction-types/delete') }}/{{ $type->id }}", 'Delete Faction Type');
      });
      $('.selectize').selectize();
    });
  </script>
@endsection
