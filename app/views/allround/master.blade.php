<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Esports calendar for online and offline (LAN) events. Supported games include Dota 2, Starcraft 2, Counter Strike: Global Offensive, Hearthstone, Heros of the Storm.">
        <meta name="keywords" content="esport, calendar, dota 2, counter strike, starcraft, hearthstone, heroes of the storm">
        <meta name="ROBOTS" content="NOODP">

        <link rel="shortcut icon" href="{{ URL::asset('img/favicon.ico') }}">

        <meta property="og:image" content="{{ URL::asset('images/ep_thumb.jpg') }}"/>

        @yield('head_scripts')

        <!-- Bootstrap core CSS -->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="{{ URL::asset('css/main_red.css') }}" rel="stylesheet">

        <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
<script src="../../assets/js/html5shiv.js"></script>
<script src="../../assets/js/respond.min.js"></script>
<![endif]-->

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,300,700' rel='stylesheet' type='text/css'>

        <title>Event Potion {{ isset($pageTitle) ? ':: '.$pageTitle : '' }}</title>

        @yield('op_metas')

    </head>
    <body>
        <div id="pre-foot-wrap">
            <div id="main">
                <div class="container">

                    @section('top')		<!-- Static navbar -->
                    <div id="top-panel" class="row">
                        <div class="col-md-4">
                            <a href="/"><img src="{{{ URL::asset('img/logo.png') }}}" class="pull-left img-responsive"></a>
                        </div>
                        <div class="col-md-8">
                            <div class="navbar navbar-default">
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>
                                <div class="navbar-collapse collapse">
                                    <ul class="nav navbar-nav navbar-right">
                                        <li><a href="/ecu">ECU</a></li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Events <b class="caret"></b></a>
                                            <ul class="dropdown-menu">
                                                @foreach($games as $game)
                                                <li><a href="/game/{{{ $game->slug }}}">{{{ $game->title }}}</a></li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        <li><a href="/blog">Blog</a></li>
                                        @if(Sentry::check())
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Add<b class="caret"></b></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="/event/add" class="btn nav-new-ch">Event</a></li>
                                                <li><a href="/show/add" class="btn nav-new-ch">Show</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Profile<b class="caret"></b></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="/dashboard">Dashboard</a></li>
                                                <li><a href="/user/edit">Edit profile</a></li>
                                                <li><a href="/password/change">Change password</a></li>
                                                <li><a href="/logout">Log out</a></li>
                                                @if(Sentry::getUser()->hasAccess('admin'))
                                                <li class="divider"></li>
                                                <li><a href="/game/add">Add Game</a></li>
                                                <li><a href="/neverland">Admin</a></li>
                                                @endif
                                            </ul>
                                        </li>

                                        @else
                                        <li><a href="#loginForm" data-toggle="modal" class="reversed_link">Sign in</a></li>
                                        @endif
                                    </ul>
                                </div><!--/.nav-collapse -->
                            </div>
                        </div>
                    </div>
                    @show


                    <div class="modal fade" id="loginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">Login</h4>
                                </div>
                                <div class="modal-body">
                                    @if(Sentry::check())
                                    <p>You are already logged in. Enjoy it!</p>
                                    @else
                                    {{ Form::open( array('url' => 'login', 'role' => 'form') ) }}

                                    <div class="form-group">
                                        {{ Form::label('email', 'Email') }}
                                        {{ Form::email('email', '', array('class'=>'form-control')) }}
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('password', 'Password') }}
                                        {{ Form::password('password', array('class'=>'form-control')) }}
                                    </div>

                                    <div class="checkbox">
                                        {{ Form::checkbox('remember', true , true, array('class' => 'push-left css-checkbox')) }} Remember me
                                    </div>

                                    <p>Forgot your password? <a href="{{ URL::to('/password/request') }}">Restore it</a></p>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        {{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}
                                    </div>

                                    {{ Form::close() }}
                                    @endif
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </div> <!-- /container -->

                <div class="container">

                    @if(Session::has('global_error'))
                    <div class="alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <div id="flash_notice">{{{ Session::get('global_error') }}}</div>
                    </div>
                    @endif

                    @if(Session::has('global_success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <div id="flash_notice">{{{ Session::get('global_success') }}}</div>
                    </div>
                    @endif
                </div>

                @yield('content')
            </div>
        </div>
        @section('foot')
        <div id="foot">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <img src="{{{ URL::asset('img/logo.png') }}}" class="img-responsive">
                        <p class="ep_info"><small>Delivering event schedules since 2012, keeping you up to date with tournaments information and stream channels.</small></p>
                        <p class="copyrights text-muted">© 2012-2013 EventPotion All Rights Reserved</p>
                    </div>

                    <div class="col-md-2 col-md-offset-3">
                        <ul>
                            <li><a href="{{{ URL::to('/') }}}">Home</a></li>
                            <li><a href="{{{ URL::to('/event/add') }}}">Add event</a></li>
                            <li><a href="{{{ URL::to('/show/add') }}}">Add show</a></li>
                            <li><a href="{{{ URL::to('/register') }}}">Sign up</a></li>
                        </ul>
                    </div>

                    <div class="col-md-2">
                        <ul>
                            @foreach($games as $game)
                            <li><a href="/game/{{{ $game->slug }}}">{{{ $game->title }}}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="col-md-2">
                        <ul>
                            <li><a href="{{{ URL::to('/about') }}}">About</a></li>
                            <li><a href="{{{ URL::to('/faq') }}}">FAQ</a></li>
                            <li><a href="{{{ URL::to('/tos') }}}">ToS</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @show
        <!-- Bootstrap core JavaScript
================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

        <script>
            $('.alert').delay(5000).fadeOut(1000);

            if($(window).width() <= 400) {
                $(".blog-post-header").each(function() {
                    $(this).attr("src", $(this).attr("src").replace("uploads/posts/", "uploads/posts/400/"));
                });
            }
            $(window).resize(function() {
                if($(window).width() > 400) {
                    $(".blog-post-header").each(function() {
                        $(this).attr("src", $(this).attr("src").replace("400/", ""));
                    });
                }
            });
        </script>

        @yield('footer')

    </body>
</html>
