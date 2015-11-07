@extends('allround.master')

@section('content')
<div class="container">
	<div class="row">
		<div id="reg-login-forms">
			<div class="col-md-6 col-md-offset-3">
				<h4>Add event</h4>			
				<div class="form-body">
					{{ Form::open(array('url' => 'game/add', 'role' => 'form')) }}
						<ul class="errors">
							@foreach($errors->all() as $message)
								<li class="text-danger">{{{ $message }}}</li>
							@endforeach
						</ul>
											
						<div class="form-group">
							{{ Form::label('title', 'Title') }}
							{{ Form::text('title', '', array('class'=>'form-control')) }}
						</div>
						<div class="form-group">
							{{ Form::label('game_icon', 'Icon') }}
							{{ Form::text('game_icon', '', array('class'=>'form-control')) }}
						</div>
															
						{{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}					
					{{ Form::close() }}
						
				</div>
			</div>
		</div>
	</div>
</div>
@stop