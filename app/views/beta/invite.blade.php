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
				Sign up with your e-mail address to receive notification about the final launch and a chance for an early access.
			</p>

			<div class="beta-form">
				{{ Form::open(array('url' => 'beta', 'class'=>'form-signin')) }}


					<ul class="errors">
						@foreach($errors->all() as $message)
							<li class="text-danger">{{{ $message }}}</li>
						@endforeach
					</ul>

				  {{ Form::label('email', 'Description', array('class'=>'sr-only')) }}
				  {{ Form::email('email','', array('placeholder' => 'Email address', 'class' => 'form-control' )) }}
				  {{ Form::submit('Submit', array('class' => 'btn-submit btn btn-primary pull-right')) }}

				{{ Form::close() }}
			</div>
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
