<?php

use Illuminate\Database\Migrations\Migration;

class EventsAddApproved extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('events', function($table)
			{
				$table->integer('approved');
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('events', function($table)
			{
				$table->dropColumn('approved');
			});
	}

}