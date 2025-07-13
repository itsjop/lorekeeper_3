@extends('admin.layout')

@section('admin-title')
  Profession Categories
@endsection

@section('admin-content')
  {!! breadcrumbs([
      'Admin Panel' => 'admin',
      'Profession Categories' => 'admin/data/profession-categories',
      ($category->id ? 'Edit' : 'Create') . ' Category' => $category->id ? 'admin/data/profession-categories/edit/' . $category->id : 'admin/data/profession-categories/create',
  ]) !!}

  <h1>{{ $category->id ? 'Edit' : 'Create' }} Category
    @if ($category->id)
      <a href="#" class="btn btn-danger float-right delete-category-button">Delete Category</a>
    @endif
  </h1>

  {!! Form::open(['url' => $category->id ? 'admin/data/profession-categories/edit/' . $category->id : 'admin/data/profession-categories/create', 'files' => true]) !!}

  <h3>Basic Information</h3>

  <div class="form-group">
    {!! Form::label('Name') !!}
    {!! Form::text('name', $category->name, ['class' => 'form-control']) !!}
  </div>

  <div class="form-group">
    {!! Form::label('Background Image (Optional)') !!} {!! add_help('This image is used as a backdrop for all professions within this category, unless they have a subcategory image set.') !!}
    <div>{!! Form::file('image') !!}</div>
    <div class="text-muted">Recommended size: None (Choose a standard size for all profession background images.)</div>
    @if (isset($category->image_extension))
      <div class="form-check">
        {!! Form::checkbox('remove_image', 1, false, ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'data-off' => 'Leave Background Image As-Is', 'data-on' => 'Remove Current Background Image']) !!}
      </div>
    @endif
  </div>

  <div class="form-group">
    {!! Form::label('Description (Optional)') !!}
    {!! Form::textarea('description', $category->description, ['class' => 'form-control wysiwyg']) !!}
  </div>

  <div class="form-group">
    {!! Form::label('Species Restriction (Optional)') !!} {!! add_help('Use this if the professions under this category should only apply to a specific species.') !!}
    {!! Form::select('species_id', $specieses, $category->species_id, ['class' => 'form-control']) !!}
  </div>

  <div class="text-right">
    {!! Form::submit($category->id ? 'Edit' : 'Create', ['class' => 'btn btn-primary']) !!}
  </div>

  {!! Form::close() !!}

  @if ($category->id)
    <h3>Preview</h3>
    <div class="card mb-3">
      <div class="card-body">
        @include('world._entry', [
            'imageUrl' => $category->imageUrl,
            'name' => $category->displayName,
            'description' => $category->parsed_description,
            'visible' => $category->is_visible,
        ])
      </div>
    </div>
  @endif
@endsection

@section('scripts')
  @parent
  <script>
    $(document).ready(function() {
      $('.delete-category-button').on('click', function(e) {
        e.preventDefault();
        loadModal("{{ url('admin/data/profession-categories/delete') }}/{{ $category->id }}", 'Delete Category');
      });
    });
  </script>
@endsection
