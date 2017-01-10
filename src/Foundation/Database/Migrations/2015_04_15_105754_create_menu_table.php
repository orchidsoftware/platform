<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->string('slug');
            $table->string('robot')->nullable();
            $table->string('style')->nullable();
            $table->string('target')->nullable();
            $table->boolean('auth')->default(false);
            $table->string('lang');
            $table->integer('parent');
            $table->integer('sort');
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
