@extends('home.layout')

@section('home-title') Mod Mail @endsection

@section('home-content')

{!! breadcrumbs(['Mod Mail' => 'mail']) !!}


<h1>
    Received Mod Mail
</h1>



@if(count($mails))
    <div class="row ml-md-2">
        <div class="d-flex row flex-wrap col-12 mt-1 pt-1 px-0 ubt-bottom">
            <div class="col-12 col-md-2 font-weight-bold">Subject</div>
            <div class="col-6 col-md-3 font-weight-bold">Message</div>
            <div class="col-6 col-md-4 font-weight-bold">Sent</div>
            <div class="col-6 col-md-2 font-weight-bold">Seen</div>
            <div class="col-12 col-md-1 font-weight-bold">Details</div>
        </div>

        @foreach($mails as $mail)
            <div class="d-flex row flex-wrap col-12 mt-1 pt-1 px-0 ubt-top">
                <div class="col-12 col-md-2">{{ $mail->subject }}</div>
                <div class="col-6 col-md-3">
                    <span class="ubt-texthide">{{ Illuminate\Support\Str::limit($mail->message, 50, $end='...') }}</span>
                </div>
                <div class="col-6 col-md-4">{!! pretty_date($mail->created_at) !!}</div>
                <div class="col-6 col-md-2">{!! $mail->seen ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</div>
                <div class="col-12 col-md-1">
                    <a href="{{ $mail->viewUrl }}" class="btn btn-primary btn-sm py-0 px-1">Details</a>
                </div>
            </div>
      @endforeach
      </div>
    <div class="text-center mt-4 small text-muted">{{ $mails->count() }} result{{ $mails->count() == 1 ? '' : 's' }} found.</div>
@else
    <p>No mail found.</p>
@endif

@endsection
