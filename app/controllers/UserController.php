<?php

class UserController extends \BaseController {

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
	 * Dashboard for user's content management, only for auth user.
	 */
	public function dashboard()
	{	
		$user = Sentry::getUser();
		$added_events = ep\Event::where('author_id', '=', $user->id)->orderBy('created_at', 'DESC')->paginate(25);
		$added_shows = Show::where('author_id', '=', $user->id)->orderBy('created_at', 'DESC')->paginate(25);
		return View::make('user.dashboard', array('user' => $user, 'added_events' => $added_events, 'added_shows' => $added_shows, 'pageTitle' => 'Dashboard' ));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('user.register');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Fetch all request data.
		$data = Input::only('nickname', 'email', 'password', 'password_confirmation', 'tos', 'city');
		// Build the validation constraint set.
		$rules = array(
			//'nick' => array('required', 'min:3', 'max:32', 'unique:users,nick', 'not_in:admin,Admin,Moderator,Mod,Administrator'),
			'email' => array('required', 'email', 'unique:users,email'),
			'password' => array('required', 'confirmed', 'min:5'),
			'tos' => array('accepted'),
			'city' => array('size:0'),
		);
		// Create a new validator instance.
		$validator = Validator::make($data, $rules);
			if ($validator->passes()) {
				
				$user = Sentry::register(array(
						'nickname'    => Input::get('nickname'),
						'email'    => Input::get('email'),
						'password' => Input::get('password'),
					));
				$activationCode = $user->getActivationCode();
				
				Mail::send('emails.activate', array('activation_code' => $activationCode, 'user_id' => $user->id, 'nick' => Input::get('nick')), function($message)
					{
					$message->to(Input::get('email'), Input::get('nick'))->subject('Welcome!');
					});
				
				return Redirect::to('/')->with('global_success', 'Activation code has been sent to your email address.');
			}
		return Redirect::to('/register')->withInput()->withErrors($validator)->with('message', 'Validation Errors!');
	}

	public function activateUser($activation_code, $user_id)
	{	
		try
			{
				// Find the user using the user id
				$user = Sentry::findUserById($user_id);

				// Attempt to activate the user
				if ($user->attemptActivation($activation_code))
				{
					return Redirect::to('/login')->with('global_success', 'Your profile is now active and you can sign in.');
				}
				else
				{
					return Redirect::to('/')->with('global_error', 'Activation failed, please try again or contact support.');
				}
			}
			catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
			{
				return Redirect::to('/register')->with('global_error', 'User was not found. If you didn\'t register yet, do it now please.');
			}
			catch (Cartalyst\Sentry\Users\UserAlreadyActivatedException $e)
			{
				return Redirect::to('/login')->with('global_error', 'Your account is already active. You can sign in.');
			}
	}
	
	public function passReset()
	{
		return View::make('user.request');
	}
	
	public function passResetRequest()
	{
		try
		{
			// Find the user using the user email address
			$user = Sentry::findUserByLogin(Input::get('email'));

			// Get the password reset code
			$resetCode = $user->getResetPasswordCode();

			// Now you can send this code to your user via email for example.
			
			Mail::send('emails.pass_reset', array('pass_code' => $resetCode, 'nick' => $user->nick), function($message)
					{
						$user = Sentry::findUserByLogin(Input::get('email'));
						$message->to($user->email, $user->nick)->subject('Password reset');
					});
					
			return Redirect::to('/')->with('global_success', 'Link with reset authorization has been sent to your e-mail address. ');
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			return Redirect::to('/password/request')->with('global_error', 'There is no account associated with this e-mail address.');
		}
	}
	
	public function passResetForm($pass_code)
	{
		return View::make('user.reset', array('pageTitle' => 'Password reset'))->with('pass_code', $pass_code);
	}
	
