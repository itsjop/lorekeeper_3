<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profession_categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('species_id')->nullable()->default(null)->unsigned();

            $table->string('name');

            $table->text('description')->nullable()->default(null);
            $table->text('parsed_description')->nullable()->default(null);

            $table->string('image_extension', 191)->nullable()->default(null); 
            $table->integer('sort')->unsigned()->default(0); 

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('profession_subcategories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();

            $table->string('name');

            $table->text('description')->nullable()->default(null);
            $table->text('parsed_description')->nullable()->default(null);

            $table->string('image_extension', 191)->nullable()->default(null); 
            $table->integer('sort')->unsigned()->default(0); 
            $table->integer('category_id')->nullable()->default(null)->unsigned();


            $table->timestamps();
            $table->softDeletes();
        });

        // Animals etc
        Schema::create('professions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();

            $table->string('name');

            $table->text('description')->nullable()->default(null);
            $table->text('parsed_description')->nullable()->default(null);

            $table->string('image_extension', 191)->nullable()->default(null); 
            $table->string('icon_extension', 191)->nullable()->default(null); 
            $table->integer('sort')->unsigned()->default(0); 

            $table->integer('category_id')->nullable()->default(null)->unsigned();
            $table->integer('subcategory_id')->nullable()->default(null)->unsigned();

            $table->boolean('is_active')->default(1);

            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profession_categories');
        Schema::dropIfExists('profession_subcategories');
        Schema::dropIfExists('professions');
    }
}
