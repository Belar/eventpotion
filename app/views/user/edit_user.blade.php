@extends('allround.master')

@section('content')
<div class="container">
	<div class="row">
		<div id="reg-login-forms">
			<div class="col-md-6 col-md-offset-3">
				<h4>Edit profile</h4>
				<div class="form-body">
						{{ Form::open(array('url' => 'user/edit', 'role' => 'form')) }}
							<ul class="errors">
								@foreach($errors->all() as $message)
									<li class="text-danger">{{{ $message }}}</li>
								@endforeach
							</ul>
							
							<div class="form-group">
								{{ Form::label('nickname', 'Nickname') }}
								{{ Form::text('nickname', $user->nickname, array('class'=>'form-control','id' => 'disabledInput', 'disabled')) }}
							</div>	

							<div class="form-group">
								{{ Form::label('timezone', 'Timezone') }}		
								{{ Form::select('timezone', $timezones, $user->timezone, array('class'=>'form-control')) }}
							</div>
							
							<div class="form-group">
							{{ Form::label('games', 'Games') }}
							<div class="clearfix"></div>
								@foreach($games as $game)
									@if (in_array($game->id, $user_games))
										<div class="game-checkbox">
											{{ Form::checkbox('games[]', $game->id , true) }} {{{$game->title}}}
										</div>
									@else
										<div class="game-checkbox">
											{{ Form::checkbox('games[]', $game->id) }} {{{$game->title}}}
										</div>
									@endif
								@endforeach
							</div>
							
							{{ Form::submit('Update', array('class' => 'btn btn-primary')) }}					
						{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>	
</div>	
@stop