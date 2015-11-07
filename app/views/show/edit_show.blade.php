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
				<h3>Add show</h3>			
				<div class="form-body">
					{{ Form::open(array('url' => array('/show/edit', $show->id), 'role' => 'form', 'method'=>'put')) }}
						<ul class="errors">
							@foreach($errors->all() as $message)
								<li class="text-danger">{{{ $message }}}</li>
							@endforeach
						</ul>
					<div class="form-step">			
						<div class="form-group">
							{{ Form::label('title', 'Title') }} <span class="text-danger">*</span>
							{{ Form::text('title', $show->title , array('class'=>'form-control')) }}
						</div>
					<div class="row">
						<div class="form-group col-md-3">
							{{ Form::label('show_icon', 'Icon') }} <span class="text-danger">*</span>
							<p><small>Just a shortcut from sidebar</small></p>
							{{ Form::text('show_icon', $show->show_icon , array('class'=>'form-control')) }}
						</div>
					</div>
						<div class="form-group">
							{{ Form::label('game', 'Games') }} <span class="text-danger">*</span>
						<div class="clearfix"></div>							
							@foreach($games as $game)
								@if (in_array($game->id, $show_games))
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
							{{ Form::label('start_date', 'Start date and time' ) }} <span class="text-danger">*</span>
							<div class="input-group">
							  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							  {{ Form::text('start_date', $show->air_date, array('class'=>'form-control date-time-picker', 'data-date-format'=>'yyyy-mm-dd hh:ii')) }}
							</div>
							<p><small>Date/Time should be in UTC/GMT</small></p>
						</div>
						<div class="form-group">
							{{ Form::label('people', 'Hosts &amp; Guests') }} <span class="text-danger">*</span>
							{{ Form::text('people', $show->people, array('class'=>'form-control')) }}
						</div>
					</div>
					<div class="form-step">		
						<div class="form-group">
							{{ Form::label('about', 'About event') }}
							{{ Form::textarea('about', $show->about, array('id'=>'about_event', 'class'=>'form-control textarea-about')) }}
						</div>
						<div class="form-group">
							{{ Form::label('stream', 'Stream') }} <span class="text-danger">*</span> 
							<div id="stream_urls">
							{{ Form::text('stream', isset($stream->stream_url) ? $stream->stream_url : '', array('class'=>'form-control stream_url')) }}
							<p><small class="text-danger">Only Twitch channel name.</small></p>
							</div>
						</div>
						
						<div class="form-group vods-input">
							{{ Form::label('vods', 'VODs') }}
							<p><small>Use button below to insert VODs for this show.</small></p>
							{{ Form::textarea('vods', $show->vods, array('id'=>'about_event', 'class'=>'form-control textarea-vods')) }}
						</div>
						<div class="form-group">
							{{ Form::label('tags', 'Tags') }} 
							{{ Form::text('tags', $show->tags, array('class'=>'form-control')) }}
							<p><small>Separate tags with commas.</small></p>
						</div>
					</div>
															
						{{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}			
					{{ Form::close() }}
						
				</div>
			</div>
		</div>
			<div class="col-md-4">
				@include('generals.show_change_sidebar')
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
			['insert', ['picture', 'link']], // no insert buttons
			//['table', ['table']], // no table button
			//['help', ['help']] //no help button
		]
	});
	});
	</script>
	
	<script type="text/javascript">
	$(document).ready(function() {
	  $('.textarea-vods').summernote({
		toolbar: [
			//['style', ['style']], // no style button
			//['style', ['bold', 'italic', 'underline', 'clear']],
			//['fontsize', ['fontsize']],
			//['color', ['color']],
			//['para', ['ul', 'ol']],
			//['height', ['height']],
			['insert', ['video']], // no insert buttons
			//['table', ['table']], // no table button
			//['help', ['help']] //no help button
		]
	});
	});
	</script>
	
	{{-- Adding and removing stream inputs --}}
	<script>
	$("#add_vod").click(
	  function () {	 
		 $('<input class="form-control stream_url addiotional-stream" name="vods[]" type="text" value="">').appendTo('#vod_urls');
	  }
	)
	</script>
	<script>
	$("#remove_vod").click(
	  function () {	 
		 $('#vod_urls').find(':last-child').not(':only-child').remove();
	  }
	)
	</script>
	
	{{--Date picker --}}
	<script type="text/javascript">
            $(function () {
                $('.date-time-picker').datetimepicker({
					autoclose: true
                });
            });
    </script>	
			
@stop