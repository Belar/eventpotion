@extends('allround.master')

@section('head_scripts')
<link href="{{{ URL::asset('css/bootstrap-datetimepicker.min.css') }}}" rel="stylesheet">
<link href="{{{ URL::asset('css/summernote.css') }}}" rel="stylesheet">
@stop

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div id="reg-login-forms">		
				<h3>Edit event</h3>			
				<div class="form-body">
					{{ Form::open(array('url' => array('/event/edit', $event->id), 'role' => 'form', 'method'=>'put')) }}
						<ul class="errors">
							@foreach($errors->all() as $message)
								<li class="text-danger">{{{ $message }}}</li>
							@endforeach
						</ul>
					<div class="form-step">							
						<div class="form-group">
							{{ Form::label('title', 'Title') }} <span class="text-danger">*</span>
							{{ Form::text('title', $event->title , array('class'=>'form-control')) }}
						</div>
					<div class="row">	
						<div class="form-group col-md-3">
							{{ Form::label('event_icon', 'Icon') }} <span class="text-danger">*</span>
							<p><small>Just a shortcut from sidebar</small></p>
							{{ Form::text('event_icon', $event->event_icon, array('class'=>'form-control')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('lan', 'Event type') }}
							<p><small>Leave empty for online event.</small></p>
						<div class="clearfix"></div>
							{{ Form::checkbox('lan', '1', $event->lan, array('id'=>'isLAN')) }} LAN
						</div>
					</div>
						<div class="form-group">
							{{ Form::label('games', 'Games') }} <span class="text-danger">*</span>
						<div class="clearfix"></div>
							@foreach($games as $game)
								@if (in_array($game->id, $event_games))
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
					</div>
					<div class="form-step">	
						<div class="form-group">
							{{ Form::label('website', 'Website') }}
							{{ Form::text('website', $event->website, array('class'=>'form-control')) }}
						</div>
						<div class="form-group">
							{{ Form::label('brackets', 'Brackets') }}
							{{ Form::text('brackets', $event->brackets, array('class'=>'form-control')) }}
						</div>
						<div class="form-group">
							{{ Form::label('ticket_store', 'Tickets') }}
							{{ Form::text('ticket_store', $event->ticket_store, array('class'=>'form-control')) }}
						</div>
						<div class="form-group">
							{{ Form::label('vod', 'VOD') }}
							{{ Form::text('vod', $event->vod, array('class'=>'form-control')) }}
						</div>
					</div>
					<div class="form-step">	
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('start_date', 'Start date') }} <span class="text-danger">*</span>
									<div class="input-group">
									  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									  {{ Form::text('start_date', $event->start_date, array('class'=>'form-control date-time-picker', 'data-date-format'=>'yyyy-mm-dd hh:ii')) }}
									</div>
									<p><small>Date/Time should be in UTC/GMT</small></p>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('finish_date', 'Finish date') }} <span class="text-danger">*</span>
									<div class="input-group">
									  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									{{ Form::text('finish_date', $event->finish_date, array('class'=>'form-control date-time-picker', 'data-date-format'=>'yyyy-mm-dd hh:ii')) }}
									</div>
									<p><small>Date/Time should be in UTC/GMT</small></p>
								</div>
							</div>
						</div>
					</div>

					<div class="form-step">
						<div class="form-group">
							<div class="location gllpLatlonPicker">
								{{ Form::label('location', 'Location') }} <span class="text-danger">*</span>
								<div class="input-group">
									{{ Form::text('location', $event->location, array('class'=>'form-control gllpSearchField')) }}
									<span class="input-group-addon gllpSearchButton"><i class="fa fa-search"></i></span>
								</div>
								<p><small>Type <em>City,Country</em> ,hit search and drag the marker to a detailed location</small></p>
									{{ Form::hidden('latitude', $event->latitude, array('class'=>'gllpLatitude')) }}
									{{ Form::hidden('longitude', $event->longitude, array('class'=>'gllpLongitude')) }}
									{{ Form::hidden('zoom', '10', array('class'=>'gllpZoom')) }}		
							<div class="gllpMap"></div>
							</div>
						</div>
						<div class="form-group">
							{{ Form::label('prizepool', 'Prize pool') }}
							{{ Form::text('prizepool', $event->prizepool, array('class'=>'form-control')) }}
						</div>
						<div class="form-group">
							{{ Form::label('about', 'About event') }}
							{{ Form::textarea('about', $event->about, array('class'=>'form-control textarea-about')) }}
						</div>
						<div class="form-group">
							{{ Form::label('streams[]', 'Streams') }} <span class="text-danger">*</span> 
							<div id="stream_urls">
							@foreach($streams as $stream)
									<input class="form-control stream_url" name="streams[]" type="text" value="{{{ $stream->stream_url }}}">
							@endforeach
							<p><small class="text-danger">Only Twitch channel name.</small></p>
							</div>
							<span id="add_stream"><i class="fa fa-plus-circle"></i></span>
							<span id="remove_stream"><i class="fa fa-minus-circle"></i></span>
						</div>
						<div class="form-group">
							{{ Form::label('tags', 'Tags') }}
							{{ Form::text('tags', $event->tags, array('class'=>'form-control')) }}
							<p><small>Separate tags with commas.</small></p>
						</div>
					</div>
						<div class="checkbox">
						{{ Form::checkbox('public_state', '1', $event->public_state ) }}  <p>Public <small>(Uncheck to save an event as a draft.)</small>
						</div>
															
						{{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}			
					{{ Form::close() }}
						
				</div>
			</div>
			</div>
			<div class="col-md-4">
				@include('generals.event_change_sidebar')
			</div>
		</div>
	</div>	
</div>
@stop

@section('footer')
	<script type="text/javascript" src="{{{ URL::asset('js/bootstrap-datetimepicker-smalot.min.js') }}}"></script>
	<script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>	
	<script src="{{{ URL::asset('js/jquery-gmaps-latlon-picker.js') }}}"></script>
	
	<script src="{{{ URL::asset('js/summernote.min.js') }}}"></script>
	
	<script type="text/javascript">
	$(document).ready(function() {
	  $('.textarea-about').summernote({
		height: 300,
		toolbar: [
			//['style', ['style']], // no style button
			['style', ['bold', 'italic', 'underline', 'clear']],
			//['fontsize', ['fontsize']],
			//['color', ['color']],
			['para', ['ul', 'ol']],
			//['height', ['height']],
			['insert', ['picture', 'link','video']], // no insert buttons
			//['table', ['table']], // no table button
			//['help', ['help']] //no help button
		]
	});
	});
	</script>
	
	
	
	<script type="text/javascript">	
	//$('#isLAN').click(function () {
	//	$(".location").toggle(this.checked, function(){});
	//	google.maps.event.trigger($(".gllpMap")[0], 'resize');		
	//});	
	jQuery(document).ready(function () {
		$('#isLAN').each(function(){
			if ($(this).is(':checked')) {
				$('.location').css('display', 'block');
			} else {
				$('.location').css('display', 'none');    
			}
		});

		$('#isLAN').click(function () {
			$(".location").toggle(this.checked, function(){});
			google.maps.event.trigger($(".gllpMap")[0], 'resize');
		});
	});
	</script>
	
	{{{-- Adding and removing stream inputs --}}}
	<script>
	$("#add_stream").click(
	  function () {	 
		 $('<input class="form-control stream_url addiotional-stream" name="streams[]" type="text" value="">').appendTo('#stream_urls');
	  }
	)
	</script>
	<script>
	$("#remove_stream").click(
	  function () {	 
		 $('#stream_urls').find(':last-child').not(':only-child').remove();
	  }
	)
	</script>
	
	
	{{{--Date picker --}}}
	<script type="text/javascript">
            $(function () {
                $('.date-time-picker').datetimepicker({
					autoclose: true
                });
            });
    </script>

@stop