<?php

use Illuminate\Database\Migrations\Migration;

class EventsAdd extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
				Schema::create('events', function($table)
			{
				$table->increments('id');
				$table->string('title');
				$table->string('slug');
				$table->integer('author_id');
				$table->string('website');
				$table->string('brackets');
				$table->string('ticket_store');
				$table->string('vod');
				$table->dateTime('start_date');
				$table->dateTime('finish_date');
				$table->string('location');
				$table->string('prizepool');
				$table->text('about');
				$table->string('event_icon');
				$table->boolean('public_state')->default(true);
				$table->boolean('comments')->default(true);
				$table->text('tags');
				$table->timestamps();
				
				$table->softDeletes();
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('events');
	}

}