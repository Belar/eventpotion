<?php

use Illuminate\Database\Migrations\Migration;

class EventsAddType extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('events', function($table)
			{
				$table->boolean('lan')->default(0);

			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('events', function($table)
			{
				$table->dropColumn('lan');
			});
	}

}