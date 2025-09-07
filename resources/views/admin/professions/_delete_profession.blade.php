@if ($profession)
  {!! Form::open(['url' => 'admin/data/professions/delete/' . $profession->id]) !!}

  <p> You are about to delete the profession <strong> {{ $profession->name }} </strong>. This is not reversible. If characters possessing this profession exist, you will not be able to delete this profession. </p>
  <p> Are you sure you want to delete <strong> {{ $profession->name }} </strong>?</p>

  <div class="text-right">
    {!! Form::submit('Delete Profession', ['class' => 'btn btn-danger']) !!}
  </div>

  {!! Form::close() !!}
@else
  Invalid profession selected.
@endif
