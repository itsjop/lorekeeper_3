@if ($raffle->logs->count() && $raffle->logs()->where('type', 'Reward')->get()->count() && Auth::check() && Auth::user()->isStaff)
  <div class="card mb-3 mt-3">
    <div class="card-header h3"> Users Rewarded </div>
    <div class="table-responsive">
      <table class="table table-sm mb-0 px-2">
        <thead>
          <th> User </th>
          <th> Date </th>
        </thead>
        <tbody>
          @foreach ($raffle->logs()->where('type', 'Reward')->orderBy('created_at', 'DESC')->get() as $log)
            <tr>
              <td> {!! $log->user->displayName !!} </td>
              <td> {!! pretty_date($log->created_at) !!} </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endif
@if ($raffle->logs->count() && $raffle->logs()->where('type', 'Reroll')->get()->count())
  <div class="card mb-3 mt-3">
    <div class="card-header h3"> Raffle Changelog </div>
    <div class="table-responsive">
      <table class="table table-sm mb-0 px-2">
        <thead>
          <th> Winner Rerolled </th>
          <th> Staff </th>
          <th> Reason </th>
          <th> Date </th>
        </thead>
        <tbody>
          @foreach ($raffle->logs()->where('type', 'Reroll')->orderBy('created_at', 'DESC')->get() as $log)
            <tr>
              <td> {!! $log->ticket->displayHolderName !!} </td>
              <td> {!! $log->user->displayName !!} </td>
              <td> {!! $log->reason !!} </td>
              <td> {!! pretty_date($log->created_at) !!} </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endif
