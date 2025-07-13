@extends('admin.layout')

@section('admin-title')
  Professions
@endsection

@section('admin-content')
  {!! breadcrumbs([
      'Admin Panel' => 'admin',
      'Professions' => 'admin/data/professions',
      ($profession->id ? 'Edit' : 'Create') . ' Profession' => $profession->id ? 'admin/data/professions/edit/' . $profession->id : 'admin/data/professions/create',
  ]) !!}

  <h1>{{ $profession->id ? 'Edit' : 'Create' }} Profession
    @if ($profession->id)
      <a href="#" class="btn btn-danger float-right delete-profession-button">Delete Profession</a>
    @endif
  </h1>

  {!! Form::open(['url' => $profession->id ? 'admin/data/professions/edit/' . $profession->id : 'admin/data/professions/create', 'files' => true]) !!}

  <h3>Basic Information</h3>

  <div class="form-group">
    {!! Form::label('Name') !!}
    {!! Form::text('name', $profession->name, ['class' => 'form-control']) !!}
  </div>

  <div class="card mb-3">
    <div class="card-header h3">Images</div>
    <div class="card-body row">
      <div class="form-group col-md-6">
        @if ($profession->icon_extension)
          <a href="{{ $profession->iconUrl }}" data-lightbox="entry" data-title="{{ $profession->name }}">
            <img src="{{ $profession->iconUrl }}" class="mw-100 float-left mr-3" style="max-height:125px"></a>
        @endif
        {!! Form::label('Icon Image (Optional)') !!} {!! add_help('This icon is used on the profession page.') !!}
        <div>{!! Form::file('image_icon') !!}</div>
        <div class="text-muted">Recommended size: 100x100 or smaller</div>
        @if (isset($profession->icon_extension))
          <div class="form-check">
            {!! Form::checkbox('remove_image_icon', 1, false, ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'data-off' => 'Leave Icon As-Is', 'data-on' => 'Remove Icon Image']) !!}
          </div>
        @endif
      </div>

      <div class="form-group col-md-6">
        @if ($profession->image_extension)
          <a href="{{ $profession->imageUrl }}" data-lightbox="entry" data-title="{{ $profession->name }}">
            <img src="{{ $profession->imageUrl }}" class="mw-100 float-left mr-3" style="max-height:125px"></a>
        @endif
        {!! Form::label('Main Image (Optional)') !!} {!! add_help('This image is used as the main profession image.') !!}
        <div>{!! Form::file('image') !!}</div>
        <div class="text-muted">Recommended size: None (Choose a standard size for all profession images.)</div>
        @if (isset($profession->image_extension))
          <div class="form-check">
            {!! Form::checkbox('remove_image', 1, false, ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'data-off' => 'Leave Main Image As-Is', 'data-on' => 'Remove Current Main Image']) !!}
          </div>
        @endif
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        {!! Form::label('Profession Category') !!}
        {!! Form::select('category_id', $categories, $profession->category_id, ['class' => 'form-control']) !!}
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        {!! Form::label('Profession Subcategory (Optional)') !!}
        {!! Form::select('subcategory_id', $subcategories, $profession->subcategory_id, ['class' => 'form-control']) !!}
      </div>
    </div>
  </div>

  <div class="form-group">
    {!! Form::label('Description (Optional)') !!}
    {!! Form::textarea('description', $profession->description, ['class' => 'form-control wysiwyg']) !!}
  </div>

  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        {!! Form::checkbox('is_active', 1, $profession->id ? $profession->is_active : 1, ['class' => 'form-check-input', 'data-bs-toggle' => 'toggle']) !!}
        {!! Form::label('is_active', 'Set Active', ['class' => 'form-check-label ml-3']) !!} {!! add_help('If turned off, the profession will not be visible to regular users.') !!}
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        {!! Form::checkbox('is_choosable', 1, $profession->id ? $profession->is_choosable : 1, ['class' => 'form-check-input', 'data-bs-toggle' => 'toggle']) !!}
        {!! Form::label('is_choosable', 'Is Selectable', ['class' => 'form-check-label ml-3']) !!} {!! add_help('If turned off, the profession will not be selectable on character profiles.') !!}
      </div>

    </div>
  </div>

  <div class="text-right">
    {!! Form::submit($profession->id ? 'Edit' : 'Create', ['class' => 'btn btn-primary']) !!}
  </div>

  {!! Form::close() !!}

  @if ($profession->id)
    <h3>Preview</h3>
    <div class="card mb-3">
      <div class="card-body">
        @include('world._entry', [
            'imageUrl' => $profession->imageUrl,
            'name' => $profession->displayName,
            'description' => $profession->parsed_description,
            'visible' => $profession->is_visible,
        ])
      </div>
    </div>
  @endif
@endsection

@section('scripts')
  @parent
  <script>
    $(document).ready(function() {
      $('.delete-profession-button').on('click', function(e) {
        e.preventDefault();
        loadModal("{{ url('admin/data/professions/delete') }}/{{ $profession->id }}",
          'Delete Profession');
      });
    });
  </script>
@endsection
