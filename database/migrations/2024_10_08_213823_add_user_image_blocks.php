<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserImageBlocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_image_blocks', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('object_id')->unsigned()->index();
            $table->string('object_type');
            $table->integer('user_id')->unsigned()->index();
        });

        Schema::table('user_settings', function (Blueprint $table) {
            $table->boolean('show_image_blocks')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_image_blocks');

        Schema::table('user_settings', function (Blueprint $table) {
            $table->dropColumn('show_image_blocks');
        });
    }
}
