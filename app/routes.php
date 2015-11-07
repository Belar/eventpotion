<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('login', 'UserController@login');
Route::post('login', array('before' => 'csrf' ,'uses' =>'UserController@loginAction'));
Route::get('logout', array('uses' => 'UserController@logoutAction'));

Route::get('register', 'UserController@create');
Route::post('register', array('before' => 'csrf' ,'uses' => 'UserController@store'));
Route::get('register', 'UserController@create');
Route::get('activate/{activation_code}/{user_id}', array('uses' => 'UserController@activateUser'));

Route::get('password/request', 'UserController@passReset');
Route::post('password/request', 'UserController@passResetRequest');
Route::get('password/reset/{pass_code}', 'UserController@passResetForm');
Route::post('password/reset/', 'UserController@passResetAction');


/*Admin*/
Route::group(array('before' => 'admin'), function()
{

	/*GAME*/
	Route::get('game/add', array('before' => 'authSentry', 'uses' => 'GameController@create'));
	Route::post('game/add', array('before' => 'authSentry|csrf' ,'uses' => 'GameController@store'));

	/*USER*/
	Route::get('admin', 'AdminController@index');
	Route::get('user/ban/{id}', 'UserController@banUser');
	Route::get('user/unban/{id}', 'UserController@unbanUser');

	/*EVENT*/
	Route::get('event/approve/{id}', 'EventController@approve');
	Route::get('event/delete/{id}', 'EventController@destroy');

	/*SHOW*/
	Route::get('show/approve/{id}', 'ShowController@approve');
	Route::get('show/delete/{id}', 'ShowController@destroy');

	/*EXTRA*/
	Route::get('extra/approve/{id}', 'ExtraController@approve');
	Route::get('extra/delete/{id}', 'ExtraController@destroy');

	/*END OF ADMIN*/

});

/*blog*/
Route::group(array('before' => 'admin'), function()
{
    Route::get('blog/add', array('before' => 'authSentry', 'uses' => 'BlogController@create'));
    Route::post('blog/add', array('before' => 'authSentry|csrf' ,'uses' => 'BlogController@store'));

    Route::get('blog/edit/{id}', array('before' => 'authSentry', 'uses' => 'BlogController@edit'));
    Route::put('blog/edit/{id}', array('before' => 'authSentry|csrf' ,'uses' => 'BlogController@update'));
});

Route::get('blog/{id}', array('before'=>'general_cache', 'after'=>'general_cache', 'uses'=>'BlogController@show'));
Route::get('blog/tag/{tag}', 'BlogController@blogTag');
Route::get('blog', 'BlogController@index');



/*ep\EVENT*/

Route::get('event/add', array('before' => 'authSentry', 'uses' => 'EventController@create'));
Route::post('event/add', array('before' => 'authSentry|csrf' ,'uses' => 'EventController@store'));

Route::get('event/edit/{id}', array('before' => 'authSentry|authorEvent' ,'uses' => 'EventController@edit'));
Route::put('event/edit/{id}', array('before' => 'authSentry|authorEvent|csrf' ,'uses' => 'EventController@update'));

Route::get('event/favourite/{id}', array('before' => 'authSentry' ,'uses' => 'EventController@favourite'));
Route::get('event/unfavourite/{id}', array('before' => 'authSentry' ,'uses' => 'EventController@unfavourite'));
Route::get('event/tag/{tag}', 'EventController@eventTag');

Route::get('event/{id}', array('before'=>'general_cache', 'after'=>'general_cache', 'uses'=>'EventController@show'));

/*Events Generals*/
Route::get('/game/{id}', 'EventController@indexGame');

/*SHOW*/
Route::get('ecu', array('uses' => 'ShowController@index'));

Route::get('show/add', array('before' => 'authSentry', 'uses' => 'ShowController@create'));
Route::post('show/add', array('before' => 'authSentry|csrf' ,'uses' => 'ShowController@store'));

Route::get('show/edit/{id}', array('before' => 'authSentry|authorShow' ,'uses' => 'ShowController@edit'));
Route::put('show/edit/{id}', array('before' => 'authSentry|authorShow|csrf' ,'uses' => 'ShowController@update'));

Route::get('show/favourite/{id}', array('before' => 'authSentry' ,'uses' => 'ShowController@favourite'));
Route::get('show/unfavourite/{id}', array('before' => 'authSentry' ,'uses' => 'ShowController@unfavourite'));

Route::get('show/tag/{tag}', 'ShowController@showTag');

Route::get('show/{id}', array('before'=>'general_cache', 'after'=>'general_cache', 'uses'=>'ShowController@show'));

/*EXTRA*/
Route::get('extras', array('before' => 'authSentry|admin', 'uses' => 'ExtraController@index'));

/*USER*/

Route::get('password/change', array('before' => 'authSentry' ,'uses' => 'UserController@passChange'));
Route::put('password/changing', array('before' => 'authSentry|csrf' ,'uses' => 'UserController@passChangeAction'));

Route::get('user/edit', array('before' => 'authSentry' ,'uses' => 'UserController@edit'));
Route::post('user/edit', array('before' => 'authSentry|csrf' ,'uses' => 'UserController@update'));

/*Extras*/
Route::post('extra/add', array('before' => 'authSentry|csrf' ,'uses' => 'ExtraController@store'));

/*DASHBOARD*/
Route::get('/dashboard', array('before' => 'authSentry', 'uses' => 'UserController@dashboard'));


Route::post('/beta', 'BetaController@store');
Route::get('/beta/activate/{activation_code}', 'BetaController@activateBeta');
Route::get('/beta', function()
{
	return View::make('beta.invite');
});


Route::get('/faq', function()
{
	return View::make('allround.faq');
});
Route::get('/about', function()
{
	return View::make('allround.about');
});
Route::get('/tos', function()
{
	return View::make('allround.tos');
});

Route::get('/', 'EventController@index');

/*BETA SIGNUP SECTION*/
/*Route::get('/beta', function()
{

	   return View::make('beta.landing');
});*/
