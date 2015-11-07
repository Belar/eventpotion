<div id="sidebar">
	@if(Sentry::check())
	
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