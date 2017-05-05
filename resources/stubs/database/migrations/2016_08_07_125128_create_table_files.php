<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTableFiles extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->text('original_name');
            $table->string('mime');
            $table->string('extension')->nullable();
            $table->bigInteger('size')->default(0);
            $table->integer('sort')->default(0);
            $table->text('path');
            $table->text('description')->nullable();
            $table->text('alt')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('post_id')->nullable();
            $table->timestamps();

            $table->index(['id', 'post_id', 'user_id']);
        });


        Schema::create('attachment_relationships', function (Blueprint $table) {
            $table->increments('id');
            $table->text('attachmentable_type');
            $table->integer('attachmentable_id');
            $table->integer('attachment_id');


            //$table->index(['attachmentable_type', 'attachmentable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('attachments');
        Schema::drop('attachment_relationships');
    }
}
