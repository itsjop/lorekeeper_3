@extends('admin.layout')

@section('admin-title')
  Professions
@endsection

@section('admin-content')
  {!! breadcrumbs(['Admin Panel' => 'admin', 'Professions' => 'admin/data/professions']) !!}

  <h1>Professions</h1>

  <p>This is a list of professions that can be attached to characters. These professions can be freely chosen by the user on their
    profile.
    You can sort within a category or with all professions visible, <b>but sorting within subcategories will lead to weird
      results.</b> </p>

  <div class="text-right mb-3">
    <a class="btn btn-primary" href="{{ url('admin/data/profession-categories') }}">
      <i class="fas fa-folder">
      </i> Profession Categories</a>
    <a class="btn btn-primary" href="{{ url('admin/data/profession-subcategories') }}">
      <i class="fas fa-folder">
      </i> Profession Subcategories</a>
    <a class="btn btn-primary" href="{{ url('admin/data/professions/create') }}">
      <i class="fas fa-plus">
      </i> Create New Profession</a>
  </div>

  <div>
    {!! Form::open(['method' => 'GET', 'class' => 'form-inline justify-content-end']) !!}
    <div class="form-group mr-3 mb-3">
      {!! Form::text('name', Request::get('name'), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
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

  @if (!count($professions))
    <p>No professions found.</p>
  @else
    <table class="table table-sm category-table">
      <thead>
        <tr>
          <th scope="col">Name</th>
          <th scope="col">Category</th>
          <th scope="col">Subcategory</th>
          <th scope="col">Species</th>
        </tr>
      </thead>
      <tbody id="sortable" class="sortable">
        @foreach ($professions as $profession)
          <tr class="sort-item" data-id="{{ $profession->id }}">
            <td>
              <a class="fas fa-arrows-alt-v handle mr-3" href="#">
              </a>
              {!! $profession->name !!}
            </td>
            <td>
              {{ $profession->category ? $profession->category->name : '---' }}
            </td>
            <td>
              {{ $profession->subcategory ? $profession->subcategory->name : '---' }}
            </td>
            <td>
              {{ $profession->category->species ? $profession->category->species->name : '---' }}
            </td>
            <td class="text-right">
              <a href="{{ url('admin/data/professions/edit/' . $profession->id) }}" class="btn btn-primary py-0 px-1">Edit</a>
            </td>
          </tr>
        @endforeach
      </tbody>

    </table>
    <div class="mb-4">
      {!! Form::open(['url' => 'admin/data/professions/sort']) !!}
      {!! Form::hidden('sort', '', ['id' => 'sortableOrder']) !!}
      {!! Form::submit('Save Order', ['class' => 'btn btn-primary']) !!}
      {!! Form::close() !!}
    </div>
    <div class="text-center mt-4 small text-muted">{{ $professions->count() }} result{{ $professions->count() == 1 ? '' : 's' }}
      found.</div>
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
