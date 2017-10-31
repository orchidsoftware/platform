<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrchidMenuTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->string('title')->nullable();
            $table->string('slug');
            $table->string('robot')->nullable();
            $table->string('style')->nullable();
            $table->string('target')->nullable();
            $table->boolean('auth')->default(false);
            $table->string('lang');
            $table->integer('parent')->nullable();
            $table->integer('sort')->default(0);
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('menu');
    }
}
