@extends('character.design.layout', ['componentName' => 'character/design/comments'])
@section('design-title')
  Request (#{{ $request->id }}) :: Comments
@endsection

@section('design-content')
  {!! breadcrumbs([
      'Design Approvals' => 'designs',
      'Request (#' . $request->id . ')' => 'designs/' . $request->id,
      'Comments' => 'designs/' . $request->id . '/comments'
  ]) !!}

  @include('character.design._header', ['request' => $request])

  <div class="card">
    <div class="card-body tab-content br-ntl-15">
      <h2>Comments</h2>

      @if ($request->status == 'Draft' && $request->user_id == Auth::user()->id)
        <p>Enter an optional comment about your submission that staff will review when processing your request.
          <br>If you don't have a comment, just click the <b>Save</b> button once to mark this section complete!
        </p>
        <hr>
        <p class="text-secondary">In the event that your design gets rejected, I (wyspic) find providing a redline/drawover to be the
          most efficient and clear way to communicate what changes or corrections may need to be made.</p>
        <p class="text-secondary">However, I know not everyone is comfortable with having their art drawn over! If you would like to
          <b>opt out</b> of receiving a drawover for assistance with any rejection notes, add "No Redlining" to your comment. </p>
        <hr>
        {!! Form::open(['url' => 'designs/' . $request->id . '/comments']) !!}
        <div class="form-group">
          <h3> {!! Form::label('Comments (Optional)') !!}</h3>
          {!! Form::textarea('comments', $request->comments, ['class' => 'form-control']) !!}
        </div>
        <div class="text-right">
          {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
      @else
        <div class="card">
          <div class="card-body">
            {!! nl2br(htmlentities($request->comments)) !!}
          </div>
        </div>
    </div>
  </div>
  @endif
@endsection
