<?php

use Illuminate\Database\Migrations\Migration;

class EventAddMaps extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('events', function($table)
			{
				$table->decimal('latitude', 10, 7);
				$table->decimal('longitude', 10, 7);
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
				$table->dropColumn('latitude', 'longitude');
			});
	}

}