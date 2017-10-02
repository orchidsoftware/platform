<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrchidTermsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        try {
            Schema::create('terms', function (Blueprint $table) {
                $table->increments('id');
                $table->string('slug')->unique();
                $table->jsonb('content');
                $table->integer('term_group')->default(0);
                $table->timestamps();
            });
        } catch (\Exception $exception) {
            Schema::create('terms', function (Blueprint $table) {
                $table->increments('id');
                $table->string('slug')->unique();
                $table->text('content');
                $table->integer('term_group')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('terms');
    }
}
