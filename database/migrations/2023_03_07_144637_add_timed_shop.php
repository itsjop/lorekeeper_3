<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimedShop extends Migration {
  /**
   * Run the migrations.
   */
  public function up() {
    Schema::table('shops', function (Blueprint $table) {
      if (!doesColumnExist('shops', 'is_timed_shop'))
        $table->boolean('is_timed_shop')->default(false);
      $table->timestamps();
      $table->timestamp('start_at')->nullable()->default(null);
      $table->timestamp('end_at')->nullable()->default(null);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down() {
    dropColumnIfExists('shops', 'is_timed_stock');
    dropColumnIfExists('shops', 'created_at');
    dropColumnIfExists('shops', 'updated_at');
    dropColumnIfExists('shops', 'start_at');
    dropColumnIfExists('shops', 'end_at');
  }
}
