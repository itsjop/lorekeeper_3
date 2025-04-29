<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraTransformationFields extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('character_images', function (Blueprint $table) {
            //displayed on the tab
            $table->string('transformation_info')->nullable()->default(null);
            //if the user wants to elaborate on some origin of why the form change takes place etc (shown on image_info)
            $table->string('transformation_description')->nullable()->default(null);
        });

        Schema::table('character_transformations', function (Blueprint $table) {
            $table->integer('species_id')->unsigned()->nullable()->default(null);
        });

        Schema::table('design_updates', function (Blueprint $table) {
            //displayed on the tab
            $table->string('transformation_info')->nullable()->default(null);
            //if the user wants to elaborate on some origin of why the form change takes place etc (shown on image_info)
            $table->string('transformation_description')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
      dropColumnIfExists('character_images', 'transformation_info');
      dropColumnIfExists('character_images', 'transformation_description');

      dropColumnIfExists('character_transformations', 'species_id');
      dropColumnIfExists('character_transformations', 'transformation_info');
      dropColumnIfExists('character_transformations', 'transformation_description');
    }
}
