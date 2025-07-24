@extends('layouts.app', ['pageName' => '/banned'])

@section('title')
  Banned
@endsection

@section('content')
  {!! breadcrumbs(['Banned' => 'banned']) !!}

  <h1>Banned</h1>

  <p>You are banned from site activities effective {!! format_date(Auth::user()->settings->banned_at) !!}.
    {{ Auth::user()->settings->ban_reason ? 'The following reason was given:' : '' }}</p>

  @if (Auth::user()->settings->ban_reason)
    <div class="alert alert-danger">
      {!! nl2br(htmlentities(Auth::user()->settings->ban_reason)) !!}
    </div>
  @endif

  @if ($unreadModMail->count())
    <div class="text-right mb-3">
      <div
        class="btn btn-outline-info btn-sm"
        data-toggle="collapse"
        href="#unreadMail"
        role="button"
        aria-expanded="false"
        aria-controls="collapseExample"
      >Read Unread Mod Mail</div>
    </div>
    <div class="card collapse" id="unreadMail">
      @foreach ($unreadModMail as $mail)
        <div class="card-body pb-1">
          <h5>{{ $mail->subject }}</h5>
          {!! $mail->message !!}
        </div>
      @endforeach
    </div>
  @endif

  <p class="mt-3">As such, you may not continue to to use site features. Items, currencies, characters and any other assets
    attached to your account cannot be transferred to another user, nor can another user transfer any assets to your account. Any
    pending
    submissions have also been removed from the submission queue. </p>
  <p>Contact a staff member if you feel this decision has been made in error, but please respect their final judgement on the
    matter.</p>
@endsection
