@extends('admin.layout', ['componentName' => 'admin/worldexpansion/create-edit-figure'])

@section('admin-title')
  Figure
@endsection

@section('admin-content')
  {!! breadcrumbs(['Admin Panel' => 'admin', 'Figures' => 'admin/world/figures', ($figure->id ? 'Edit' : 'Create') . ' Figure' => $figure->id ? 'admin/world/figures/edit/' . $figure->id : 'admin/world/figures/create']) !!}

  <h1>{{ $figure->id ? 'Edit' : 'Create' }} Figure
    @if ($figure->id)
      ({!! $figure->displayName !!})
      <a href="#" class="btn btn-danger float-right delete-figure-button">Delete Figure</a>
    @endif
  </h1>

  {!! Form::open(['url' => $figure->id ? 'admin/world/figures/edit/' . $figure->id : 'admin/world/figures/create', 'files' => true]) !!}

  <div class="card mb-3">
    <h2 class="card-header h3">Basic Information</h2>
    <div class="card-body">

      <div class="row mx-0 px-0">
        <div class="form-group col-md px-0 pr-md-1">
          {!! Form::label('Name') !!}
          {!! Form::text('name', $figure->name, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md px-0 pl-md-1">
          {!! Form::label('Category') !!} {!! add_help('What type of figure is this?') !!}
          {!! Form::select('category_id', [0 => 'Choose a Category'] + $categories, $figure->category_id, ['class' => 'form-control selectize', 'id' => 'category']) !!}
        </div>
      </div>

      <div class="form-group">
        {!! Form::label('Summary (Optional)') !!}
        {!! Form::text('summary', $figure->summary, ['class' => 'form-control']) !!}
      </div>

      <div class="row no-gutters ">
        <div class="form-group col-md px-0 pr-md-1">
          {!! Form::label('birth_date', 'Birth Date (Optional)') !!}
          {!! Form::text('birth_date', $figure->birth_date, ['class' => 'form-control datepicker']) !!}
        </div>
        <div class="form-group col-md px-0 pl-md-1">
          {!! Form::label('death_date', 'Death Date (Optional)') !!}
          {!! Form::text('death_date', $figure->death_date, ['class' => 'form-control datepicker']) !!}
        </div>
      </div>

      <div class="form-group mb-0">
        {!! Form::label('faction_id', 'Faction (Optional)') !!} {!! add_help(
            'This will set the figure as a member of this faction. To associate this figure with a faction without being a part of it, edit the faction instead. Changing this will remove this figure from any special ranks in their existing faction.',
        ) !!}
        {!! Form::select('faction_id', [0 => 'Choose a Faction'] + $factions, $figure->faction_id, ['class' => 'form-control selectize', 'id' => 'category']) !!}
      </div>
    </div>
  </div>

  <div class="card mb-3">
    <h2 class="card-header h3">Images</h2>
    <div class="card-body row">
      <div class="form-group col-md-6">
        @if ($figure->thumb_extension)
          <a href="{{ $figure->thumbUrl }}" data-lightbox="entry" data-title="{{ $figure->name }}">
            <img src="{{ $figure->thumbUrl }}" class="mw-100 float-left mr-3" style="max-height:125px"></a>
        @endif
        {!! Form::label('Thumbnail Image (Optional)') !!} {!! add_help('This thumbnail is used on the figure index.') !!}
        <div>{!! Form::file('image_th') !!}</div>
        <div class="text-muted">Recommended size: 200x200</div>
        @if (isset($figure->thumb_extension))
          <div class="form-check">
            {!! Form::checkbox('remove_image_th', 1, false, ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'data-off' => 'Leave Thumbnail As-Is', 'data-on' => 'Remove Thumbnail Image']) !!}
          </div>
        @endif
      </div>

      <div class="form-group col-md-6">
        @if ($figure->image_extension)
          <a href="{{ $figure->imageUrl }}" data-lightbox="entry" data-title="{{ $figure->name }}">
            <img src="{{ $figure->imageUrl }}" class="mw-100 float-left mr-3" style="max-height:125px"></a>
        @endif
        {!! Form::label('Figure Image (Optional)') !!} {!! add_help('This image is used on the figure page as a header.') !!}
        <div>{!! Form::file('image') !!}</div>
        <div class="text-muted">Recommended size: None (Choose a standard size for all figure header images.)</div>
        @if (isset($figure->image_extension))
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
        {!! Form::textarea('description', $figure->description, ['class' => 'form-control wysiwyg']) !!}
      </div>
    </div>
  </div>

  @if ($figure->id)
    <div class="card mb-3">
      <h2 class="card-header h3">
        <div class="float-right">
          <a href="#" class="btn btn-sm btn-primary" id="addAttachment">Add Attachment</a>
        </div>
        Attachments
      </h2>
      <div class="card-body">
        @include('widgets._attachment_select', ['attachments' => $figure->attachments])
      </div>
      @if ($figure->attachers->count())
        <div class="card-footer">
          <div class="h5">Attached to the following</div>
          <div class="row">
            @foreach ($figure->attachers->groupBy('attacher_type') as $type => $attachers)
              <div class="col-6 col-md-3">
                <div class="card">
                  <div class="card-body p-2 text-center">
                    <div><strong>{!! $type !!}</strong> <small>({{ $attachers->count() }})</small></div>
                    <p class="mt-2 mb-1">
                      @foreach ($attachers as $attacher)
                        {!! $attacher->attacher->displayName !!}
                        {{ !$loop->last ? ', ' : '' }}
                      @endforeach
                    </p>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif
    </div>
  @endif


  <div class="form-group">
    {!! Form::checkbox('is_active', 1, $figure->id ? $figure->is_active : 1, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
    {!! Form::label('is_active', 'Set Active', ['class' => 'form-check-label ml-3']) !!} {!! add_help('If turned off, the category will not be visible to regular users.') !!}
  </div>

  <div class="text-right">
    {!! Form::submit($figure->id ? 'Edit' : 'Create', ['class' => 'btn btn-primary']) !!}
  </div>

  {!! Form::close() !!}

  @include('widgets._attachment_select_row')

@endsection

@section('scripts')
  @parent
  @include('js._attachment_js')
  <script>
    $(document).ready(function() {
      $('.delete-figure-button').on('click', function(e) {
        e.preventDefault();
        loadModal("{{ url('admin/world/figures/delete') }}/{{ $figure->id }}", 'Delete Figure');
      });
      $('.selectize').selectize();

      $(".datepicker").datetimepicker({
        dateFormat: "yy-mm-dd",
        timeFormat: '',
      });
    });
  </script>
@endsection
