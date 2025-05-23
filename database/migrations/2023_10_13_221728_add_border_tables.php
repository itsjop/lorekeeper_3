<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBorderTables extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {

    Schema::create('border_categories', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->text('description')->nullable()->default(null);
      $table->text('parsed_description')->nullable()->default(null);
      $table->boolean('has_image')->default(0);
      $table->integer('sort')->default(0);
    });

    Schema::create('borders', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->integer('border_category_id')->unsigned()->nullable()->default(null);
      $table->string('name');
      $table->text('description')->nullable()->default(null);
      $table->text('parsed_description')->nullable()->default(null);
      $table->boolean('is_default')->default(0); //can be selected for free at any time
      $table->boolean('is_active')->default(1);
      $table->boolean('border_style')->default(0); // 0 = under 1 = over the user icon
    });

    Schema::create('user_borders', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->unsignedInteger('user_id');
      $table->unsignedInteger('border_id'); //
      $table->timestamps();
    });

    Schema::create('user_borders_log', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->unsignedInteger('border_id');
      $table->string('log', 2000);
      $table->string('log_type');
      $table->string('data', 2000)->nullable();
      $table->unsignedInteger('sender_id')->nullable();
      $table->unsignedInteger('recipient_id')->nullable();
      $table->unsignedInteger('character_id')->nullable();
      $table->timestamps();
    });

    Schema::table('users', function (Blueprint $table) {
      $table->integer('border_id')->unsigned()->index()->nullable()->default(null)->onDelete('cascade');;
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {

    // Schema::dropIfExists('users');

    Schema::dropIfExists('border_categories');
    Schema::dropIfExists('borders');
    Schema::dropIfExists('user_borders');
    Schema::dropIfExists('user_borders_log');

    dropColumnIfExists('border_categories', 'id');
    dropColumnIfExists('border_categories', 'name');
    dropColumnIfExists('border_categories', 'description');
    dropColumnIfExists('border_categories', 'parsed_description');
    dropColumnIfExists('border_categories', 'has_image');
    dropColumnIfExists('border_categories', 'sort');

    dropColumnIfExists('borders', 'id');
    dropColumnIfExists('borders', 'id');
    dropColumnIfExists('borders', 'name');
    dropColumnIfExists('borders', 'description');
    dropColumnIfExists('borders', 'parsed_description');
    dropColumnIfExists('borders', 'is_default');
    dropColumnIfExists('borders', 'is_active');
    dropColumnIfExists('borders', 'border_style');

    dropColumnIfExists('user_borders', 'id');
    dropColumnIfExists('user_borders', 'user_id');
    dropColumnIfExists('user_borders', 'border_id');
    dropColumnIfExists('user_borders', 'id');

    dropColumnIfExists('user_borders_log', 'id');
    dropColumnIfExists('user_borders_log', 'border_id');
    dropColumnIfExists('user_borders_log', 'log');
    dropColumnIfExists('user_borders_log', 'log_type');
    dropColumnIfExists('user_borders_log', 'data');
    dropColumnIfExists('user_borders_log', 'sender_id');
    dropColumnIfExists('user_borders_log', 'recipient_id');
    dropColumnIfExists('user_borders_log', 'character_id');

    dropColumnIfExists('users', 'border_id');
  }
}
