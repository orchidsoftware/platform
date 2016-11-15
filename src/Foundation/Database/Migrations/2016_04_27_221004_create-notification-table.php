<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('notification', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->index()->unsigned();
            $table->string('type')->index();
            $table->string('url')->nullable();
            $table->string('text')->nullable();
            $table->boolean('read')->default(0);
            $table->timestamps();

            /*
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('notification');
    }
}
