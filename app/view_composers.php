<?php

View::composer(array('allround.master', 'event.add_event', 'event.edit_event','show.add_show','show.edit_show', 'user.edit_user'), function($view){

	$games = Cache::rememberForever('games', function()
	{
		return Game::all();
	});
    $view->with('games', $games);

});

View::composer(array('allround.hello','allround.hello_tz','event.index_game', 'event.index_game_tz', 'show.index_show', 'show.index_show_tz', 'user.dashboard'), function($view){
    
    if(Sentry::check()){
	$user = User::find(Sentry::getUser()->id);
	$user_favs = $user->userEvent()->get();
	$user_favs_shows = $user->userShow()->get();
    $view->with(array('user'=>$user, 'user_favs'=>$user_favs, 'user_favs_shows'=>$user_favs_shows));
    }
});

