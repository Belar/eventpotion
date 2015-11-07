<?php

use Illuminate\Database\Migrations\Migration;

class EventUserFk extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('event_user', function($table)
			{
				$table->foreign('user_id')->references('id')->on('users');
				$table->foreign('event_id')->references('id')->on('events');

			});
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