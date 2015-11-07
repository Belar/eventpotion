<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
            {
                //
            });


App::after(function($request, $response)
           {
               //
           });

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
              {
                  if (Auth::guest()) return Redirect::guest('login');
              });


Route::filter('auth.basic', function()
              {
                  return Auth::basic();
              });

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
              {
                  if (Auth::check()) return Redirect::to('/');
              });

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
              {
                  if (Session::token() != Input::get('_token'))
                  {
                      throw new Illuminate\Session\TokenMismatchException;
                  }
              });


/*Sentry version*/
Route::filter('authSentry', function()
              {
                  if (!Sentry::check()) {
                      return Redirect::guest('/login');
                  }
              });

/*
|--------------------------------------------------------------------------
| Admin/Mod Filter
|--------------------------------------------------------------------------
|
|	Admin/Mod filter for Sentry 2.
|
*/

Route::filter('admin', function()
              {
                  if(Sentry::check())
                  {

                      if (Sentry::getUser()->hasAccess('admin'))
                      {
                          // User has access to the given permission
                      }
                      else
                      {
                          return Redirect::to('/')->with('global_error', 'This is restricted area. You shall not pass.');
                      }	
                  }
                  else
                  {
                      return Redirect::guest('login');
                  }	

              });

Route::filter('mod', function()
              {
                  if(Sentry::check())
                  {

                      if (Sentry::getUser()->hasAccess('mod'))
                      {
                          // User has access to the given permission
                      }
                      else
                      {
                          return Redirect::to('/')->with('global_error', 'This is restricted area. You shall not pass.');
                      }	
                  }
                  else
                  {
                      return Redirect::guest('login');
                  }	

              });

/*
|--------------------------------------------------------------------------
| Author check
|--------------------------------------------------------------------------
|
|	Checks if currently logged in user is author of a resource. Based on URL segment.
|
*/

Route::filter('authorEvent', function()
              {
                  if(Sentry::check())
                  {

                      $event_id = Request::segment(3);
                      $event_author = ep\Event::find($event_id)->author_id;
                      $current_user = Sentry::getUser();

                      if ($current_user->id == $event_author || $current_user->hasAccess('admin'))
                      {

                      }
                      else
                      {
                          return Redirect::to('/')->with('global_error', 'This is restricted area. You shall not pass.');
                      }	
                  }
                  else
                  {
                      return Redirect::guest('login');
                  }	

              });

Route::filter('authorShow', function()
              {
                  if(Sentry::check())
                  {

                      $show_id = Request::segment(3);
                      $show_author = Show::find($show_id)->author_id;
                      $current_user = Sentry::getUser();

                      if ($current_user->id == $show_author || $current_user->hasAccess('admin'))
                      {

                      }
                      else
                      {
                          return Redirect::to('/')->with('global_error', 'This is restricted area. You shall not pass.');
                      }	
                  }
                  else
                  {
                      return Redirect::guest('login');
                  }	

              });

/*
|--------------------------------------------------------------------------
| Cache
|--------------------------------------------------------------------------
|
|	Caches current route. Don't use with hello view, it has custom cache per user.
|
*/

Route::filter('general_cache', function($route, $request, $response = null)
              {
                  if(Sentry::check()){

                  }
                  else
                  {
                      $key = 'route-'.Str::slug(Request::url());
                      if(is_null($response) && Cache::has($key))
                      {
                          return Cache::get($key);
                      }
                      elseif(!is_null($response) && !Cache::has($key))
                      {
                          Cache::put($key, $response->getContent(), 10);
                      }
                  }
              });
