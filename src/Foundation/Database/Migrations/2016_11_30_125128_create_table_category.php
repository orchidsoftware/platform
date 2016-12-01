<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->increments('id');
            $table->jsonb('content');
            $table->timestamps();
        });

        Schema::create('tree_patch', function (Blueprint $table) {
            $table->unsignedBigInteger('ancestor');
            $table->unsignedBigInteger('descendant');
            $table->primary('ancestor', 'descendant');
            $table->foreign('ancestor')
                ->references('id')
                ->on('category')
                ->onDelete('cascade');
            $table->foreign('descendant')
                ->references('id')
                ->on('category')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('category');
        Schema::drop('tree_patch');
    }
}
