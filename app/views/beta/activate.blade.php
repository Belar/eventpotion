<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<div>
			<p>Welcome to Event Potion. One of EP users (Probably one of your friends.) is inviting you to our beta. Please follow the link below to confirm your e-mail address and then proceed to {{ URL::to('/register' }} in order to sign up.</p>
			
			<p>Confirmation code: {{ URL::to('/beta/activate', array($activation_code)) }}</p>
			
            <p>If you are not interested in joining during current phase, just ignore this e-mail. No more messages will be send towards you, unless you sign up later.</p>
            
			<br>
			<p>Greetings,<br>
			<b>Event Potion</b>
			</p>
		</div>
	</body>
</html>