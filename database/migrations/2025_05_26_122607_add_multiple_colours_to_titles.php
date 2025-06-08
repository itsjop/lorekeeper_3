<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('character_titles', function (Blueprint $table) {
            // rename colour to colours and convert existing data to array
            $table->renameColumn('colour', 'colours');
        });

        DB::table('character_titles')->get()->each(function ($title) {
            // Convert the existing single colour string to an array
            if (is_string($title->colours)) {
                $colours = [$title->colours];
            } else {
                $colours = [];
            }

            // Save the updated title
            DB::table('character_titles')
                ->where('id', $title->id)
                ->update(['colours' => json_encode($colours)]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        // Revert the colours to a single string if they were previously a single colour
        DB::table('character_titles')->get()->each(function ($title) {
            // Convert the existing colours array back to a single string
            $colours = json_decode($title->colours, true);
            if (is_array($colours) && count($colours) > 0) {
                $colour = $colours[0]; // Take the first colour as the single colour
            } else {
                $colour = null; // If no colours, set to null
            }

            // Save the updated title
            DB::table('character_titles')
                ->where('id', $title->id)
                ->update(['colours' => $colour]);
        });

        Schema::table('character_titles', function (Blueprint $table) {
            //
            $table->renameColumn('colours', 'colour');
        });
    }
};
