@extends('allround.master')

@section('content')
<div class="container">
		<div id="dashboard" class="row">
			<div class="col-md-8">
		
				
				<!-- Nav tabs -->
	<ul class="nav nav-tabs">
	  <li><a href="#users" data-toggle="tab">Users</a></li>
	  <li><a href="#events_submitted" data-toggle="tab">Events <span class="badge">{{{ $events_submitted->count() }}}</span></a></li>
	  <li><a href="#shows_submitted" data-toggle="tab">Shows <span class="badge">{{{ $shows_submitted->count() }}}</span></a></li>
	  <li><a href="#extras_submitted" data-toggle="tab">Extras <span class="badge">{{{ $extras_submitted->count() }}}</span></a></li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div id="users" class="tab-pane table-responsive">
			<table class="table table-striped">
				<tr>
				<th>#</th>
				<th>Nick</th>
				<th>Last login</th>
				<th>Options</th>				
				</tr>

				@foreach($users as $user)
					<tr>
					<td>{{{ $user->id }}}</td>
					<td>{{{ $user->nickname }}}</td>
					<td>{{{ $user->last_login }}}</td>
					<td>
							
						@if(Sentry::findThrottlerByUserId($user->id)->isBanned())
							<a href="user/unban/{{{ $user->id }}}"><span class="glyphicon glyphicon-thumbs-up redish"></a>
						@else
							<a href="user/ban/{{{ $user->id }}}"><span class="glyphicon glyphicon-thumbs-down"></a>
						@endif
						
						
					</td>
					</tr>
				@endforeach
			</table>
		</div>
		
		<div id="events_submitted" class="tab-pane table-responsive active" >
			<table class="table table-striped">
				 <tr>
					<th>Event</th>
					<th>Where</th>
					<th>When</th>
					<th>Prizepool</th>
					<th></th>
				  </tr>
			@foreach($events_submitted as $event_submitted)
			  <tr>
				<td>{{{ $event_submitted->title }}}</td>
				<td>{{{$event_submitted->location }}}</td>
				<td>{{{ date("d", strtotime($event_submitted->start_date)) }}}-{{{ date("d/m/Y", strtotime($event_submitted->finish_date)) }}}<br> {{{ date("H:i", strtotime($event_submitted->start_time)) }}}</td>
				<td>{{{ $event_submitted->prizepool }}}</td>
				<td>
					<a href="{{{ URL::to('/event/'.$event_submitted->id) }}}"><i class="fa fa-chevron-right"></i></a> 
					<a href="{{{ URL::to('/event/edit/'.$event_submitted->id) }}}"><i class="fa fa-pencil"></i></a>
					<a href="{{{ URL::to('/event/approve/'.$event_submitted->id) }}}"><i class="fa fa-check"></i></a>
					<a href="{{{ URL::to('/event/delete/'.$event_submitted->id) }}}"><i class="fa fa-times"></i></a>
				</td>
			  </tr>
			 @endforeach
			</table>
		</div>
		
		<div id="shows_submitted" class="tab-pane table-responsive" >
			<table class="table table-striped">
				 <tr>
					<th>Show</th>
					<th>Who</th>
					<th>When</th>
					<th></th>
				  </tr>
			@foreach($shows_submitted as $show_submitted)
			  <tr>
				<td>{{{ $show_submitted->title }}}</td>
				<td>{{{$show_submitted->people }}}</td>
				<td>{{{ date("H:i d M \'y", strtotime($show_submitted->air_date)) }}}</td>
				<td>
					<a href="{{{ URL::to('/show/'.$show_submitted->id) }}}"><i class="fa fa-chevron-right"></i></a> 
					<a href="{{{ URL::to('/show/edit/'.$show_submitted->id) }}}"><i class="fa fa-pencil"></i></a>
					<a href="{{{ URL::to('/show/approve/'.$show_submitted->id) }}}"><i class="fa fa-check"></i></a>
					<a href="{{{ URL::to('/show/delete/'.$show_submitted->id) }}}"><i class="fa fa-times"></i></a>
				</td>
			  </tr>
			 @endforeach
			</table>
		</div>
		
		<div id="extras_submitted" class="tab-pane table-responsive" >
			<table class="table table-striped">
				 <tr>
					<th>Title</th>
					<th>Event URL</th>
					<th></th>
				  </tr>
			@foreach($extras_submitted as $extra_submitted)
			  <tr>
				<td>{{{ $extra_submitted->title }}}</td>
				<td><a href="{{{ URL::to('/event/'.$extra_submitted->event_id) }}}">{{{ $extra_submitted->event_id }}}</td>
				<td>
					<a href="{{{ URL::to('/extra/approve/'.$extra_submitted->id) }}}"><i class="fa fa-check"></i></a>
					<a href="{{{ URL::to('/extra/delete/'.$extra_submitted->id) }}}"><i class="fa fa-times"></i></a>
				</td>
			  </tr>
			 @endforeach
			</table>
		</div>
		
	</div>

			</div>
			
			<div class="col-md-4">
			<h3>Admin Panel - Stats</h4>
			<p>Users: {{{ $users->count() }}}</p>	
			<p>Events: {{{ $event_count }}}</p>	
			<p>Shows: {{{ $show_count }}}</p>	
			<p>Beta newsletter: {{{ $beta_count }}}</p>	
			</div>
		</div>
</div>
@stop