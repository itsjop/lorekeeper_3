<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSellableTablesForItemCategory extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::table('item_categories', function (Blueprint $table) {
      if (!doesColumnExist('item_categories', 'can_user_sell'))
        $table->boolean('can_user_sell')->default(0);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    dropColumnIfExists('item_categories', 'can_user_sell');
  }
}
