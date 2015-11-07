<?php

class GameController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('game.add_game');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
						// Fetch all request data.
			$data = Input::only('title', 'game_icon');
			// Build the validation constraint set.
			$rules = array(
				'title' => array('required'),				
			);
			// Create a new validator instance.
			$validator = Validator::make($data, $rules);
				if ($validator->passes()) {
									
					$game = new Game();					
					$title = Input::get('title');					
					//$uniqid = str_shuffle(uniqid());
					$game->slug = Str::slug($title, '-');
					
					$game->title = $title;
					$game->game_icon = Input::get('game_icon');
					$game->save();
					
					Cache::forget('games');
					
					return Redirect::to('/')->with('global_success', 'Game submitted successfully!');
				}
			
			return Redirect::to('/game/add')->withInput()->withErrors($validator)->with('message', 'Validation Errors!');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}