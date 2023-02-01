@extends('admin.layout')

@section('admin-title') Mod Mail @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', 'Mod Mail' => 'admin/mail']) !!}

<h1>Mod Mail</h1>

<p>Mod Mail can be sent to a user anonymously by staff in order to issue strikes, warnings, information etc. <br> Mail can be used to automatically ban users after a set number of strikes (see the setting "user_strike_count" in <a href="{{ url('admin/settings') }}">Site Settings</a>).</p>

<div class="float-right">
    <a href="{{ url('admin/mail/create') }}" class="btn btn-primary">Send Mail</a>
</div>

@if(!count($mails))
    <p>No mail found.</p>
@else
    {!! $mails->render() !!}

    

    {!! $mails->render() !!}
    <div class="text-center mt-4 small text-muted">{{ $mails->total() }} result{{ $mails->total() == 1 ? '' : 's' }} found.</div>
@endif

@endsection
