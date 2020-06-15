<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddedColumnsFor2fa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('uses_two_factor_auth')->default(false);
            $table->string('two_factor_secret_code', 100)->nullable();
            $table->string('two_factor_recovery_code', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'uses_two_factor_auth',
                'two_factor_secret_code',
                'two_factor_recovery_code',
            ]);
        });
    }
}
