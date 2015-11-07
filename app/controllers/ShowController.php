<?php

class ShowController extends \BaseController {


	// Show VODs

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $shows = Cache::remember('shows', 15, function()
				{
		return Show::where('approved', '=', '1')->orderBy( 'air_date', 'desc')->get();
                });
                                
		if(Sentry::check() && Sentry::getUser()->timezone){
			return View::make('show.index_show_tz', array('shows' => $shows, 'pageTitle' => 'Esports Catch Up' ));
		}
		
		return View::make('show.index_show', array('shows' => $shows, 'pageTitle' => 'Esports Catch Up' ));
	}
	
	public function showTag($tag)
	{
			
		$shows = Show::where('tags', 'LIKE', '%'.$tag.'%')->orderBy('air_date', 'desc')->get();
		
		if(Sentry::check() && Sentry::getUser()->timezone){
			return View::make('show.index_show_tz', array('shows' => $shows, 'pageTitle' => 'Show Index'));
		}
		
		return View::make('show.index_show', array('shows' => $shows, 'pageTitle' => 'Show Index'));
	
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('show.add_show');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
					// Fetch all request data.
			$data = Input::only('title','show_icon', 'games', 'stream', 'people', 'vods', 'start_date','about', 'tags');
			// Build the validation constraint set.
			$rules = array(
				'title' => array('required', 'min:3'),
				'show_icon' => array('required', 'alpha_dash'),
				'games' => array('required'),	
				'start_date' => array('required','date'),
				'people' => array('required'),
				'about' => array('max:21800'),
				'stream' => array('alpha_dash'),
				'vods' => array('max:21800'),		
			);
			// Create a new validator instance.
			$validator = Validator::make($data, $rules);
				if ($validator->passes()) {
				
					$current_user = Sentry::getUser();
									
					$show = new Show();
					$show->author_id = $current_user->id;
						
						$title = Input::get('title');				
						$uniqid = str_shuffle(uniqid());
					$show->slug = Str::slug($title, '-').'-'.$uniqid;
										
					$show->title = $title;
									
					$show->show_icon = Input::get('show_icon');
					$show->air_date = new DateTime(Input::get('start_date'));
					
					$show->people = Input::get('people');
					$show->about = Input::get('about');
					$show->vods = Input::get('vods');
					$show->tags = Input::get('tags');
				
					if( $current_user->hasAccess('admin') || $current_user->hasAccess('verified') )
					{
						$show->approved = '1';
					}
													
					$show->save();
					
					$games = Input::get('games');
					foreach ($games as $game)
					{
						$game_id = Game::find($game);
						$show->showGame()->attach($game_id);
					}
					
					
					if($stream_url = trim(Input::get('stream')))
					{	
						
							
							$stream_old = Stream::where('stream_url', '=', $stream_url)->first();
							
								if($stream_old == false && $stream_url)
									{
									$stream = new Stream();
									$stream->stream_url = $stream_url;
									
									$stream->save();
									$stream->streamShow()->attach($show);
									}
								else
									{
										if(! $show->showStream($stream_old->id)->first())
										{
											$stream_old->streamShow()->attach($show);
										}
									}
					}

						return Redirect::to('/')->with('global_success', 'Show submitted successfuly!');
				}
			
			return Redirect::to('/show/add')->withInput()->withErrors($validator)->with('message', 'Validation Errors!');
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
			$show = Show::where('id','=',$id)->orWhere('slug','=',$id)->first();
			$stream = $show->showStream()->first();
			$games = $show->showGame()->get();
			return View::make('show.show_show_tz', array('pageTitle' => $show->title, 'show'=>$show, 'stream'=>$stream, 'games'=>$games));
		}
		
		$show = Show::where('id','=',$id)->orWhere('slug','=',$id)->first();
		$stream = $show->showStream()->first();
		$games = $show->showGame()->get();
		return View::make('show.show_show', array('pageTitle' => $show->title, 'show'=>$show, 'stream'=>$stream, 'games'=>$games));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
	
		$show = Show::find($id);
		$stream = $show->showStream()->first();
		$show_games = $show->showGame()->lists('game_id');
		return View::make('show.edit_show', array('show'=>$show, 'stream'=>$stream, 'show_games'=>$show_games));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{	
			$show = Show::find($id);
			
			$data = Input::only('title','show_icon', 'games', 'stream', 'people', 'vods', 'start_date','about', 'tags');
			// Build the validation constraint set.
			$rules = array(
				'title' => array('required', 'min:3'),
				'show_icon' => array('required', 'alpha_dash'),
				'games' => array('required'),	
				'start_date' => array('required','date'),
				'people' => array('required'),
				'about' => array('max:21800'),
				'stream' => array('alpha_dash'),
				'vods' => array('max:21800'),		
			);
			// Create a new validator instance.
			$validator = Validator::make($data, $rules);
				if ($validator->passes()) {
					
						
					
					$title = Input::get('title');	
					
					if ($show->title !== $title)
						{
						$uniqid = str_shuffle(uniqid());
						$show->slug = Str::slug($title, '-').'-'.$uniqid;
						$show->title = $title;
						}
					
					$show->show_icon = Input::get('show_icon');
					
					$show->air_date = new DateTime(Input::get('start_date'));
					
					$show->people = Input::get('people');
					$show->about = Input::get('about');
					$show->tags = Input::get('tags');
					$show->vods = Input::get('vods');
													
					$show->save();
					
					$show_games = $show->showGame()->get();
					$games = Input::get('games');
					
					foreach($show_games as $show_game)
					{
						if(! in_array($show_game->id, $games))
						{
							$show->showGame($show_game)->detach();
						}
					}
					
					foreach ($games as $game)
					{
						$game_attach = Game::find($game);
						
						if(! $show->showGame()->where('game_id', '=',$game_attach->id)->first())
						{	
							$show->showGame()->attach($game_attach);
						}
					}
					
					$show_stream = $show->showStream()->first();
					$stream_url = trim(Input::get('stream'));
					
					if( $show_stream && $show_stream->stream_url !== $stream_url)
					{
						$show->showStream($show_stream)->detach();
					}
					elseif($show_stream && $stream_url == false){
						$show->showStream($show_stream)->detach();
					}
					
					if($stream_url)
					{	
						$stream_old = Stream::where('stream_url', '=', $stream_url)->first();
						
							if($stream_old == false && $stream_url)
								{
								$stream = new Stream();
								$stream->stream_url = $stream_url;
								
								$stream->save();
								$stream->streamShow()->attach($show);
								}
							else
								{
									if(! $show->showStream()->where('stream_id','=',$stream_old->id)->first())
									{
										$stream_old->streamShow()->attach($show);
									}
								}
					}
					return Redirect::to('/')->with('global_success', 'Show submitted successfuly!');
				}
			
			return Redirect::to('/show/edit/'.$show->id)->withInput()->withErrors($validator)->with('message', 'Validation Errors!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$show = Show::find($id);
		$show->showGame()->detach();
		$show->showStream()->detach();
		$show->delete();
		
		return Redirect::to('/neverland');
	}
	
	public function approve($id)
	{
		$show = Show::find($id);
		$show->approved = '1';
		$show->save();
		
		Cache::forget('shows');
		
		return Redirect::to('/neverland')->with('global_success', 'Event approved successfuly!');
	}
	
	public function favourite($id)
	{
		$user = Sentry::getUser();
		$show = Show::find($id);
		$fav_check = $show->showUser()->where('user_id','=',$user->id)->first();
		
		if($fav_check == false)
		{
			$show->showUser()->attach($user, array('created_at' => new DateTime));
			
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
		$show = Show::find($id);
		$fav_check = $show->showUser()->where('user_id','=',$user->id)->first();
		
		if($fav_check == false)
		{
			return Redirect::to(URL::to('/'))->with('global_error', 'This show doesn\'t exists in your favourites.');
		}
		else
		{
			$show->showUser()->detach($user);	
			return Redirect::to(URL::previous())->with('global_success', 'Show has been removed from favourites.');
		}
	}

}