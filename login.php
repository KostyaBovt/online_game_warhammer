<?php
	require_once 'core/init.php';

	

	$user = new User();
	
	if ($user->isLoggedIn()) {
		Redirect::to('index.php');
	}
	
	if (Input::exists()) {
		$login = $user->login(Input::get('login'), Input::get('password'));

		if ($login) {
			Redirect::to('index.php');
		} else {
			echo '<p>Sorry, logging in failed.</p>';
		}
	}


?>
<!DOCTYPE html>
<html>
<head>
	<title>login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="main">
    <h3>Sign in:</h3>
<form action="" method="post">

	<div class="field">
		<input type="text" placeholder="Login" name="login" id="login" autocomplete="off">
	</div>

	<div class="field">
		<input type="password" placeholder="Password" name="password" id="password" autocomplete="off">
	</div>

	<input type="submit" id="log" value="Log in">

</form>
</div>

</body>
</html>