@extends('allround.master')

@section('top')
@overwrite

@section('content')
	<div id="beta-sign" class="container">
		<div class="row col-md-4 col-md-offset-4">
			<div class="center-block text-center">
				<a href="/"><img src="{{{ URL::asset('img/logo.png') }}}" class="logo img-responsive"></a>
			</div>

			<p>
				After a break, Event Potion is coming back to bring you information about shows, tournaments, leagues and LAN events. Everything with new, improved platform and refreshed idea of events calendar which will make enjoying eSports events even more comfortable.
			</p>
			<p>
				Beta is <span class="orange">ON</span>, if you didn't sign up, you can ask your friend who did, to invite you.
			</p>
            <p>
				If you signed up for beta, you can now <a href="{{{ URL::to('/register') }}}">register</a> with e-mail address you signed up. If you already registered, just <a href="{{{ URL::to('/login') }}}">login.</a>
			</p>
			<div class="clearfix"></div>
			<div class="social-media text-center">
				<a href="http://twitter.com/eventpotion"><img src="{{{ URL::asset('/img/twitter.png') }}}"></a>
				<a href="http://facebook.com/eventpotion"><img src="{{{ URL::asset('/img/facebook.png') }}}"></a>
			</div>
		</div>
	</div>
@stop

@section('foot')
	<div id="beta-foot" class="container">
		<p class="text-muted text-center"><small>
		© 2012-2013 Event Potion All Rights Reserved
		</small></p>
	</div>
@overwrite
