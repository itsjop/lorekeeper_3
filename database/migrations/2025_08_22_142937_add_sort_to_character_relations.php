<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('character_relations', function (Blueprint $table) {
          // Add sort column, null default value
          $table->integer('sort_1')->default(null)->nullable();
          $table->integer('sort_2')->default(null)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('character_relations', function (Blueprint $table) {
          // Remove sort column
          $table->dropColumn('sort_1');
          $table->dropColumn('sort_2');
        });
    }
};
