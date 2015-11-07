<?php

class Stream extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'streams';
	
	public function streamEvent()
    {
        return $this->belongsToMany('ep\Event');
    }
	
	public function streamGame()
    {
        return $this->belongsToMany('Game');
    }
	
	public function streamShow()
    {
        return $this->belongsToMany('Show');
    }

}