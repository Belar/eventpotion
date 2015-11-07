<?php

use Illuminate\Database\Migrations\Migration;

class UserShowCreate extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
				Schema::create('user_show', function($table)
			{
				$table->increments('id');
				$table->integer('show_id')->unsigned();
				$table->integer('user_id')->unsigned();
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
		Schema::drop('user_show');
	}

}