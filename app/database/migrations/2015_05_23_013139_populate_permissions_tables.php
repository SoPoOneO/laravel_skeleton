<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PopulatePermissionsTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Role::insert(array(
			array('rank' => 1, 'name' => 'Super Admin'),
			array('rank' => 2, 'name' => 'Admin'),
			array('rank' => 3, 'name' => 'Editor'),
			array('rank' => 4, 'name' => 'Representative')
		));

		Permission::insert(array(
			array('name' => 'Alter Users')
		));

		// Super Admin Permissions
		Role::find('Super Admin')->permissions()->attach('Alter Users');

		// // Admin Permissions
		Role::find('Admin')->permissions()->attach('Alter Users');

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
