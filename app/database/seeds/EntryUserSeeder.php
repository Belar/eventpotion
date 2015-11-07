<?php

class EntryUserSeeder extends Seeder {

	public function run()

	{

		$user = new User;

		$user->fill(array(

		'email'    => '', //initial user email

		'nickname' => '', //initial user nickname

		'activated' => '1',

		));

		$user->password = Hash::make('admin');
		$user->save();

	}
}
