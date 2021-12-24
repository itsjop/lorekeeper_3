@if($raffle->logs->count())
<div class="card mb-3">
    <div class="card-header h3">Raffle Changelog</div>
        <div class="table-responsive">
            <table class="table table-sm mb-0">
                <thead>
                    <th>Winner Rerolled</th>
                    <th>Staff</th>
                    <th>Reason</th>
                    <th>Date</th>
                </thead>
                <tbody>
                    @foreach($raffle->logs()->orderBy('created_at', 'DESC')->get() as $log)
                        <tr>
                            <td>{!! $log->ticket->displayHolderName !!}</td>
                            <td>{!! $log->user->displayName !!}</td>
                            <td>{!! $log->reason !!}</td>
                            <td>{!! pretty_date($log->created_at) !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif