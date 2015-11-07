@extends('allround.master')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="no-top-margin">Esports Catch Up</h3>
                    <p>
                    Esports Catch Up (ECU) is your go to corner if you want to be up-to-date in terms of shows taking place each week. The GD Studio Show, Unfiltered, Dota Insight, Much Ado About Dota or StarCast are just a few titles you can find on ECU register.
                    </p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-condensed">
                    <tr>
                        <th class="index-icon"></th>
                        <th class="index-event-title">Show</th>
                        <th class="hidden-xs index-people">Hosts &amp; Guests</th>
                        <th class="hidden-xs index-when-show">When</th>
                        <th class="hidden-xs index-info-icons"></th>
                        <th class="go-to-event"></th>
                    </tr>
                    @foreach($shows as $show)
                    <tr>
                        <td class="text-center">
                            @if($show->show_icon)
                            <img src="{{{ URL::asset('/images/icons/'.$show->show_icon.'_icon.png') }}}" >
                            @endif
                        </td>
                        <td>{{{ $show->title }}}</td>
                        <td class="hidden-xs">{{{ $show->people }}}</td>
                        <td class="hidden-xs"><span data-toggle="tooltip" data-placement="left" data-original-title="{{{ date('H:i', strtotime($show->air_date)) }}}">{{{ date("d M", strtotime($show->air_date)) }}}</td>

                        <td class="hidden-xs">
                            @if ( Sentry::check() && $show->showUser()->where('user_id','=', Sentry::getUser()->id)->first())
                            <a href="{{{ URL::to('/show/unfavourite/'.$show->id) }}}"><i class="fa fa-star"></i></a>
                            @else
                            <a href="{{{ URL::to('/show/favourite/'.$show->id) }}}"><i class="fa fa-star-o"></i></a>
                            @endif
                        </td>
                        <td><a href="{{{ URL::to('/show/'.$show->slug) }}}"><i class="fa fa-chevron-right"></i></a> </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <div class="col-md-4">
            @include('generals.sidebar')
        </div>

    </div>
</div>
@stop

@section('footer')
<script type="text/javascript">
    $(function () {
        $("[data-toggle='tooltip']").tooltip();
    });
</script>
@stop