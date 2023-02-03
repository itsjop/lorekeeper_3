@extends('home.layout')

@section('home-title') Message (#{{ $mail->id }}) @endsection

@section('home-content')

{!! breadcrumbs(['Inbox' => 'inbox', $mail->displayName . ' from ' . $mail->sender->displayName => $mail->viewUrl]) !!}

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <h3>Mail #{{ $mail->id }} - {!! $mail->displayName !!}</h3>
            </div>
            <div class="col-6 text-right">
               <h5>Sent {!! pretty_date($mail->created_at) !!}</h5>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="card-text">
            {{ $mail->message }}
        </div>
    </div>
</div>

<br>

@if(Auth::user()->id != $mail->sender_id)
{!! Form::open(['url' => 'inbox/new']) !!}

<div class="form-group">
    {!! Form::label('message', 'Reply') !!}
    {!! Form::textarea('message', null, ['class' => 'form-control']) !!}
</div>

{{ Form::hidden('parent_id', $mail->id) }}
{{ Form::hidden('subject', $mail->subject) }}
{{ Form::hidden('recipient_id', $mail->sender_id) }}

<div class="text-right">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
</div>

{!! Form::close() !!}
@endif

@endsection