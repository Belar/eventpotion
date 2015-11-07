<div id="sidebar">
	@if(Sentry::check())
		<div class="panel-group" id="accordion">
		  <div class="panel panel-default">
			<div class="panel-heading">
			  <h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
					Setup
				</a>
			  </h4>
			</div>
			<div id="collapseOne" class="panel-collapse collapse">
			  <div class="panel-body">
					<p><i class="fa fa-moon-o"></i>{{ $user->timezone }} <small class="pull-right"><a href="/user/edit">Change</a></small></p>
					<p><i class="fa fa-gamepad"></i> 
					@foreach($user->userGame()->get() as $game)
						<img src="{{{ URL::asset('/images/icons/'.$game->game_icon.'_icon.png') }}}">
					@endforeach
					<small class="pull-right"><a href="/user/edit">Change</a></small></p>
			  </div>
			</div>
		  </div>
		  <div class="panel panel-default">
			<div class="panel-heading">
			  <h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
					Favourites
				</a>
			  </h4>
			</div>
			<div id="collapseThree" class="panel-collapse collapse in">
			  <div class="panel-body">
				<table class="table table-striped">
				@foreach($user_favs as $user_fav)
					<tr>
						<td class="fav_icon">
							@if ($user_fav->eventUser()->where('user_id','=', Sentry::getUser()->id)->first())
								<a href="{{{ URL::to('/event/unfavourite/'.$user_fav->id) }}}"><i class="fa fa-star"></i></a>
							@else
								<a href="{{{ URL::to('/event/favourite/'.$user_fav->id) }}}"><i class="fa fa-star-o"></i></a>
							@endif
						</td>
						<td><a href="{{{ URL::to('/event/'.$user_fav->slug) }}}">{{{ $user_fav->title }}}</a></td>
					</tr>					
				@endforeach
				</table>
			  </div>
			</div>
		  </div>
		</div>
		
		<div class="beta-board">
		<h4>Info Board</h4>
		<ul>
			<li>It's live! Thanks everyone for testing during beta, for hints, suggestions and bug reports. Looking forward to introduce new options.</li>
		</ul>
		</div>

	@else
		<div id="signup-why">
			<h3>Why register?</h3>
			<ul>
				<li>Set prefered timezone</li>
				<li>Favourite events for fast and easy access</li>
				<li>Add your own events and manage whole data via dashboard</li>
				<li>Link your content (interviews, highlights etc.) to events</li>
				<li>Verify your status as content creator/owner/provider (Your events, shows and extras will be live immidietly after submission)</li>
				<li>and more...</li>
			</ul>
			<a class="btn btn-primary" href="{{{ URL::to('/register') }}}">Register now</a>
		</div>
	@endif
</div>