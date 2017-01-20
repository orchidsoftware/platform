<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRoleUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('role_users', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('role_id');

            /*
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');
            */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('role_users');
    }
}
