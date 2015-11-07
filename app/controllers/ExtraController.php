<?php

class ExtraController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$extras = Cache::remember('extras_global', 10, function()
			{
			return Extra::where('approved','=','1')->take(25)->orderBy('created_at')->get();
			});	
		
		return View::make('extra.index_extra', array('extras' => $extras));
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
			// Fetch all request data.
			$data = Input::only('title', 'extra_url', 'event_id');
			$event_id = Input::get('event_id');
			// Build the validation constraint set.
			$rules = array(
				'title' => array('required', 'min:3'),
				'extra_url' => array('required', 'Url'),
				'event_id' => array('required', 'integer','sometimes'),
			);
			// Create a new validator instance.
			$validator = Validator::make($data, $rules);
				if ($validator->passes()) {
									
					$extra = new Extra();
                    
                    $current_user = Sentry::getUser();
                    if( $current_user->hasAccess('admin') || $current_user->hasAccess('verified') )
					{
						$extra->approved = '1';
					}
										
					$extra->author_id = Sentry::getUser()->id;	
					$extra->title = Input::get('title');				
					$extra->extra_url = Input::get('extra_url');				
					$extra->save();
					
					
					$event = ep\Event::find($event_id);
					$event->eventExtra()->save($extra);
										
					return Redirect::to('/event/'.$event->slug)->with('global_success', 'Event submitted successfuly!');
				}
			
			return Redirect::to('/event/'.$event->slug)->withInput()->withErrors($validator)->with('message', 'Validation Errors!');
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
		$extra = Extra::find($id);
		$extra->delete();

		return Redirect::to('/neverland');
	}
	
	public function approve($id)
	{
		$extra = Extra::find($id);
		$extra->approved = '1';
		$extra->save();
		
		return Redirect::to('/neverland')->with('global_success', 'Extra approved successfuly!');
	}

}