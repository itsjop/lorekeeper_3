<script>
  $(document).ready(function() {
    var $lootTable = $('#lootTableBody');
    var $lootRow = $('#lootRow').find('.loot-row');
    var $itemSelect = $('#lootRowData').find('.item-select');
    var $currencySelect = $('#lootRowData').find('.currency-select');
    var $petSelect = $('#lootRowData').find('.pet-select');
    var $awardSelect = $('#lootRowData').find('.award-select');
    @if (isset($showLootTables) && $showLootTables)
      var $tableSelect = $('#lootRowData').find('.table-select');
    @endif
    @if (isset($showRaffles) && $showRaffles)
      var $raffleSelect = $('#lootRowData').find('.raffle-select');
    @endif
    @if (isset($showBorders) && $showBorders)
      var $borderSelect = $('#lootRowData').find('.border-select');
    @endif
    @if (isset($showRecipes) && $showRecipes)
      var $recipeSelect = $('#lootRowData').find('.recipe-select');
    @endif

    $('#lootTableBody .selectize').selectize();
    attachRemoveListener($('#lootTableBody .remove-loot-button'));

    $('#addLoot').on('click', function(e) {
      e.preventDefault();
      var $clone = $lootRow.clone();
      $lootTable.append($clone);
      attachRewardTypeListener($clone.find('.reward-type'));
      attachRemoveListener($clone.find('.remove-loot-button'));
    });

    $('.reward-type').on('change', function(e) {
      var val = $(this).val();
      var $cell = $(this).parent().parent().find('.loot-row-select');

      var $clone = null;
      if (val == 'Item') $clone = $itemSelect.clone();
      else if (val == 'Currency') $clone = $currencySelect.clone();
      else if (val == 'Award') $clone = $awardSelect.clone();
      else if (val == 'Pet') $clone = $petSelect.clone();
      @if (isset($showLootTables) && $showLootTables)
        else if (val == 'LootTable') $clone = $tableSelect.clone();
      @endif
      @if (isset($showRaffles) && $showRaffles)
        else if (val == 'Raffle') $clone = $raffleSelect.clone();
      @endif
      @if (isset($showBorders) && $showBorders)
        else if (val == 'Border') $clone = $borderSelect.clone();
      @endif
      @if (isset($showRecipes) && $showRecipes)
        else if (val == 'Recipe') $clone = $recipeSelect.clone();
      @endif

      $cell.html('');
      $cell.append($clone);
    });

    function attachRewardTypeListener(node) {
      node.on('change', function(e) {
        var val = $(this).val();
        var $cell = $(this).parent().parent().find('.loot-row-select');

        var $clone = null;
        if (val == 'Item') $clone = $itemSelect.clone();
        else if (val == 'Pet') $clone = $petSelect.clone();
        else if (val == 'Currency') $clone = $currencySelect.clone();
        else if (val == 'Award') $clone = $awardSelect.clone();
        @if ($showLootTables)
          else if (val == 'LootTable') $clone = $tableSelect.clone();
        @endif
        @if ($showRaffles)
          else if (val == 'Raffle') $clone = $raffleSelect.clone();
        @endif
        @if (isset($showBorders) && $showBorders)
          else if (val == 'Border') $clone = $borderSelect.clone();
        @endif

        $cell.html('');
        $cell.append($clone);
        $clone.selectize();
      });
    }

    function attachRemoveListener(node) {
      node.on('click', function(e) {
        e.preventDefault();
        $(this).parent().parent().remove();
      });
    }

  });
</script>
