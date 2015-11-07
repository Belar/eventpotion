@extends('allround.master')

@section('content')
<div class="container">
    <div id="dashboard" class="row">
        <div class="col-md-8">


            <!-- Nav tabs -->
            <ul class="dashboard-tabs nav nav-tabs">
                <li><a href="#events_submitted" data-toggle="tab">My events</a></li>
                <li><a href="#shows_submitted" data-toggle="tab">My shows</a></li>
                <li class="active"><a href="#favs" data-toggle="tab"><i class="fa fa-star"></i> Events</a></li>
                <li><a href="#favs_shows" data-toggle="tab"><i class="fa fa-star"></i> Shows</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">	
                <div id="events_submitted" class="tab-pane table-responsive" >
                    <table class="table table-striped">
                        <tr>
                            <th>Event</th>
                            <th class="hidden-xs">Where</th>
                            <th class="hidden-xs">Prizepool</th>
                            <th class="hidden-xs"></th>
                            <th></th>
                        </tr>
                        @foreach($added_events as $added_event)
                        <tr>
                            <td>{{{ $added_event->title }}}</td>
                            <td class="hidden-xs">{{{ $added_event->location }}}</td>
                            <td class="hidden-xs">{{{ $added_event->prizepool }}}</td>
                            <td class="hidden-xs">
                                <a href="{{{ URL::to('/event/edit/'.$added_event->id) }}}"><i class="fa fa-pencil"></i></a>
                            </td>
                            <td><a href="{{{ URL::to('/event/'.$added_event->slug) }}}"><i class="fa fa-chevron-right"></i></a></td>
                        </tr>
                        @endforeach
                    </table>
                    {{ $added_events->links() }}
                </div>

                <div id="shows_submitted" class="tab-pane table-responsive" >
                    <table class="table table-striped">
                        <tr>
                            <th>Show</th>
                            <th class="hidden-xs">Hosts &amp; Guests</th>
                            <th></th>
                            <th></th>
                        </tr>
                        @foreach($added_shows as $added_show)
                        <tr>
                            <td>{{{ $added_show->title }}}</td>
                            <td class="hidden-xs">{{{ $added_show->people }}}</td>
                            <td class="hidden-xs">
                                <a href="{{{ URL::to('/show/edit/'.$added_show->id) }}}"><i class="fa fa-pencil"></i></a>
                            </td>
                            <td><a href="{{{ URL::to('/show/'.$added_show->slug) }}}"><i class="fa fa-chevron-right"></i></a></td>
                        </tr>
                        @endforeach
                    </table>
                    {{ $added_shows->links() }}
                </div>

                <div id="favs" class="tab-pane table-responsive active">
                    <table class="table table-striped">
                        <tr>
                            <th></th>
                            <th>Event</th>
                            <th class="hidden-xs">Where</th>
                            <th class="hidden-xs">When</th>
                            <th></th>
                            <th></th>
                        </tr>
                        @foreach($user_favs as $fav)
                        <tr>
                            <td class="text-center">
                                @if($fav->event_icon)
                                <img src="{{{ URL::asset('/images/icons/'.$fav->event_icon.'_icon.png') }}}" >
                                @endif
                            </td>
                            <td>{{{ $fav->title }}}</td>
                            <td class="hidden-xs">{{{ $fav->location }}}</td>
                            <td class="hidden-xs"><span data-toggle="tooltip" data-placement="left" data-original-title="{{{ date('H:i', strtotime($fav->start_date)) }}}">{{{ date("d M", strtotime($fav->start_date)) }}} - {{{ date("d M \'y", strtotime($fav->finish_date)) }}}</span></td>
                            <td>
                                @if ($fav->eventUser()->where('user_id','=', Sentry::getUser()->id)->first())
                                <a href="{{{ URL::to('/event/unfavourite/'.$fav->id) }}}"><i class="fa fa-star"></i></a>
                                @else
                                <a href="{{{ URL::to('/event/favourite/'.$fav->id) }}}"><i class="fa fa-star-o"></i></a>
                                @endif
                            </td>
                            <td>
                                <a href="{{{ URL::to('/event/'.$fav->slug) }}}"><i class="fa fa-chevron-right"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>

                <div id="favs_shows" class="tab-pane table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th></th>
                            <th>Show</th>
                            <th class="hidden-xs">Who</th>
                            <th class="hidden-xs">When</th>
                            <th></th>
                            <th></th>
                        </tr>
                        @foreach($user_favs_shows as $fav_show)
                        <tr>
                            <td class="text-center">
                                @if($fav_show->show_icon)
                                <img src="{{{ URL::asset('/images/icons/'.$fav_show->show_icon.'_icon.png') }}}" >
                                @endif
                            </td>
                            <td>{{{ $fav_show->title }}}</td>
                            <td class="hidden-xs">{{{ $fav_show->people }}}</td>
                            <td class="hidden-xs"><span data-toggle="tooltip" data-placement="left" data-original-title="{{{ date('H:i', strtotime($fav_show->air_date)) }}}">{{{ date("d M", strtotime($fav_show->air_date)) }}}</td>
                            <td class="hidden-xs">
                                @if ($fav_show->showUser()->where('user_id','=', Sentry::getUser()->id)->first())
                                <a href="{{{ URL::to('/show/unfavourite/'.$fav_show->id) }}}"><i class="fa fa-star"></i></a>
                                @else
                                <a href="{{{ URL::to('/show/favourite/'.$fav_show->id) }}}"><i class="fa fa-star-o"></i></a>
                                @endif
                            </td>
                            <td>
                                <a href="{{{ URL::to('/show/'.$fav_show->slug) }}}"><i class="fa fa-chevron-right"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>
@stop

@section('footer')
<script type="text/javascript">
    $(function () {
        $("[data-toggle='tooltip']").tooltip();
    });

    $('.dashboard-tabs li a').click(function(){
        var current = $(this).attr('href');
        sessionStorage.setItem("currentDashTab", current);
    });

    $(document).ready(function(){
        var current = sessionStorage.getItem("currentDashTab");
        if(current){
            $('.dashboard-tabs li').removeClass('active');
            $('.dashboard-tabs li a[href="'+current+'"]').closest('li').addClass('active');
            $('.tab-pane').removeClass('active');
            $(current).addClass('active');
        }
    });

</script>
@stop