	public function passResetAction()
	{
		// Fetch all request data.
		$data = Input::only('email', 'password', 'password_confirmation', 'pass_code');
		// Build the validation constraint set.
		$rules = array(
			'email' => array('required'),
			'password' => array('required', 'confirmed', 'min:5'),			
		);
		
		$validator = Validator::make($data, $rules);
		if ($validator->passes()) 
		{	
			$user = Sentry::findUserByLogin(Input::get('email'));
			// Check if the reset password code is valid
			if ($user->checkResetPasswordCode(Input::get('pass_code')))
			{
				// Attempt to reset the user password
				if ($user->attemptResetPassword(Input::get('pass_code'), Input::get('password')))
				{
				
					return Redirect::to('/login')->with('global_success', 'Password has been set. You can now sign in with your new password.');
					
				}
				else
				{
					return Redirect::to('/password/reset')->with('global_error', 'System couldn\'t change your password. Please try again and if situation repeats, report to hello@librific.com.');
				}
			}
			else
			{
				return Redirect::to('/password/reset')->with('global_error', 'Your reset code doesn\'t match. It may be corrupted or outdated. Please make a new request.');
			}
		}
		return Redirect::to('/password/reset/'.Input::get('pass_code'))->withErrors($validator)->with('message', 'Validation Errors!');
	}

	
	public function login()
	{
		if ( ! Sentry::check())
			{
				return View::make('user.login');	
			}
			else
			{
				return Redirect::to('/')->with('global_error', 'You are already logged in.');
			}
	}
	
	public function loginAction()
	{
		try
			{
				Input::only('email', 'password','remember');
				// Set login credentials
				$credentials = array(
					'email'    => Input::get('email'),
					'password' => Input::get('password'),
				);
			
				// Try to authenticate the user
				if(Input::get('remember') == true){
					$user = Sentry::authenticateAndRemember($credentials);
				}
				else{
					$user = Sentry::authenticate($credentials);
				}
				
				return Redirect::intended('/')->with('global_success', 'You are now logged in.');
			}
			catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
			{
				return Redirect::to('/login')->with('login_error', 'Login field is required.');
			}
			catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
			{
				return Redirect::to('/login')->with('login_error', 'Password field is required.');
			}
			catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
			{
				return Redirect::to('/login')->with('login_error', 'Your username/password combination was incorrect.');
			}
			catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
			{
				return Redirect::to('/login')->with('login_error', 'Your username/password combination was incorrect.');
			}
			catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
			{
				return Redirect::to('/login')->with('login_error', 'You need to activate your account before log in.');
			}
			
			// The following is only required if throttle is enabled
			catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
			{
				return Redirect::to('/')->with('global_error', 'Depends on violation, your account has been suspended or banned.');
			}
			catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
			{
				return Redirect::to('/')->with('global_error', 'Depends on violation, your account has been suspended or banned.');
			}
	}
	
	public function logoutAction()
	{
		if ( ! Sentry::check())
			{
				return View::make('user.login');	
			}
			else
			{
				Sentry::logout();
				return Redirect::to('/')->with('global_success', 'Logged out');
			}
	}
	
		/*Password change*/
	
	public function passChange()
	{
		$user_pass_change = User::find( Sentry::getUser()->id );
		
		return View::make('user.pass_change', array('user' => $user_pass_change, 'pageTitle' => 'Password changing'));
	}
	
