<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
		<!-- Bootstrap -->
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
	</head>
<body>
	<div class="col-md-3"></div>
	<div class="col-md-6 well">
		<h3 class="text-primary">PHP - Login And Registration</h3>
		<hr style="border-top:1px dotted #ccc;"/>
		<?php
			echo "session val:: Username: ".$_SESSION['username'].".</br>";
			echo "session val:: Password: ".$_SESSION['password']."</br>";
		?>
		<a href="login.php">Logout</a>
		<h1>Welcome User!</h1>
	</div>
</body>
</html>