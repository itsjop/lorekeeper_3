{!! Form::open(['url' => 'forms/send/'. $form->id ]) !!}

<div class="border rounded p-4">

    @foreach($form->questions as $question)
    <h5>{{ $question->question }}</h5>
    @if($question->options->count() > 0)
    @foreach($question->options as $option)
    <div class="form-group mb-0">
        <label>{{ Form::radio($question->id, $option->id , true, ['class' => 'mr-1']) }} {{ $option->option }}</label>
    </div>
    @endforeach
    @else
    {!! Form::text($question->id, $question->answers->where('user_id', $user->id)->first()->answer ?? null , ['class' => 'form-control']) !!}
    @endif
    @endforeach

</div>
<div class="text-right mt-2">
    @if($user){!! Form::submit( 'Send' , ['class' => 'btn btn-primary']) !!}
    @else
    You must be logged in to send the form.
    @endif
</div>
{!! Form::close() !!}