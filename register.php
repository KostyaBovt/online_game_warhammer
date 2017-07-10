<?php
	require_once 'core/init.php';


	$user = new User();
	
	if ($user->isLoggedIn()) {
		Redirect::to('index.php');
	}
	
	if (Input::exists()) {
		try {
			$login = $user->create(array(
				'login' => Input::get('login'),
				'password' => Hash::make(Input::get('password')),
				'name' => Input::get('name'),
				'email' => Input::get('email'),
				'wins' => 0,
				'games' => 0
			));

			Redirect::to('index.php');

		} catch (Exception $e) {
			die($e->getMessage());
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
    <h3>Register:</h3>
<form action="" method="post" class="reg">

	<div class="field">
		<input type="text" placeholder="Login" name="login" id="login" autocomplete="off">
	</div>

	<div class="field">
		<input type="password" placeholder="Password" name="password" id="password" autocomplete="off">
	</div>

	<div class="field">
		<input type="text" name="name" placeholder="Name" id="name" autocomplete="off">
	</div>

	<div class="field">
		<input type="email" placeholder="Email" name="email" id="email" autocomplete="off">
	</div>
	<input type="submit" id="log" value="Register">
</div>
</form>


</body>
</html>