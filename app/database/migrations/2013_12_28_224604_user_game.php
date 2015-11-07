<?php

use Illuminate\Database\Migrations\Migration;

class UserGame extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
				Schema::create('user_game', function($table)
			{
				$table->increments('id');
				$table->integer('user_id')->unsigned();
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
		Schema::drop('user_game');
	}

}