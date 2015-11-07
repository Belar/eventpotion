<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h3>Hello, {{{ $nick }}}</h3>

		<div>
			<p>Thank you for registering. Your registration process is nearly finished, all we need to do is confirm your e-mail address.</p>

			<p>Visit this address to finish registration: {{ URL::to('/activate', array( $activation_code, $user_id )) }}</p>

			<br>
			Greetings,<br>		
		</div>
	</body>
</html>
