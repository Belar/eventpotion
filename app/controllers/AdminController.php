<?php

class AdminController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::all();

		$events_submitted = ep\Event::where('approved','=', '0')->get();
		$event_count = ep\Event::all()->count();

		$shows_submitted = Show::where('approved','=', '0')->get();
		$show_count = Show::all()->count();

		$extras_submitted = Extra::where('approved','=', '0')->get();
		$extra_count = Extra::all()->count();

		$beta_count =  DB::table('beta_newsletters')->count();

		return View::make('admin.admin_panel' , array(
		'pageTitle' => 'Admin Panel',
		'users' => $users,
		'event_count' => $event_count,
		'events_submitted'=>$events_submitted,
		'show_count' => $show_count,
		'shows_submitted'=>$shows_submitted,
		'extra_count' => $extra_count,
		'beta_count' => $beta_count,
		'extras_submitted'=>$extras_submitted));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
