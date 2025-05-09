<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

function doesColumnExist($tableName, $columnName) {
  return Schema::hasColumn($tableName, $columnName);
}
function dropColumnIfExists($tableName, $columnName) {
  if (doesColumnExist($tableName, $columnName))
    Schema::table($tableName, fn(Blueprint $table) => $table->dropColumn($columnName));
}

class AddTwoFactorColumnsToUsersTable extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::table('users', function (Blueprint $table) {
            $table->text('two_factor_secret')
                ->after('password')
                ->nullable();

            $table->text('two_factor_recovery_codes')
                ->after('two_factor_secret')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('two_factor_secret', 'two_factor_recovery_codes');
        });
    }
}
