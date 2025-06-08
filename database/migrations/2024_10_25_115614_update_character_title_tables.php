<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        //
        Schema::table('character_images', function (Blueprint $table) {
            $table->dropColumn('title_id');
            $table->dropColumn('title_data');
        });

        Schema::table('design_updates', function (Blueprint $table) {
            $table->dropColumn('title_id');
            $table->dropColumn('title_data');
        });

        Schema::create('character_image_titles', function (Blueprint $table) {
            $table->id();
            $table->integer('character_image_id');
            $table->integer('title_id')->nullable()->default(null); // nullable for custom titles
            $table->json('data')->nullable()->default(null);
        });

        Schema::table('character_titles', function (Blueprint $table) {
            $table->string('colour')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        //
        Schema::dropIfExists('character_image_titles');

        Schema::table('design_updates', function (Blueprint $table) {
            $table->integer('title_id')->nullable()->default(null)->index();
            $table->string('title_data')->nullable()->default(null);
        });

        Schema::table('character_images', function (Blueprint $table) {
            $table->integer('title_id')->nullable()->default(null)->index();
            $table->string('title_data')->nullable()->default(null);
        });
    }
};
