<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {

        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id');
            $table->json('content');
            $table->integer('parent');
            $table->integer('sort');
            $table->string('type');
            $table->integer('depth');
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