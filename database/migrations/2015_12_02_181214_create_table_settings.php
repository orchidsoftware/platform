<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSettings extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $table = config('platform.settingsTable');
        Schema::create($table, function (Blueprint $table) {
            $table->string('key')->primary();
            $table->json('value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $table = config('platform.settingsTable');
        Schema::dropIfExists($table);
    }
}
