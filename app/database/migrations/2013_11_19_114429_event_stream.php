<?php

use Illuminate\Database\Migrations\Migration;

class EventStream extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
				Schema::create('event_stream', function($table)
			{
				$table->increments('id');
				$table->integer('event_id')->unsigned();
				$table->integer('stream_id')->unsigned();
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
		Schema::drop('event_stream');
	}

}