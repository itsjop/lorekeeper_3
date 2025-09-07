@extends('admin.layout')

@section('admin-title')
  Profession Subcategories
@endsection

@section('admin-content')
  {!! breadcrumbs(['Admin Panel' => 'admin', 'Profession Subcategories' => 'admin/data/profession-subcategories']) !!}

  <h1>Profession Subcategories</h1>

  <p>This is a list of profession subcategories that will be used to sort professions on the profession page. Creating profession
    subcategories is entirely optional, but recommended if you want even more clustering of professions.</p>
  <p>The sorting order reflects the order in which the profession subcategories will be displayed on the world pages.</p>

  <div class="text-right mb-3">
    <a class="btn btn-secondary" href="{{ url('admin/data/professions') }}">
      <i class="fas fa-undo-alt mr-2"></i> Back to Professions</a>
    <a class="btn btn-primary" href="{{ url('admin/data/profession-subcategories/create') }}">
      <i class="fas fa-plus"></i> Create New Profession Subcategory</a>
  </div>
  @if (!count($subcategories))
    <p>No profession subcategories found.</p>
  @else
    <table class="table table-sm category-table">
      <tbody id="sortable" class="sortable">
        @foreach ($subcategories as $category)
          <tr class="sort-item" data-id="{{ $category->id }}">
            <td>
              <a class="fas fa-arrows-alt-v handle mr-3" href="#">
              </a>
              {!! $category->displayName !!}
            </td>
            <td class="text-right">
              <a href="{{ url('admin/data/profession-subcategories/edit/' . $category->id) }}" class="btn btn-primary">Edit</a>
            </td>
          </tr>
        @endforeach
      </tbody>

    </table>
    <div class="mb-4">
      {!! Form::open(['url' => 'admin/data/profession-subcategories/sort']) !!}
      {!! Form::hidden('sort', '', ['id' => 'sortableOrder']) !!}
      {!! Form::submit('Save Order', ['class' => 'btn btn-primary']) !!}
      {!! Form::close() !!}
    </div>
  @endif

@endsection

@section('scripts')
  @parent
  <script>
    $(document).ready(function() {
      $('.handle').on('click', function(e) {
        e.preventDefault();
      });
      $("#sortable").sortable({
        items: '.sort-item',
        handle: ".handle",
        placeholder: "sortable-placeholder",
        stop: function(event, ui) {
          $('#sortableOrder').val($(this).sortable("toArray", {
            attribute: "data-id"
          }));
        },
        create: function() {
          $('#sortableOrder').val($(this).sortable("toArray", {
            attribute: "data-id"
          }));
        }
      });
      $("#sortable").disableSelection();
    });
  </script>
@endsection
