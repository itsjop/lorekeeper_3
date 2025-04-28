<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraBorders extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */

  public function up() {
    Schema::table('borders', function (Blueprint $table) {
      $table->integer('parent_id')->unsigned()->nullable()->default(null);
      $table->string('border_type')->default('Default');
      $table->string('artist_id')->nullable();
      $table->string('artist_url')->nullable();
    });

    Schema::table('users', function (Blueprint $table) {
      $table->integer('border_variant_id')->unsigned()->nullable()->default(null);
      $table->integer('bottom_border_id')->unsigned()->nullable()->default(null);
      $table->integer('top_border_id')->unsigned()->nullable()->default(null);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('users', function (Blueprint $table) {
      dropColumnIfExists('users', 'border_variant_id');
      dropColumnIfExists('users', 'bottom_border_id');
      dropColumnIfExists('users', 'top_border_id');
    });
    Schema::table('borders', function (Blueprint $table) {
      dropColumnIfExists('borders', 'artist_alias');
      dropColumnIfExists('borders', 'parent_id');
      dropColumnIfExists('borders', 'border_type');
      dropColumnIfExists('borders', 'artist_url');
    });
  }
}
