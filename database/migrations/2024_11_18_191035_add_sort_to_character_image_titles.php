<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('character_image_titles', function (Blueprint $table) {
            //
            $table->integer('sort')->default(null)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('character_image_titles', function (Blueprint $table) {
            //
            $table->dropColumn('sort');
        });
    }
};
