<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCharacterWarningToCharacterImages extends Migration {
  /**
   * Run the migrations.
   */
  public function up() {
    Schema::table('character_images', function (Blueprint $table) {
      //
      $table->json('content_warnings')->nullable()->default(null);
    });

    Schema::table('user_settings', function (Blueprint $table) {
      $table->tinyInteger('content_warning_visibility')->default(0);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down() {
    dropColumnIfExists('character_images', 'content_warnings');
    dropColumnIfExists('user_settings', 'content_warning_visibility');
  }
}
