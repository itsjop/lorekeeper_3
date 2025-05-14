<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetItemsLogSenderRecipientDefaultNull extends Migration {
  /**
   * Run the migrations.
   */
  public function up() {
    //Change default to null going forward
    DB::statement("ALTER TABLE items_log CHANGE COLUMN sender_type sender_type ENUM('User', 'Character') DEFAULT NULL");
    DB::statement("ALTER TABLE items_log CHANGE COLUMN recipient_type recipient_type ENUM('User', 'Character') DEFAULT NULL");

    Schema::table('items_log', function (Blueprint $table) {

      //Actually drop them this time, please. Also drop the item_id column
      dropFK('items_log', 'inventory_log_sender_id_foreign');
      dropFK('items_log', 'inventory_log_recipient_id_foreign');
      dropFK('items_log', 'user_items_log_stack_id_foreign');
      dropFK('items_log', 'inventory_log_item_id_foreign');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down() {
    //
    // DB::statement("ALTER TABLE items_log CHANGE COLUMN sender_type sender_type ENUM('User', 'Character') DEFAULT 'User'");
    // DB::statement("ALTER TABLE items_log CHANGE COLUMN recipient_type recipient_type ENUM('User', 'Character') DEFAULT 'User'");

    if (Schema::hasTable('items_log'))
      Schema::table('items_log', function (Blueprint $table) {
        // $table->dropForeign(['client_id']);
        // $table->dropColumn('client_id');
        // $table->drop('devices');
        // $table->dropConstrainedForeignId('sender_id');
        // $table->dropConstrainedForeignId('recipient_id');
        // $table->dropConstrainedForeignId('item_id');
        // $table->dropConstrainedForeignId('stack_id');
        dropFK('recipient_id', 'users');
        dropFK('item_id', 'items');
        dropFK('stack_id', 'user_items');
        dropFK('sender_id', 'users');
        // $table->foreign('sender_id')->references('id')->on('users');
        // $table->foreign('recipient_id')->references('id')->on('users');
        // $table->foreign('item_id')->references('id')->on('items');
        // $table->foreign('stack_id')->references('id')->on('user_items');
      });
  }
}
