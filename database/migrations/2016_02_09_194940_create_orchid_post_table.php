<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrchidPostTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        try {
            Schema::create('posts', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id');
                $table->string('type');
                $table->string('status')->nullable();
                $table->jsonb('content');
                $table->jsonb('options');
                $table->string('slug', '255')->unique();
                $table->timestamp('publish_at');
                $table->timestamps();
                $table->softDeletes();
                $table->index(['status', 'type']);
            });
        } catch (\Exception $exception) {
            Schema::create('posts', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id');
                $table->string('type');
                $table->string('status')->nullable();
                $table->text('content');
                $table->text('options');
                $table->string('slug', '255')->unique();
                $table->timestamp('publish_at');
                $table->timestamps();
                $table->softDeletes();
                $table->index(['status', 'type']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('posts');
    }
}
