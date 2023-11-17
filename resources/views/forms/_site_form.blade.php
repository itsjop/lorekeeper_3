<div class="card mb-3">
    <div class="card-header">
        <h2 class="card-title mb-0">
            {!! $form->displayName !!}

        </h2>
        <div class="h5">
            <span class="badge bg-warning border">
                @if($form->is_anonymous)
                This form is anonymous {!! add_help('Staff will be unable to see your answers, however, the site owners may still access this information through the database.') !!}
                @else
                This form is not anonymous. {!! add_help('Staff will be able to easily see your answers.') !!}
                @endif
            </span>
        </div>
        <small>
            Posted {!! $form->post_at ? pretty_date($form->post_at) : pretty_date($form->created_at) !!} :: Last edited {!! pretty_date($form->updated_at) !!} by {!! $form->user->displayName !!}
        </small>
    </div>
    <div class="card-body">
        <div class="parsed-text">
            {!! $form->parsed_description !!}
        </div>
        {!! Form::open(['url' => 'forms/send']) !!}

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
            {!! Form::text($question->id, null, ['class' => 'form-control']) !!}
            @endif
            @endforeach

        </div>
        <div class="text-right mt-2">
            {!! Form::submit('Send', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>