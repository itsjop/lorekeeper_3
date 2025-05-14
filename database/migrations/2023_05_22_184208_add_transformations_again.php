<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransformationsAgain extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('character_transformations', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->string('name');
      $table->boolean('has_image')->default(0);
      $table->integer('sort')->unsigned()->default(0);
      $table->text('description')->nullable()->default(null);
      $table->text('parsed_description')->nullable()->default(null);
    });

    Schema::table('character_images', function (Blueprint $table) {
      $table->integer('transformation_id')->unsigned()->nullable()->default(null);
    });

    Schema::table('design_updates', function (Blueprint $table) {
      $table->integer('transformation_id')->unsigned()->nullable()->default(null);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('character_transformations');
    dropColumnIfExists('character_images', 'transformation_id');
    dropColumnIfExists('design_updates', 'transformation_id');
  }
}
