@extends('admin.layout')

@section('admin-title')
  Profession Subcategories
@endsection

@section('admin-content')
  {!! breadcrumbs([
      'Admin Panel' => 'admin',
      'Profession Subcategories' => 'admin/data/profession-subcategories',
      ($subcategory->id ? 'Edit' : 'Create') . ' Subcategory' => $subcategory->id ? 'admin/data/profession-subcategories/edit/' . $subcategory->id : 'admin/data/profession-subcategories/create',
  ]) !!}

  <h1>{{ $subcategory->id ? 'Edit' : 'Create' }} Subcategory
    @if ($subcategory->id)
      <a href="#" class="btn btn-danger float-right delete-subcategory-button">Delete Subcategory</a>
    @endif
  </h1>

  {!! Form::open(['url' => $subcategory->id ? 'admin/data/profession-subcategories/edit/' . $subcategory->id : 'admin/data/profession-subcategories/create', 'files' => true]) !!}

  <h3>Basic Information</h3>

  <div class="form-group">
    {!! Form::label('Name') !!}
    {!! Form::text('name', $subcategory->name, ['class' => 'form-control']) !!}
  </div>

  <div class="form-group">
    {!! Form::label('Background Image (Optional)') !!} {!! add_help('This image is used as a backdrop for all professions within this subcategory. This takes precedence over the category image.') !!}
    <div>{!! Form::file('image') !!}</div>
    <div class="text-muted">Recommended size: None (Choose a standard size for all profession background images.)</div>
    @if (isset($subcategory->image_extension))
      <div class="form-check">
        {!! Form::checkbox('remove_image', 1, false, ['class' => 'form-check-input', 'data-bs-toggle' => 'toggle', 'data-off' => 'Leave Background Image As-Is', 'data-on' => 'Remove Current Background Image']) !!}
      </div>
    @endif
  </div>

  <div class="form-group">
    {!! Form::label('Profession Category') !!}
    {!! Form::select('category_id', $categories, $subcategory->category_id, ['class' => 'form-control']) !!}
  </div>

  <div class="form-group">
    {!! Form::label('Description (Optional)') !!}
    {!! Form::textarea('description', $subcategory->description, ['class' => 'form-control wysiwyg']) !!}
  </div>

  <div class="text-right">
    {!! Form::submit($subcategory->id ? 'Edit' : 'Create', ['class' => 'btn btn-primary']) !!}
  </div>

  {!! Form::close() !!}

  @if ($subcategory->id)
    <h3>Preview</h3>
    <div class="card mb-3">
      <div class="card-body">
        @include('world._entry', [
            'imageUrl' => $subcategory->imageUrl,
            'name' => $subcategory->displayName,
            'description' => $subcategory->parsed_description,
            'visible' => $subcategory->is_visible,
        ])
      </div>
    </div>
  @endif
@endsection

@section('scripts')
  @parent
  <script>
    $(document).ready(function() {
      $('.delete-subcategory-button').on('click', function(e) {
        e.preventDefault();
        loadModal("{{ url('admin/data/profession-subcategories/delete') }}/{{ $subcategory->id }}", 'Delete Subcategory');
      });
    });
  </script>
@endsection
