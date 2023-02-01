@extends('admin.layout')

@section('admin-title') Mod Mail (#{{$mail->id}}) @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', 'Mod Mail' => 'admin/mail', 'Mail #'.$mail->id => 'admin/mail/'.$mail->id]) !!}

<h1>Mod Mail (#{{$mail->id}})</h1>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Subject: {{$mod->subject}}</h3>
    </div>
    <div class="card-body">
        @if(Auth::check() && Auth::user()->isStaff)
            <p>From: {{$mod->staff->displayName}} {{ add_help('Not viewable by users.') }}</p>
        @endif
        <p>To: {{$mod->user->displayName}}</p>
        <p>{{$mod->message}}</p>
    </div>
</div>
@endsection
