<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Tifosiwar Forget Password</h2>

		<div>
			You have requested this forget email before. To reset your password, Please Click the link below to change your password :<br><br>
			{{url('/resetpassword/'.$hash)}}
		</div>
	</body>
</html>
