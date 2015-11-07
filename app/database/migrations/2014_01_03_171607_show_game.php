<?php

use Illuminate\Database\Migrations\Migration;

class ShowGame extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
				Schema::create('show_game', function($table)
			{
				$table->increments('id');
				$table->integer('show_id')->unsigned();
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
		Schema::drop('show_game');
	}

}