<div class="card">
    <h2 class="card-header">Prompt Rewards</h2>
      <div class="card-body">

    @if (isset($staffView) && $staffView)
      <p>For reference, these are the default rewards for this prompt. The editable section above is <u>inclusive</u> of these rewards.</p>
      @if ($count)
        <p>This user has completed this prompt <strong>{{ $count }}</strong> time{{ $count == 1 ? '' : 's' }}.</p>
      @endif
    @else
      <p>These are the rewards given for completeing this prompt.</p>
      @if ($count)
        <p>You have completed this prompt <strong>{{ $count }}</strong> time{{ $count == 1 ? '' : 's' }}.</p>
      @endif
    @endif
    <table class="table table-sm mb-0">
      <thead>
        <tr>
          <th width="70%">Reward</th>
          <th width="30%">Amount</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($prompt->rewards as $reward)
          <tr>
            <td>{!! $reward->reward->displayName !!}</td>
            <td>{{ $reward->quantity }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @if (count(getLimits($prompt)))
    <div class="card-footer">
      @include('widgets._limits', ['object' => $prompt])
    </div>
  @endif
</div>
