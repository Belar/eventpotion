@extends('allround.master')

@section('content')
<div class="container">
	<div class="row">
		
		<div class="col-md-8 col-md-offset-2">
		<h3>FAQ</h3>
	
		<strong class="orange">1. My event/show/extra didn't show up on the list, why?</strong>
		<p>All records on Event Potion are moderated on the first submission to deliver the best quality of information. After approval it [event, show or extra] will be visible on the main list, unless option "Public" has been unchecked.</p>

		<strong class="orange">2. Do my content always has to be approved before posted to public feed?</strong>
		<p>No. If you are event organizer, show host, recurrent content poster or journalist, you can receive verified status which will allow you to post content straight to the public feed. In order to get verified, please make a contact via e-mail.</p>

		<strong class="orange">3. What should I do if information about event or show is wrong?</strong>
		<p>If you are an author of an event, you can edit its details via dashboard, updates are being published without additional approval. If you are not an author, but you spotted an error, please drop me an e-mail with correct information and I will do my best to fix it as soon as possible.</p>

		<strong class="orange">4. Can I suggest something, improvement for Event Potion?</strong>
		<p>Of course, just send me an e-mail and we can discuss your idea. If it sticks to goals of the website and seams doable, I can't see a reason not to start working on it.</p>

		<strong class="orange">5. I forgot my password, what do I do?</strong>
		<p>Navigate to login pop-up and restore your access by setting up a new password. It will require access to e-mail associated with EP account.</p>
		</div>
		
		<div class="col-md-4">
			
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