	public function passChangeAction()
	{
		// Fetch all request data.
		$data = Input::only('password', 'password_confirmation', 'old_password');
		
		if (
		Auth::attempt(
					array(
						'password' => Input::get('old_password')
						)
					)
			)
		{
			$rules = array(
				'password' => array('required', 'confirmed', 'different:old_password', 'min:5')
			);
			// Create a new validator instance.
			$validator = Validator::make($data, $rules);
				if ($validator->passes()) {
					
					$user = User::find(Input::get('id'));
					$user->password = Hash::make(Input::get('password'));
					$user->save();
					
					return Redirect::to('/')->with('global_success', 'Password has been changed.');
				}
			return Redirect::to('/password/change')->withInput()->withErrors($validator)->with('message', 'Validation Errors!');
		}
		else {
			//Return after failed authentication with old pass
			return Redirect::to('/password/change')->with('old_pass_error', 'Your old password is incorrect.');
		}
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
	public function edit()
	{
		$user = User::find(Sentry::getuser()->id);
		
		$timezones = Cache::rememberForever('timezones', function()
		{
			static $regions = array(
				DateTimeZone::AFRICA,
				DateTimeZone::AMERICA,
				DateTimeZone::ANTARCTICA,
				DateTimeZone::ASIA,
				DateTimeZone::ATLANTIC,
				DateTimeZone::AUSTRALIA,
				DateTimeZone::EUROPE,
				DateTimeZone::INDIAN,
				DateTimeZone::PACIFIC,
			);

			$timezones = array();
			foreach( $regions as $region )
			{
				$timezones = array_merge( $timezones, DateTimeZone::listIdentifiers( $region ) );
			}

			$timezone_offsets = array();
			foreach( $timezones as $timezone )
			{
				$tz = new DateTimeZone($timezone);
				$timezone_offsets[$timezone] = $tz->getOffset(new DateTime);
			}

			// sort timezone by offset
			asort($timezone_offsets);

			$timezone_list = array();
			foreach( $timezone_offsets as $timezone => $offset )
			{
				$offset_prefix = $offset < 0 ? '-' : '+';
				$offset_formatted = gmdate( 'H:i', abs($offset) );

				$pretty_offset = "UTC${offset_prefix}${offset_formatted}";

				$timezone_list[$timezone] = "$timezone (${pretty_offset}) ";
			}

			return $timezone_list;
		});
		
		Cache::forget('timezones');
		
		$user_games = $user->userGame()->lists('game_id');
       
        $key = 'events'.Sentry::getUser()->id;
        Cache::forget($key);
		
		return View::make('user.edit_user', array('user'=>$user, 'timezones'=>$timezones, 'user_games'=>$user_games));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update()
	{
				// Fetch all request data.
		$data = Input::only('timezone', 'games');
		// Build the validation constraint set.
		$rules = array(
			'timezone' => array('regex:([0-9a-zA-Z /+-]+)'),
		);
		// Create a new validator instance.
		$validator = Validator::make($data, $rules);
			if ($validator->passes()) {
				
				try
				{
					// Find the user using the user id
					$user = User::find(Sentry::getuser()->id);

					// Update the user details
					$user->timezone = Input::get('timezone');
					
					$user_games = $user->userGame()->get();
					$games = Input::get('games');
					
					foreach($user_games as $user_game)
					{
						if($games && ! in_array($user_game->id, $games))
						{
							$user->userGame($user_game)->detach();
						}
						elseif($games == false)
						{
							$user->userGame($user_game)->detach();
						}
					}
					
					if($games)
					{
						foreach ($games as $game)
						{
							$game_attach = Game::find($game);
							
							if(! $user->userGame()->where('game_id', '=',$game_attach->id)->first())
							{	
								$user->userGame()->attach($game_attach);
							}
						}
					}

					// Update the user
					if ($user->save())
					{
						return Redirect::to('/user/edit')->with('global_success', 'Profile has been updated.');
					}
					else
					{
						return Redirect::to('/user/edit')->with('global_error', 'We couldn\'t update your profile, pelase try again or contactu us if situation repeats.');
					}
				}
				catch (Cartalyst\Sentry\Users\UserExistsException $e)
				{
					echo 'User with this login already exists.';
				}
				catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
				{
					echo 'User was not found.';
				}

			}
		return Redirect::to('/user/edit')->withInput()->withErrors($validator)->with('message', 'Validation Errors!');
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
		
	public function banUser($id)
	{
		$user = Sentry::findUserByID($id);
		if (!$user->hasAccess('admin'))
		{
			try
			{
				// Find the user using the user id
				$throttle = Sentry::findThrottlerByUserId($id);

				// Ban the user
				$throttle->ban();
				
				return Redirect::to('/neverland')->with('global_success', 'User banned successfully banned.');
			}
			catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
			{
				return Redirect::to('/neverland')->with('global_error', 'There is no such user.');
			}
		}
		else
		{
			return Redirect::to('/neverland')->with('global_error', 'You can\'t ban Admin');
		}
	
	}
	
	public function unbanUser($id)
	{
		try
		{
			// Find the user using the user id
			$throttle = Sentry::findThrottlerByUserId($id);

			// Unban the user
			$throttle->unban();
			
			return Redirect::to('/neverland')->with('global_success', 'User UNbanned successfully.');
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			return Redirect::to('/neverland')->with('global_error', 'There is no such user.');
		}
	}
	

}