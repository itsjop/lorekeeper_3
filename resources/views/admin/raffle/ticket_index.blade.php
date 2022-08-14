@extends('admin.layout')

@section('admin-title') Raffle Tickets for {{ $raffle->name }} @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', 'Raffle Index' => 'admin/raffles', 'Raffle Tickets for ' . $raffle->name => 'admin/raffles/view/'.$raffle->id]) !!}

<h1>Raffle Tickets: {{ $raffle->name }} {{ $raffle->is_fto ? ' (FTO / Non-Owner Only)' : '' }}</h1>

@if($raffle->is_active == 0)
    <p>This raffle is currently hidden. (Number of winners to be drawn: {{ $raffle->winner_count }})</p>
    @if($raffle->end_at)
        @if($raffle->end_at < Carbon\Carbon::now())
            <div class="alert alert-danger mb-2">This raffle has closed.</div>
        @else
            <div class="alert alert-warning mb-2">This raffle will close {{ $raffle->end_at->format('F j, Y g:i A') }}.</div>
        @endif
    @endif
    <div class="text-right form-group">
        <a class="btn btn-success edit-tickets" href="#" data-id="">Add Tickets</a>
    </div>
@elseif($raffle->is_active == 1)
    <p>This raffle is currently open. (Number of winners to be drawn: {{ $raffle->winner_count }})</p>
    @if($raffle->end_at)
        @if($raffle->end_at < Carbon\Carbon::now())
            <div class="alert alert-warning mb-2">This raffle has closed.</div>
        @else
            <div class="alert alert-warning mb-2">This raffle will close {{ $raffle->end_at->format('F j, Y g:i A') }}.</div>
        @endif
    @endif
    <div class="text-right form-group">
        <a class="btn btn-success edit-tickets" href="#" data-id="">Add Tickets</a>
    </div>
@elseif($raffle->is_active == 2)
    <p>This raffle is closed. Rolled: {!! format_date($raffle->rolled_at) !!}</p>
    <div class="card mb-3">
        <div class="card-header h3">Winner(s)</div>
        <div class="table-responsive">
            <table class="table table-sm mb-0">
                <thead><th class="col-xs-1 text-center" style="width:100px;">#</th><th>User</th><th></th></thead>
                <tbody>
                    @foreach($raffle->tickets()->winners()->get() as $winner)
                        <tr>
                            <td class="text-center">{{ $winner->position }}</td>
                            <td class="text-left">{!! $winner->displayHolderName !!} @if($winner->reroll)<span class="text-danger">(Reroll)</span>@endif</td>
                            <td class="text-right"><div class="btn btn-primary btn-sm reroll" value="{{ $winner->id }}">Reroll?</div></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

<h3>Tickets</h3>

<div class="text-right">{!! $tickets->render() !!}</div>
<div class="table-responsive">
    <table class="table table-sm">
        <thead><th class="col-xs-1 text-center" style="width:100px;">#</th><th>User</th>@if($raffle->is_active < 2)<th></th>@endif</thead>
        <tbody>
            @foreach($tickets as $count=>$ticket)
                <tr>
                    <td class="text-center">{{ $page * 200 + $count + 1 }}</td>
                    <td>{!! $ticket->displayHolderName !!}</td>
                    @if($raffle->is_active < 2)
                        <td class="text-right">{!! Form::open(['url' => 'admin/raffles/view/ticket/delete/'.$ticket->id]) !!}{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}{!! Form::close() !!}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="text-right">{!! $tickets->render() !!}</div>

<div class="modal fade" id="raffle-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title h5 mb-0">Add Tickets</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {!! Form::open(['url' => 'admin/raffles/view/ticket/'.$raffle->id]) !!}
                    <div class="form-group">
                    {!! Form::label('names', 'Names (comma-separated, one name per ticket)') !!} {!! add_help('Names will be matched to usernames on the site. If a matching username is not found, it will add a ticket as a deviantART username instead.') !!}
                        {!! Form::textarea('names', '', ['class' => 'form-control']) !!}
                    </div>
                    <div class="text-right">
                        {!! Form::submit('Add', ['class' => 'btn btn-primary']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@include('raffles._logs', ['raffle' => $raffle])

@endsection
@section('scripts')
@parent
<script>
    $('.reroll').on('click', function(e) {
        e.preventDefault();
        // get value
        var id = $(this).attr('value');
        loadModal("{{ url('/admin/raffles/edit/reroll') }}/" + id, 'Reroll Ticket');
    });
    $('.edit-tickets').on('click', function(e) {
        e.preventDefault();
        $('#raffle-modal').modal('show');
    });
</script>
@endsection