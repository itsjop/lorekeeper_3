<div id="lootRowData" class="hide">
  <table class="table table-sm">
    <tbody id="lootRow">
      <tr class="loot-row">
        <td>{!! Form::text('step[]', 1, ['class' => 'form-control bg-dark text-light']) !!}</td>
        <td>{!! Form::select('rewardable_type[]', ['Item' => 'Item', 'Currency' => 'Currency'] + ($showLootTables ? ['LootTable' => 'Loot Table'] : []) + ($showRaffles ? ['Raffle' => 'Raffle Ticket'] : []), null, [
            'class' => 'form-control reward-type',
            'placeholder' => 'Select Reward Type',
        ]) !!}</td>
        <td class="loot-row-select"></td>
        <td>{!! Form::text('quantity[]', 1, ['class' => 'form-control']) !!}</td>
        <td class="text-right">
          <a href="#" class="btn btn-danger remove-loot-button">Remove</a>
        </td>
      </tr>
    </tbody>
  </table>
  {!! Form::select('rewardable_id[]', $items, null, ['class' => 'form-control item-select', 'placeholder' => 'Select Item']) !!}
  {!! Form::select('rewardable_id[]', $currencies, null, ['class' => 'form-control currency-select', 'placeholder' => 'Select Currency']) !!}
  @if ($showLootTables)
    {!! Form::select('rewardable_id[]', $tables, null, ['class' => 'form-control table-select', 'placeholder' => 'Select Loot Table']) !!}
  @endif
  @if ($showRaffles)
    {!! Form::select('rewardable_id[]', $raffles, null, ['class' => 'form-control raffle-select', 'placeholder' => 'Select Raffle']) !!}
  @endif
</div>
