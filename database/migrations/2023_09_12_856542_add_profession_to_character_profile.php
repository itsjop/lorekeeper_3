<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfessionToCharacterProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('character_profiles', function(Blueprint $table) {
            $table->string('profession')->nullable()->default(null);
            $table->integer('profession_id')->nullable()->default(null)->unsigned();
        });

        Schema::table('professions', function(Blueprint $table) {
            $table->boolean('is_choosable')->default(true);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('character_profiles', function(Blueprint $table) {
            $table->dropColumn('profession');
            $table->dropColumn('profession_id');
        });
        //
        Schema::table('professions', function(Blueprint $table) {
            $table->dropColumn('is_choosable');
        });

    }
}
