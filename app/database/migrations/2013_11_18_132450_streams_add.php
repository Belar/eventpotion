<?php

use Illuminate\Database\Migrations\Migration;

class StreamsAdd extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
				Schema::create('streams', function($table)
			{
				$table->increments('id');
				$table->string('title');
				$table->string('slug');
				$table->string('stream_url');
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
		Schema::drop('streams');
	}

}