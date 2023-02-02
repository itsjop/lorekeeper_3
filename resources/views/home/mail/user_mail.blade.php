@extends('home.layout')

@section('home-title') Message (#{{ $mail->id }}) @endsection

@section('home-content')

{!! breadcrumbs(['Inbox' => 'inbox', 'Message (#' . $mail->id . ')' => $mail->viewUrl]) !!}

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <h3>Mail #{{ $mail->id }} - {{ $mail->subject }}</h3>
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

@comments(['model' => $mail,
        'perPage' => 5
    ])

@endsection