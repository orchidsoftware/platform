<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrchidTaxonomyTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('term_taxonomy', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('term_id')->unsigned();
            $table->string('taxonomy');
            $table->integer('parent_id')->unsigned()->nullable()->default(NULL);

            $table->index(['id', 'taxonomy']);

            $table->foreign('parent_id')
                ->references('id')
                ->on('term_taxonomy')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('term_id')
                ->references('id')
                ->on('terms')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('term_taxonomy');
    }
}
