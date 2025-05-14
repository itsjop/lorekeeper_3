<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFullsizeHashToCharacterImages extends Migration {
  /**
   * Run the migrations.
   */
  public function up() {
    // To prevent people from scraping URLs

    if (!Schema::hasTable('character_images')) {
      Schema::create('character_images', function (Blueprint $table) {
        $table->engine = 'InnoDB';
        $table->string('fullsize_hash', 20);
      });
    } else {
      Schema::table('character_images', function (Blueprint $table) {
        $table->string('fullsize_hash', 20);
      });
    }
    if (!Schema::hasTable('design_updates')) {
      Schema::create('design_updates', function (Blueprint $table) {
        $table->engine = 'InnoDB';
        $table->string('fullsize_hash', 20);
      });
    } else {
      Schema::table('design_updates', function (Blueprint $table) {
        $table->string('fullsize_hash', 20);
      });
    }
  }

  /**
   * Reverse the migrations.
   */
  public function down() {
    dropColumnIfExists('character_images', 'fullsize_hash');
    dropColumnIfExists('design_updates', 'fullsize_hash');
  }
}
