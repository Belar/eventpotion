<?php

use Illuminate\Database\Migrations\Migration;

class UserAddTimezone extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table)
			{
				$table->string('timezone')->default('UCT');

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
				$table->dropColumn('timezone');
			});
	}

}