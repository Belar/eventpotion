<?php

use Illuminate\Database\Migrations\Migration;

class EventGameFk extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('event_game', function($table)
			{
				$table->foreign('game_id')->references('id')->on('games');
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