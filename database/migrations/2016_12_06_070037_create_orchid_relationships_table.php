<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrchidRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('term_relationships', function (Blueprint $table) {
            $table->integer('post_id');
            $table->integer('term_taxonomy_id');
            $table->integer('term_order')->default(0);

            $table->index(['post_id', 'term_taxonomy_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('term_relationships');
    }
}
