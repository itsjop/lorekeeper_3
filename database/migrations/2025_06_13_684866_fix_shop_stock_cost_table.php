<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {

    Schema::table('shop_stock_costs', function (Blueprint $table) {
      $table->dropColumn('currency_id');
    });


    Schema::table('shop_stock', function (Blueprint $table) {
      dropColumnIfExists('shop_stock', 'cost');
      dropColumnIfExists('shop_stock', 'currency_id');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::table('shop_stock_costs', function (Blueprint $table) {
      $table->integer('currency_id')->unsigned();
    });

    Schema::table('shop_stock', function (Blueprint $table) {
      $table->integer('currency_id')->unsigned();
      $table->integer('cost');
    });

  }
};
