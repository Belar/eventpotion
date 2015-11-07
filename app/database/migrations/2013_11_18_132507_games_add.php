<?php

use Illuminate\Database\Migrations\Migration;

class GamesAdd extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
				Schema::create('games', function($table)
			{
				$table->increments('id');
				$table->string('title');
				$table->string('game_icon');
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
		Schema::drop('games');
	}

}