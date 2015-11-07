@extends('allround.master')

@section('top')
@overwrite

@section('content')
<div id="beta-sign" class="container">
	<div id="reg-login-forms" class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="center-block text-center">
				<a href="/"><img src="{{{ URL::asset('img/logo.png') }}}" class="logo img-responsive"></a>
			</div>

			<h4>Login</h4>
			<p>Event Potion is currently in alpha phase and only very narrow group of people has access to the website. Please <a href="{{{ URL::to('/beta') }}}">sign up</a> to beta newsletter to be notified about the final launch and a chance for an early access.</p>

			<div class="form-body">
				@if(Sentry::check())
					<p>You are already logged in. Enjoy it!</p>
				@else
					{{ Form::open( array('url' => 'login', 'role' => 'form') ) }}

					@if(Session::has('login_error'))
						<div id="flash_notice" class="text-danger"><p>{{{ Session::get('login_error') }}}</p></div>
					@endif

					<div class="form-group">
						{{ Form::label('email', 'E-mail') }}
						{{ Form::text('email', '', array('class'=>'form-control')) }}
					</div>
					<div class="form-group">
						{{ Form::label('password', 'Password') }}
						{{ Form::password('password', array('class'=>'form-control')) }}
					</div>

					<div class="checkbox">
						{{ Form::checkbox('remember', false , true, array('class' => 'push-left')) }} Remember me
					</div>

					<p>Forgot your password? <a href="password/request">Restore it</a></p>

					<div class="clearfix"></div>
						{{ Form::submit('Sign In', array('class' => 'btn btn-primary')) }}
					{{ Form::close() }}
				@endif
			</div>
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
