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

<div class="text-right mb-3">
  <a href="#" class="btn btn-outline-info" id="addLoot">
    Add {{ isset($progression) && $progression ? 'Progression' : 'Reward' }}
  </a>

</div>
<table class="table table-sm" id="lootTable">
  <thead>
    <tr>
      <th width="35%">{{ isset($progression) && $progression ? 'Progression' : 'Reward' }}</th>
      <th width="20%">Quantity</th>
      <th width="10%"></th>
    </tr>
  </thead>
  <tbody id="lootTableBody">
    @if ($loots)
      @foreach ($loots as $loot)
        <tr class="loot-row">
          <td>{!! Form::select(
              'rewardable_type[]',
              ['Item' => 'Item', 'Currency' => 'Currency', 'Pet' => 'Pet', 'Award' => ucfirst(__('awards.award'))] +
                  (isset($showLootTables) && $showLootTables ? ['LootTable' => 'Loot Table'] : []) +
                  (isset($showRaffles) && $showRaffles ? ['Raffle' => 'Raffle Ticket'] : []) +
                  (isset($showBorders) && $showBorders ? ['Border' => 'Border'] : []) +
                  (isset($showRecipes) && $showRecipes ? ['Recipe' => 'Recipe'] : []),
              isset($progression) && $progression ? $loot->type : $loot->rewardable_type,
              [
                  'class' => 'form-control reward-type',
                  'placeholder' => isset($progression) && $progression ? 'Select Progression Type' : 'Select Reward Type',
              ],
          ) !!}</td>
          <td class="loot-row-select">
            @if ($loot->rewardable_type == 'Item')
              {!! Form::select('rewardable_id[]', $items, $loot->rewardable_id, [
                  'class' => 'form-control item-select selectize',
                  'placeholder' => 'Select Item',
              ]) !!}
            @elseif($loot->rewardable_type == 'Currency')
              {!! Form::select('rewardable_id[]', $currencies, $loot->rewardable_id, [
                  'class' => 'form-control currency-select selectize',
                  'placeholder' => 'Select Currency',
              ]) !!}
            @elseif($loot->rewardable_type == 'Pet')
              {!! Form::select('rewardable_id[]', $pets, $loot->rewardable_id, [
                  'class' => 'form-control pet-select selectize',
                  'placeholder' => 'Select Pet',
              ]) !!}
            @elseif($loot->rewardable_type == 'Award')
              {!! Form::select('rewardable_id[]', $awards, $loot->rewardable_id, [
                  'class' => 'form-control award-select selectize',
                  'placeholder' => 'Select ' . ucfirst(__('awards.award')),
              ]) !!}
            @elseif($showLootTables && $loot->rewardable_type == 'LootTable')
              {!! Form::select('rewardable_id[]', $tables, $loot->rewardable_id, [
                  'class' => 'form-control table-select selectize',
                  'placeholder' => 'Select Loot Table',
              ]) !!}
            @elseif($showRaffles && $loot->rewardable_type == 'Raffle')
              {!! Form::select('rewardable_id[]', $raffles, $loot->rewardable_id, [
                  'class' => 'form-control raffle-select selectize',
                  'placeholder' => 'Select Raffle',
              ]) !!}
            @elseif(isset($showBorders) && $showBorders && $loot->rewardable_type == 'Border')
              {!! Form::select('rewardable_id[]', $borders, $loot->rewardable_id, [
                  'class' => 'form-control border-select selectize',
                  'placeholder' => 'Select Border',
              ]) !!}
            @elseif($showRecipes && $loot->rewardable_type == 'Recipe')
              {!! Form::select('rewardable_id[]', $recipes, $loot->rewardable_id, [
                  'class' => 'form-control recipe-select selectize',
                  'placeholder' => 'Select Recipe',
              ]) !!}
            @endif
          </td>
          <td>{!! Form::text('quantity[]', $loot->quantity, ['class' => 'form-control']) !!}</td>
          <td class="text-right">
            <a href="#" class="btn btn-danger remove-loot-button">Remove</a>
          </td>
        </tr>
      @endforeach
    @endif
  </tbody>
</table>
