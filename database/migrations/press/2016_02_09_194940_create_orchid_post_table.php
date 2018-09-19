<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrchidPostTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('type');
            $table->string('status')->nullable();
            $table->jsonb('content')->nullable();
            $table->jsonb('options')->nullable();
            $table->string('slug', '255')->unique();
            $table->timestamp('publish_at')->useCurrent();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['status', 'type']);

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('posts');
    }
}
