<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxonomyTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('term_taxonomy', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('term_id');
            $table->string('taxonomy');
            $table->integer('parent_id')->default(0);

            $table->index(['id', 'parent_id']);
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
