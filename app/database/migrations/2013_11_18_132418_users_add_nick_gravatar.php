<?php

use Illuminate\Database\Migrations\Migration;

class UsersAddNickGravatar extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table)
			{
				$table->string('nickname');
				$table->string('gravatar');
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function($table)
			{
				$table->dropColumn('nick', 'gravatar');
			});
	}

}