<?php

use Illuminate\Database\Migrations\Migration;

class ExtraAddApproved extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('extras', function($table)
			{
				$table->integer('approved');
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('extras', function($table)
			{
				$table->dropColumn('approved');
			});
	}

}