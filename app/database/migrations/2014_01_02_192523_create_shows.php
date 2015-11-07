<?php

use Illuminate\Database\Migrations\Migration;

class CreateShows extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
				Schema::create('shows', function($table)
			{
				$table->increments('id');
				$table->integer('author_id');
				$table->string('title');
				$table->string('slug');
				$table->string('show_icon');	
				$table->dateTime('air_date');
				$table->text('people');
				$table->text('about');
				$table->text('vods');
				$table->text('tags');
				$table->boolean('public_state')->default(true);
				$table->boolean('approved')->default(false);
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
		Schema::drop('shows');
	}

}