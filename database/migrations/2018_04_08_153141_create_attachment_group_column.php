<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentGroupColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attachmentable', function (Blueprint $table) {
            $table->string('attachmentable_group')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attachmentable', function (Blueprint $table) {
            $table->dropColumn('attachmentable_group');
        });
    }
}
