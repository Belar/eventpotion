<?php

class Show extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'shows';
		
	public function showGame()
    {
        return $this->belongsToMany('Game', 'show_game');
    }
	
	public function showStream()
    {
        return $this->belongsToMany('Stream', 'show_stream');
    }
	
	public function showUser()
    {
        return $this->belongsToMany('User', 'user_show');
    }
	
}