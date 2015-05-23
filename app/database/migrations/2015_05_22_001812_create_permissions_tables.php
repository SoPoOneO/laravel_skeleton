<?php

use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // Creates the roles table
        Schema::create('roles', function ($table) {
            $table->string('name', 32)->primary();
            $table->integer('rank');
        });

        // Creates the permissions table
        Schema::create('permissions', function ($table) {
            $table->string('name', 32)->primary();
        });

        // Creates the permission_role (Many-to-Many relation) table
        Schema::create('permission_role', function ($table) {
            $table->increments('id')->unsigned();
            $table->string('permission_name', 32);
            $table->string('role_name', 32);
            $table->foreign('permission_name')->references('name')->on('permissions');
            $table->foreign('role_name')->references('name')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('permission_role');
        Schema::drop('roles');
        Schema::drop('permissions');
    }

}
