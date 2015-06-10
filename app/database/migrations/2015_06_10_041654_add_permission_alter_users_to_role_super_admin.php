<?php

use Illuminate\Database\Migrations\Migration;

class AddPermissionAlterUsersToRoleSuperAdmin extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Role 'Super Admin' doesn't exist yet, so create it
        Role::create(array('name'=>'Super Admin', 'rank'=>'0'));
        Permission::firstOrCreate(array('role_name'=>'Super Admin', 'name'=>'Alter Users'));
 
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }

}
