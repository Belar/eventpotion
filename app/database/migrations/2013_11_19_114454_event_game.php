<?php

use Illuminate\Database\Migrations\Migration;

class EventGame extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
				Schema::create('event_game', function($table)
			{
				$table->increments('id');
				$table->integer('event_id')->unsigned();
				$table->integer('game_id')->unsigned();
				$table->timestamps();
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('event_game');
	}
}