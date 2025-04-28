<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('user_local_settings', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->integer('user_id')->unsigned()->default(1);
      $table->boolean('high_contrast')->default(0);
      $table->boolean('reduced_motion')->default(0);
      $table->boolean('light_dark')->default(0);
      $table->string('site_font')->nullable()->default(null);
      $table->string('theme')->nullable()->default(null);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('user_local_settings');
  }
};
