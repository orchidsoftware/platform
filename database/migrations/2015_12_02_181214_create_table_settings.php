<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateTableSettings.
 *
 * @deprecated
 */
class CreateTableSettings extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->json('value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
