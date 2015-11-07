@extends('allround.master')

@section('content')
<div class="container">
	<div class="row">
		<div id="reg-login-forms">
			<div class="col-md-6 col-md-offset-3">
				<h4>Register</h4>
				<div class="form-body">
					@if(Auth::check())
						<p>You are already logged in. If you still would like to register a new account, you need to <a href="/logout">log out.</a></p>
					@else
						{{ Form::open(array('url' => 'register', 'role' => 'form')) }}
							<ul class="errors">
								@foreach($errors->all() as $message)
									<li class="text-danger">{{{ $message }}}</li>
								@endforeach
							</ul>
							
							<div class="form-group">
								{{ Form::label('nickname', 'Nickname') }}
								{{ Form::text('nickname', Input::old('nickname'), array('class'=>'form-control')) }}
							</div>							
							<div class="form-group">
								{{ Form::label('email', 'Email address') }}
								{{ Form::email('email', Input::old('email'), array('class'=>'form-control')) }}
							</div>
							<div class="form-group">
								{{ Form::label('password', 'Password') }}
								{{ Form::password('password', array('class'=>'form-control')) }}
							</div>
							<div class="form-group">
								{{ Form::label('password_confirmation', 'Password confirmation') }}
								{{ Form::password('password_confirmation', array('class'=>'form-control')) }}
							</div>
							
							<div class="form-group">
								<p class="sr-only">Don't fill this field, leave it empty. Thank you.</p>
								{{ Form::hidden('city','', array('class'=>'form-control')) }}
							</div>
							
							<div class="checkbox">
									{{ Form::checkbox('tos', 'yes') }} I agree to the <a href="/tos">terms of service.</a>
							</div>
																
							{{ Form::submit('Register', array('class' => 'btn btn-primary')) }}					
						{{ Form::close() }}
						
					@endif
				</div>
			</div>
		</div>
	</div>	
</div>	
@stop