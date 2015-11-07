<?php

use Illuminate\Database\Migrations\Migration;

class ExtrasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
				Schema::create('extras', function($table)
			{
				$table->increments('id');
				$table->string('title');
				$table->integer('author_id');
				$table->integer('event_id');
				$table->string('extra_url');
				$table->string('extra_type');
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
		Schema::drop('extras');
	}

}