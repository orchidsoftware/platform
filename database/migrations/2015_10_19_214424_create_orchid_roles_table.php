<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrchidRolesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $table = env('ORCHID_ROLES_ROLES_DATABASE_TABLE', 'roles');
        Schema::create($table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->string('name');
            $table->jsonb('permissions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $table = env('ORCHID_ROLES_ROLES_DATABASE_TABLE', 'roles');
        Schema::dropIfExists($table);
    }
}
