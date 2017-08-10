<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrchidUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('last_login')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('avatar')->nullable();
            $table->string('website')->nullable();
            $table->text('about')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('sex')->nullable();
            $table->boolean('subscription')->default('1');
            $table->text('permissions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_login');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('avatar');
            $table->dropColumn('website');
            $table->dropColumn('about');
            $table->dropColumn('phone');
            $table->dropColumn('sex');
            $table->dropColumn('subscription');
            $table->dropColumn('permissions');
        });
    }
}
