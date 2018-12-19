<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrchidTagsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tagged', function(Blueprint $table) {
            $table->increments('id');
            $table->string('taggable_type');
            $table->unsignedInteger('taggable_id');
            $table->unsignedInteger('tag_id');
            $table->engine = 'InnoDB';
            $table->index(['taggable_type', 'taggable_id']);
        });
        Schema::create('tags', function(Blueprint $table) {
            $table->increments('id');
            $table->string('namespace');
            $table->string('slug');
            $table->string('name');
            $table->unsignedInteger('count')->default(0);
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $tables = ['tagged', 'tags'];
        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }
    }
}
