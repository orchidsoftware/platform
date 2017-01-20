<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nickname')->nullable();
            $table->string('avatar')->nullable();
            $table->string('website')->nullable();
            $table->text('about')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('sex')->nullable();
            $table->boolean('subscription')->default('1');
            //$table->uuid('key');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('users');
    }
}
