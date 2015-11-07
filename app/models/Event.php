<?php 

namespace ep;
use Eloquent;

class Event extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'events';

	
	public function eventGame()
    {
        return $this->belongsToMany('Game');
    }
	
	public function eventStream()
    {
        return $this->belongsToMany('Stream');
    }
	
	public function eventExtra()
    {
        return $this->hasMany('Extra', 'event_id');
    }
	
	public function eventUser()
    {
        return $this->belongsToMany('User');
    }
}