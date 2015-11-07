@extends('allround.master')

@section('content')
<div class="container">
	<div class="row">
		
		<div class="col-md-8 table-responsive">
			<table class="table table-striped table-condensed">
				 <tr>
					<th class="index-icon"></th>
					<th class="index-event-title">Event</th>
					<th class="hidden-xs index-where">Where</th>
					<th class="hidden-xs index-when">When</th>
					<th class="hidden-xs index-prizepool">Prizepool</th>
					<th class="hidden-xs index-info-icons"></th>
					<th class="go-to-event"></th>
				  </tr>
			@foreach($events as $event)
			  <tr>
			  <td class="text-center">
				@if($event->event_icon)
					<img src="{{{ URL::asset('/images/icons/'.$event->event_icon.'_icon.png') }}}" >
				@endif
				</td>
				<td>{{{ $event->title }}}</td>
				<td class="hidden-xs"><em>{{{ $event->location }}}</em></td>
				<td class="hidden-xs"><span data-toggle="tooltip" data-placement="left" data-original-title="{{{ date('H:i', strtotime($event->start_date)) }}}">{{{ date("d M", strtotime($event->start_date)) }}} - {{{ date("d M \'y", strtotime($event->finish_date)) }}}</span></td>
				
				<td class="hidden-xs">{{{ $event->prizepool }}}</td>
				<td class="hidden-xs">
					@if ( Sentry::check() && $event->eventUser()->where('user_id','=', Sentry::getUser()->id)->first())
						<a href="{{{ URL::to('/event/unfavourite/'.$event->id) }}}"><i class="fa fa-star"></i></a>
					@else
						<a href="{{{ URL::to('/event/favourite/'.$event->id) }}}"><i class="fa fa-star-o"></i></a>
					@endif
										
					@if($event->brackets)
						<a href="{{{ $event->brackets }}}" target="_blank"><i class="fa fa-table"></i></a>
					@endif
				</td>
				<td><a href="{{{ URL::to('/event/'.$event->slug) }}}"><i class="fa fa-chevron-right"></i></a> </td>
			  </tr>
			 @endforeach
			</table>
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