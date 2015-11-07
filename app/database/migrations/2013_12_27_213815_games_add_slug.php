<?php

use Illuminate\Database\Migrations\Migration;

class GamesAddSlug extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('games', function($table)
			{
				$table->string('slug');

			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('games', function($table)
			{
				$table->dropColumn('slug');
			});
	}

}