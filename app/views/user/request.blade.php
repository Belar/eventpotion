@extends('allround.master')

@section('content')
<div class="container">
	<div id="reg-login-forms" class="row">
		<div class="col-md-6 col-md-offset-3">
			<h3>Password change request</h3>
			<div class="form-body">
				@if (Session::has('error'))
					{{{ trans(Session::get('reason')) }}}
				@elseif (Session::has('success'))
					An e-mail with the password reset has been sent.
				@endif
				
				{{ Form::open(array('url' => 'password/request', 'role' => 'form')) }}

				<div class="form-group">
							{{ Form::label('email', 'Email address') }}
							{{ Form::email('email', Input::old('email'), array('class'=>'form-control')) }}
						</div>
				{{ Form::submit('Request', array('class' => 'btn btn-primary')) }}					
				{{ Form::close() }}	
				
			</div>
		</div>
	</div>
</div>
@stop