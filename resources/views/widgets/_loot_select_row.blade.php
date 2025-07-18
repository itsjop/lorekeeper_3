@php
  // This file represents a common source and definition for assets used in loot_select
  // While it is not per se as tidy as defining these in the controller(s),
  // doing so this way enables better compatibility across disparate extensions
  $characterCurrencies = \App\Models\Currency\Currency::where('is_character_owned', 1)->orderBy('sort_character', 'DESC')->pluck('name', 'id');
  $items = \App\Models\Item\Item::orderBy('name')->pluck('name', 'id');
  $pets = \App\Models\Pet\Pet::orderBy('name')->get()->pluck('fullName', 'id');
  $currencies = \App\Models\Currency\Currency::where('is_user_owned', 1)->orderBy('name')->pluck('name', 'id');
  if (isset($showLootTables) && $showLootTables) {
      $tables = \App\Models\Loot\LootTable::orderBy('name')->pluck('name', 'id');
  }
  if (isset($showRaffles) && $showRaffles) {
      $raffles = \App\Models\Raffle\Raffle::where('rolled_at', null)->where('is_active', 1)->orderBy('name')->pluck('name', 'id');
  }
@endphp

<div id="lootRowData" class="hide">
  <table class="table table-sm">
    <tbody id="lootRow">
      <tr class="loot-row">
        <td>{!! Form::select(
            'rewardable_type[]',
            ['Item' => 'Item', 'Currency' => 'Currency', 'Pet' => 'Pet', 'Award' => ucfirst(__('awards.award'))] +
                (isset($showLootTables) && $showLootTables ? ['LootTable' => 'Loot Table'] : []) +
                (isset($showRaffles) && $showRaffles ? ['Raffle' => 'Raffle Ticket'] : []) +
                (isset($showBorders) && $showBorders ? ['Border' => 'Border'] : []) +
                (isset($showRecipes) && $showRecipes ? ['Recipe' => 'Recipe'] : []),
            null,
            [
                'class' => 'form-control reward-type',
                'placeholder' => isset($progression) && $progression ? 'Select Progression Type' : 'Select Reward Type',
            ],
        ) !!}</td>
        <td class="loot-row-select"></td>
        <td>{!! Form::text('quantity[]', 1, ['class' => 'form-control']) !!}</td>
        <td class="text-right">
          <a href="#" class="btn btn-danger remove-loot-button">Remove</a>
        </td>
      </tr>
    </tbody>
  </table>
  {!! Form::select('rewardable_id[]', $items, null, ['class' => 'form-control item-select', 'placeholder' => 'Select Item']) !!}
  {!! Form::select('rewardable_id[]', $currencies, null, [
      'class' => 'form-control currency-select',
      'placeholder' => 'Select Currency',
  ]) !!}
  @if ($showLootTables)
    {!! Form::select('rewardable_id[]', $tables, null, [
        'class' => 'form-control table-select',
        'placeholder' => 'Select Loot Table',
    ]) !!}
  @endif
  {{-- TODO: 'recipies' is undefined, not sure where its coming from --}}
  {{-- @if ($showRecipes)
      {!! Form::select('rewardable_id[]', $recipes, null, ['class' => 'form-control recipe-select', 'placeholder' => 'Select Recipe']) !!}
  @endif --}}
  @if ($showRaffles)
    {!! Form::select('rewardable_id[]', $raffles, null, [
        'class' => 'form-control raffle-select',
        'placeholder' => 'Select Raffle',
    ]) !!}
  @endif
</div>
