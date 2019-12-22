<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrchidAttachmentstableTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $table = env('ORCHID_ATTACHMENTS_DATABASE_TABLE', 'attachments');
        $tableAttachmentable = env('ORCHID_ATTACHMENTABLE_DATABASE_TABLE', 'attachmentable');
        
        Schema::create($table, function (Blueprint $table) {
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
            $table->text('hash')->nullable();
            $table->string('disk')->default('public');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('group')->nullable();
            $table->timestamps();
        });

        Schema::create($tableAttachmentable, function (Blueprint $table) {
            
            $tableAttachments = env('ORCHID_ATTACHMENTS_DATABASE_TABLE', 'attachments');
            
            $table->increments('id');
            $table->string('attachmentable_type');
            $table->unsignedInteger('attachmentable_id');
            $table->unsignedInteger('attachment_id');

            $table->index(['attachmentable_type', 'attachmentable_id']);

            $table->foreign('attachment_id')
                ->references('id')
                ->on($tableAttachments)
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $table = env('ORCHID_ATTACHMENTS_DATABASE_TABLE', 'attachments');
        $tableAttachmentable = env('ORCHID_ATTACHMENTABLE_DATABASE_TABLE', 'attachmentable');
        
        Schema::drop($tableAttachmentable);
        Schema::drop($table);
    }
}
