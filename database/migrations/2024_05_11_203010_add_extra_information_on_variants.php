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
        //
        Schema::table('pet_variants', function (Blueprint $table) {
            $table->string('description')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //z
        Schema::table('pet_variants', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
