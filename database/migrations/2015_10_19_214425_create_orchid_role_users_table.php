<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrchidRoleUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $table = env('ORCHID_ROLE_USERS_DATABASE_TABLE', 'role_users');
        
        Schema::create($table, function (Blueprint $table) {
            
            $tableRoles = env('ORCHID_ROLES_ROLES_DATABASE_TABLE', 'roles');
            
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('role_id');
            $table->primary(['user_id', 'role_id']);
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('role_id')
                ->references('id')
                ->on($tableRoles)
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $table = env('ORCHID_ROLE_USERS_DATABASE_TABLE', 'role_users');
        Schema::dropIfExists($table);
    }
}
