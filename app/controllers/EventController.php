<?php


class EventController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
			if( Sentry::check() )
            {
                $user = User::find(Sentry::getUser()->id);
            }
			
			
			if( Sentry::check() &&  $user->userGame()->first())
			{
				$key = 'events'.Sentry::getUser()->id;
				
				$next = Cache::remember($key, 15, function()
				{
					return ep\Event::whereHas('eventGame', function($q)
					{
						$user = User::find(Sentry::getUser()->id);
					
						$user_games = $user->userGame()->lists('game_id');
					
						$q->whereIn('game_id', $user_games);

					})->where('approved','=','1')->where('public_state','=','1')->where('finish_date', '>=', date("Y-m-d"))->take(25)->orderBy( 'start_date')->get();
				});			
			}
			else
			{	
				$next = Cache::remember('events_global', 15, function()
				{
				return ep\Event::where('approved','=','1')->where('public_state','=','1')->where('finish_date', '>=', date("Y-m-d"))->take(25)->orderBy( 'start_date')->get();
				});	
			}
			
			if( Sentry::check() && Sentry::getUser()->timezone)
			{
				return View::make('allround.hello_tz', array('events' => $next));
			}
			
			return View::make('allround.hello', array('events' => $next));
	}
	
	public function indexGame($id)
	{
		
		$game = Game::where('id','=',$id)->orWhere('slug','=',$id)->first();
		$events = $game->gameEvent()->where('approved','=','1')->where('public_state','=','1')->where('finish_date', '>=', date("Y-m-d"))->orderBy( 'start_date')->get();
			
		if(Sentry::check() && Sentry::getUser()->timezone){
			return View::make('event.index_game_tz', array('events' => $events ));
		}
		
		return View::make('event.index_game', array('events' => $events));
	}
	
	public function eventTag($tag)
	{
			
		$events = ep\Event::where('public_state', '=', true)->where('tags', 'LIKE', '%'.$tag.'%')->orderBy('start_date', 'desc')->get();
		
		if(Sentry::check() && Sentry::getUser()->timezone){
			return View::make('event.index_game_tz', array('events' => $events, 'pageTitle' => 'Event Index'));
		}
		
		return View::make('event.index_game', array('events' => $events, 'pageTitle' => 'Event Index'));
	
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('event.add_event', array('pageTitle' => 'Add Event'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
			// Fetch all request data.
			$data = Input::only('title','event_icon', 'lan', 'games', 'website', 'brackets', 'ticket_store', 'vod', 'start_date', 'finish_date', 'prizepool', 'location', 'about', 'tags', 'public_state', 'streams');
			// Build the validation constraint set.
			$rules = array(
				'title' => array('required', 'min:3'),
				'event_icon' => array('required', 'alpha_dash'),
				'lan' => array('integer'),
				'games' => array('required'),
				'website' => array('url'),
				'brackets' => array('url'),
				'ticket_store' => array('url'),
				'vod' => array('url'),
				'start_date' => array('required','date', 'before:'.Input::get('finish_date')),
				'finish_date' => array('required','date'),
				'prizepool' => array('required', 'max:20'),
				'location' => array('required_if:lan,true','max:25'),
				'about' => array('max:21800'),
				'public_state' => array('integer'),
				'streams' => array('requiredOrArray','alpha_dashOrArray'),		
			);
			// Create a new validator instance.
			$validator = Validator::make($data, $rules);
				if ($validator->passes()) {
				
					$current_user = Sentry::getUser();
									
					$event = new ep\Event();
					$event->author_id = $current_user->id;
						
						$title = Input::get('title');				
						$uniqid = str_shuffle(uniqid());
					$event->slug = Str::slug($title, '-').'-'.$uniqid;
										
					$event->title = $title;
					
										
					$event->event_icon = Input::get('event_icon');
					$event->website = Input::get('website');
					$event->brackets = Input::get('brackets');
					$event->ticket_store = Input::get('ticket_store');
					$event->vod = Input::get('vod');
					$event->start_date = new DateTime(Input::get('start_date'));
					$event->finish_date = new DateTime(Input::get('finish_date'));
					$event->prizepool = Input::get('prizepool');
					$event->about = Input::get('about');
					$event->tags = Input::get('tags');
					
					if( $current_user->hasAccess('admin') || $current_user->hasAccess('verified') )
					{
						$event->approved = '1';
					}
					
					
					$event->lan = ( Input::get('lan') ? 1 : 0);
					if(Input::get('lan') == true)
					{
						$event->location = Input::get('location');
						$event->latitude = Input::get('latitude');
						$event->longitude = Input::get('longitude');				
					}
					else
					{
						$event->location = 'Online';
					}				
					
					$event->public_state = ( Input::get('public_state') ? 1 : 0);
													
					$event->save();
					
					$games = Input::get('games');
					foreach ($games as $game)
					{
						$game_id = Game::find($game);
						$event->eventGame()->attach($game_id);
					}
					
					$stream_urls = Input::get('streams');
						foreach ($stream_urls as $stream_url) 
						{
						
						$stream_old = Stream::where('stream_url', '=', $stream_url)->first();
						
							if($stream_old == false && $stream_url)
								{
								$stream = new Stream();
								$stream->stream_url = $stream_url;
								
								$stream->save();
								$stream->streamEvent()->attach($event);
								}
							else
								{
									if(! $event->eventStream($stream_old->id)->first())
									{
										$stream_old->streamEvent()->attach($event);
									}
								}
						}
					
						return Redirect::to('/')->with('global_success', 'Event submitted successfuly!');
				}
			
			return Redirect::to('/event/add')->withInput()->withErrors($validator)->with('message', 'Validation Errors!');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		if(Sentry::check())
		{
			$event = ep\Event::where('id','=',$id)->orWhere('slug','=',$id)->first();
			$streams = $event->eventStream()->get();
			$games = $event->eventGame()->get();
			$extras = $event->eventExtra()->where('approved','=', '1')->orderBy('created_at', 'desc')->get();
			return View::make('event.show_event_tz', array('pageTitle' => $event->title, 'event'=>$event, 'streams'=>$streams, 'games'=>$games,'extras'=>$extras, 'i'=>'1'));
		}
		
		$event = ep\Event::where('id','=',$id)->orWhere('slug','=',$id)->first();
		$streams = $event->eventStream()->get();
		$games = $event->eventGame()->get();
		$extras = $event->eventExtra()->where('approved','=', '1')->orderBy('created_at', 'desc')->get();
		return View::make('event.show_event', array('pageTitle' => $event->title, 'event'=>$event, 'streams'=>$streams, 'games'=>$games,'extras'=>$extras, 'i'=>'1'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{	
			$event = ep\Event::find($id);
			$streams = $event->eventStream()->get();
			$event_games = $event->eventGame()->lists('game_id');
			return View::make('event.edit_event', array('event'=>$event, 'streams'=>$streams, 'event_games'=>$event_games));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
			$event = ep\Event::find($id);
		
			// Fetch all request data.
			$data = Input::only('title', 'event_icon', 'lan', 'games', 'website', 'brackets', 'ticket_store', 'vod', 'start_date', 'finish_date', 'prizepool', 'location', 'about', 'tags', 'public_state', 'streams');
			// Build the validation constraint set.
			$rules = array(
				'title' => array('required', 'min:3'),
				'event_icon' => array('required', 'alpha_dash'),
				'lan' => array('integer'),
				'games' => array('required'),
				'website' => array('url'),
				'brackets' => array('url'),
				'ticket_store' => array('url'),
				'vod' => array('url'),
				'start_date' => array('required','date', 'before:'.Input::get('finish_date')),
				'finish_date' => array('required','date'),
				'prizepool' => array('max:20'),
				'location' => array('required_if:lan,true','max:25'),
				'about' => array('max:21800'),
				'public_state' => array('integer'),
				'streams' => array('requiredOrArray','alpha_dashOrArray'),		
			);
			// Create a new validator instance.
			$validator = Validator::make($data, $rules);
				if ($validator->passes()) {

					$title = Input::get('title');	
					
					if ($event->title !== $title)
						{
						$uniqid = str_shuffle(uniqid());
						$event->slug = Str::slug($title, '-').'-'.$uniqid;
						$event->title = $title;
						}
					
					$event->event_icon = Input::get('event_icon');
					$event->website = Input::get('website');
					$event->brackets = Input::get('brackets');
					$event->ticket_store = Input::get('ticket_store');
					$event->vod = Input::get('vod');
					$event->start_date = new DateTime(Input::get('start_date'));
					$event->finish_date = new DateTime(Input::get('finish_date'));
					$event->prizepool = Input::get('prizepool');
					$event->about = Input::get('about');
					$event->tags = Input::get('tags');
					
					$event->lan = ( Input::get('lan') ? 1 : 0);
					
					if(Input::get('lan') == true)
					{
						$event->location = Input::get('location');
						$event->latitude = Input::get('latitude');
						$event->longitude = Input::get('longitude');				
					}
					else
					{
						$event->location = 'Online';
						$event->latitude = '';
						$event->longitude = '';
					}
					
					$event->public_state = ( Input::get('public_state') ? 1 : 0);
													
					$event->save();
					
					$event_games = $event->eventGame()->get();
					$games = Input::get('games');
					
					foreach($event_games as $event_game)
					{
						if(! in_array($event_game->id, $games))
						{
							$event->eventGame($event_game)->detach();
						}
					}
					
					foreach ($games as $game)
					{
						$game_attach = Game::find($game);
						
						if(! $event->eventGame()->where('game_id', '=',$game_attach->id)->first())
						{	
							$event->eventGame()->attach($game_attach);
						}
					}
					
					$event_streams = $event->eventStream()->get();
					$stream_urls = Input::get('streams');
					
					foreach($event_streams as $event_stream)
					{
						if(! in_array($event_stream->stream_url, $stream_urls))
						{
							$event->eventStream($event_stream)->detach();
						}
					}
					
					
					foreach ($stream_urls as $stream_url) 
					{
					
					$stream_old = Stream::where('stream_url', '=', $stream_url)->first();
					
						if($stream_old == false && $stream_url)
							{
							$stream = new Stream();
							$stream->stream_url = $stream_url;
							
							$stream->save();
							$stream->streamEvent()->attach($event);
							}
						else
							{
								if(! $event->eventStream()->where('stream_id','=',$stream_old->id)->first())
								{
									$stream_old->streamEvent()->attach($event);
								}
							}
					}
					
					return Redirect::to('/')->with('global_success', 'Event submitted successfuly!');
				}
			
			return Redirect::to('/event/edit/'.$event->id)->withInput()->withErrors($validator)->with('message', 'Validation Errors!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$event = ep\Event::find($id);
		$event->eventGame()->detach();
		$event->eventStream()->detach();
		$event->delete();
		
		$extras = $event->eventExtra()->get();
		foreach($extras as $extra)
		{
			$extra->delete();
		}
		
		return Redirect::to('/neverland');
	}
	
	public function approve($id)
	{
		$event = ep\Event::find($id);
		$event->approved = '1';
		$event->save();
		
		Cache::forget('next_30');
		
		return Redirect::to('/neverland')->with('global_success', 'Event approved successfuly!');
	}
	
	public function favourite($id)
	{
		$user = Sentry::getUser();
		$event = ep\Event::find($id);
		$fav_check = $event->eventUser()->where('user_id','=',$user->id)->first();
		
		if($fav_check == false)
		{
			$event->eventUser()->attach($user, array('created_at' => new DateTime));
			
			return Redirect::to(URL::previous())->with('global_success', 'Event has been added to favourites.');
		}
		else
		{
			return Redirect::to(URL::to('/'))->with('global_error', 'This event already exists in your favourites.');
		}
	}
	
	public function unfavourite($id)
	{
		$user = Sentry::getUser();
		$event = ep\Event::find($id);
		$fav_check = $event->eventUser()->where('user_id','=',$user->id)->first();
		
		if($fav_check == false)
		{
			return Redirect::to(URL::to('/'))->with('global_error', 'This event doesn\'t exists in your favourites.');
		}
		else
		{
			$event->eventUser()->detach($user);	
			return Redirect::to(URL::previous())->with('global_success', 'Event has been removed from favourites.');
		}
	}

}