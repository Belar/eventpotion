@extends('allround.master')

@section('content')
<div class="container">

    <div class="page-header">
        <h2>{{{ $event->title }}}
            @if(Sentry::check()) 
            @if(Sentry::getUser()->id == $event->author_id || Sentry::getUser()->hasAccess('admin'))
            <small class="event-management"><a href="{{{ URL::to('/event/edit/'.$event->id) }}}"><i class="fa fa-pencil"></i></a></small>
            @endif
            @endif
        </h2>

        @if($event->lan == '1')
        <div class="row">
            <div class="col-md-8">
                <div class="row">

                    <div class="col-md-3 col-xs-6">
                        <p><i class="fa fa-calendar"></i> {{{ date("d M \'y", strtotime($event->start_date)) }}}</p>
                        <p><i class="fa fa-clock-o"></i> {{{ date("H:i", strtotime($event->start_date)) }}}</p>
                    </div>

                    <div class="col-md-2 col-xs-6">
                        <p><i class="red fa fa-calendar"></i> {{{ date("d M \'y", strtotime($event->finish_date)) }}}</p>
                        <p><i class="red fa fa-clock-o"></i> {{{ date("H:i", strtotime($event->finish_date)) }}}</p>
                    </div>

                    <div class="col-md-4">
                        @if($event->website)
                        <p><a href="{{{ $event->website }}}" target="_blank"><i class="fa fa-globe"></i> www</a></p>
                        @endif
                        @if($event->brackets)
                        <p><a href="{{{ $event->brackets }}}" target="_blank"><i class="fa fa-table"></i> Catch up take a look at brackets</a></p>
                        @endif
                        @if($event->ticket_store)
                        <p><a href="{{{ $event->ticket_store }}}" target="_blank"><i class="fa fa-ticket"></i> Buy ticket or just support event</a></p>
                        @endif
                        @if($event->vod)
                        <p><a href="{{{ $event->vod }}}" target="_blank"><i class="fa fa-video-camera"></i> Missed it? Take a look at VODs</a></p>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <p><i class="fa fa-map-marker"></i> {{{ $event->location }}}</p>
                        <p><i class="fa fa-trophy"></i> {{{ $event->prizepool }}}</p>
                    </div>
                </div>

                <div class="row">		
                    <div class="col-md-12 games">
                        <p><i class="fa fa-gamepad"></i> 
                            @foreach($games as $game)
                            <img class="game_icon" src="{{{ URL::to('images/icons/'.$game->game_icon.'_icon.png') }}}">
                            @endforeach
                        </p>
                    </div>	
                </div>
                <div class="row">		
                    <div id="event-about" class="col-md-12">
                        {{ Purifier::clean($event->about) }}
                    </div>	
                    <div class="tags"><i class="fa fa-tag"></i>
                        @foreach ( explode(",",$event->tags) as $tag)
                        <a href="/event/tag/{{{ trim($tag) }}}">{{{ trim($tag) }}}</a>
                        @endforeach</div>
                </div>
            </div>
            <div class="col-md-4">
                <div id="map"></div>
            </div>	
        </div>
        @else
        <div class="row">
            <div class="col-md-12">
                <div class="row">

                    <div class="col-md-2 col-xs-6">
                        <p><i class="fa fa-calendar"></i> {{{ date("d M \'y", strtotime($event->start_date)) }}}</p>
                        <p><i class="fa fa-clock-o"></i> {{{ date("H:i", strtotime($event->start_date)) }}}</p>
                    </div>

                    <div class="col-md-2 col-xs-6">
                        <p><i class="red fa fa-calendar"></i> {{{ date("d M \'y", strtotime($event->finish_date)) }}}</p>
                        <p><i class="red fa fa-clock-o"></i> {{{ date("H:i", strtotime($event->finish_date)) }}}</p>
                    </div>

                    <div class="col-md-3">
                        @if($event->website)
                        <p><a href="{{{ $event->website }}}" target="_blank"><i class="fa fa-globe"></i> www</a></p>
                        @endif
                        @if($event->brackets)
                        <p><a href="{{{ $event->brackets }}}" target="_blank"><i class="fa fa-table"></i> Catch up take a look at brackets</a></p>
                        @endif
                        @if($event->ticket_store)
                        <p><a href="{{{ $event->ticket_store }}}" target="_blank"><i class="fa fa-ticket"></i> Buy ticket or just support event</a></p>
                        @endif
                        @if($event->vod)
                        <p><a href="{{{ $event->vod }}}" target="_blank"><i class="fa fa-video-camera"></i> Missed it? Take a look at VODs</a></p>
                        @endif
                    </div>
                    <div class="col-md-2 col-xs-6">
                        <p><i class="fa fa-map-marker"></i> {{{ $event->location }}}</p>
                        <p><i class="fa fa-trophy"></i> {{{ $event->prizepool }}}</p>
                    </div>

                    <div class="col-md-3 games col-xs-6">
                        <p><i class="fa fa-gamepad"></i> 
                            @foreach($games as $game)
                            <img class="game_icon" src="{{{ URL::to('images/icons/'.$game->game_icon.'_icon.png') }}}">
                            @endforeach
                        </p>
                    </div>			

                </div>
            </div>
        </div>
        <div id="event-about" class="row col-md-12">
            {{ Purifier::clean($event->about) }}

            <p class="tags"><i class="fa fa-tag"></i>
                @foreach ( explode(",",$event->tags) as $tag)
                <a href="/event/tag/{{{ trim($tag) }}}">{{{ trim($tag) }}}</a>
                @endforeach</p>	
        </div>	
        @endif
    </div>


    <div class="container  stream-zone">
        <div class="row">
            <ul class="nav nav-tabs stream-tabs">
                @foreach($streams as $stream)
                <li><a href="#stream-{{{ $stream->id }}}" data-toggle="tab">{{ $i++ }}</a></li>
                @endforeach
            </ul>
            <div class="tab-content">	
                @foreach($streams as $stream)
                <div id="stream-{{{ $stream->id }}}" class="tab-pane stream-window">
                    <div class="video-wrapper col-md-8 col-md-8">
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
                    <div class="col-md-4">
                        <iframe frameborder="0" scrolling="no" id="chat_embed" src="http://twitch.tv/chat/embed?channel={{{$stream->stream_url}}}&amp;popout_chat=true" height="425" width="100%"></iframe>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h3>Extras</h3>
                @foreach($extras as $extra)
                <p><a href="{{{ $extra->extra_url }}}" target="_blank">{{{ $extra->title }}}</a></p>
                @endforeach
            </div>
            <div id="add-extra" class="col-md-4">

                <h3>Add event resource</h3>
                <p>You are welcome to add all kinds of resources regarding this event. Submit title and link to your interview, recap, replay pack, wallpaper or insightful news. Links are moderated, please avoid fluff (there are better places for that) and link chains like twitter link > bit.ly > reddit > content. Of course you are welcome to link to your website.</p>
                @if(Sentry::check())
                {{ Form::open(array('url' => 'extra/add', 'role' => 'form')) }}
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
                    {{ Form::label('extra_url', 'URL') }}
                    {{ Form::text('extra_url', '', array('class'=>'form-control')) }}
                </div>
                {{ Form::hidden('event_id', $event->id, array('class'=>'form-control')) }}
                {{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}					
                {{ Form::close() }}
                @else
                <p><a href="#loginForm" data-toggle="modal">Log in</a> to add new resource.</p>
                @endif
            </div>	
        </div>
    </div>
    @stop

    @section('footer')
    <script src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>
    <script>
        var map;
        function initialize() {
            var mapOptions = {
                zoom: 10,
                center: new google.maps.LatLng({{{ $event->latitude }}}, {{{ $event->longitude }}})
            };
            map = new google.maps.Map(document.getElementById('map'),
                                      mapOptions);

            var marker = new google.maps.Marker({
                position: map.getCenter(),
                map: map,
            });

        }

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>

    <script>
        $(document).ready(function(){
            $( ".stream-window:first" ).addClass( "active" );
            $( ".stream-tabs li:first" ).addClass( "active" );
        });
    </script>
    @stop