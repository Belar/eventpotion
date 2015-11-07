<?php

class Game extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'games';
	
	public function gameEvent()
    {
        return $this->belongsToMany('ep\Event');
    }
	
	public function gameStream()
    {
        return $this->belongsToMany('Stream');
    }
	
	public function gameShow()
    {
        return $this->belongsToMany('Show');
    }

}