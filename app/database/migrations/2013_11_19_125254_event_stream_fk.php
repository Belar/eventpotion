<?php

use Illuminate\Database\Migrations\Migration;

class EventStreamFk extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('event_stream', function($table)
			{
				$table->foreign('stream_id')->references('id')->on('streams');
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