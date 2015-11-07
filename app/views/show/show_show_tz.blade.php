@extends('allround.master')

@section('content')
<div class="container">
		<h2>{{{ $show->title }}}
         @if(Sentry::check()) 
		  @if(Sentry::getUser()->id == $show->author_id || Sentry::getUser()->hasAccess('admin'))
		  <small class="event-management"><a href="{{{ URL::to('/show/edit/'.$show->id) }}}"><i class="fa fa-pencil"></i></a></small>
		  @endif
            @endif
		</h2>
	<div class="row">
		<div class="col-md-8">
			@if($stream && date("Y-m-d H:i") <= date("Y-m-d H:i", strtotime($show->air_date.'+2 hours' )) && !$show->vods)
			<div class="stream-show">
				<div class="video-wrapper row">
					<object type="application/x-shockwave-flash" 
							height="425px" 
							width="100%" 
							id="live_embed_player_flash" 
							data="http://www.twitch.tv/widgets/live_embed_player.swf?channel={{{$stream->stream_url}}}" 
							bgcolor="#000000">
					  <param  name="allowFullScreen" value="true" >
					  <param  name="allowScriptAccess" value="always" >
					  <param  name="allowNetworking" value="all" >
					  <param  name="movie" value="http://www.twitch.tv/widgets/live_embed_player.swf" >
					  <param  name="flashvars" value="hostname=www.twitch.tv&channel={{{$stream->stream_url}}}&auto_play=true&start_volume=0" >
					  <param name="wmode" value="transparent">
					</object>
				</div>
					<iframe frameborder="0" scrolling="no" id="chat_embed" src="http://twitch.tv/chat/embed?channel={{{$stream->stream_url}}}&amp;popout_chat=true" height="425" width="100%"></iframe>
			</div>
			@elseif($show->vods)
				<div id="show-vods">
				{{ Purifier::clean($show->vods) }}
				</div>
			@elseif(!$show->vods)
				<p class="text-center text-danger">There are no VODs available yet, please check later.</p>
			@endif
		</div>
	
	
		<div class="col-md-4">
				
			<p><i class="fa fa-calendar"></i> {{ Timezone::convert($show->air_date, Sentry::getUser()->timezone, 'd M \'y') }}</p>
			
			<p><i class="fa fa-clock-o"></i> {{ Timezone::convert($show->air_date, Sentry::getUser()->timezone, 'H:i') }}</p>
		
			<div class="games">
				<p><i class="fa fa-gamepad"></i> 
				@foreach($games as $game)
					<img class="game_icon" src="{{{ URL::to('images/icons/'.$game->game_icon.'_icon.png') }}}">
				@endforeach
				</p>
			</div>
			<p><i class="fa fa-headphones"></i> {{{ $show->people }}}</p>
			<div id="event-about">
				{{ Purifier::clean($show->about) }}
			</div>
			<p><i class="fa fa-tag"></i> Tags:
			@foreach ( explode(",",$show->tags) as $tag)
				<a href="/show/tag/{{{ trim($tag) }}}">{{{ trim($tag) }}}</a>
			@endforeach
			</p>	
		</div>
	</div>
</div>
@stop