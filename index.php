<?php
	require_once 'core/init.php';

	$user = new User();
	$lobby = new Lobby();

	if ($user->exists()){
		$active_game_id = $lobby->getActiveGameId($user->data()->id);
		if ($active_game_id != 0) {
			Session::put('active_game', $active_game_id);
			Redirect::to('arena.php');
		}
	}

	$open_games = $lobby->getOpenGames();
	//print_r($open_games);

	$chat = new Chat();
	if (Input::exists()) {
        try {
            $chat->send(array(
            	'message' => Input::get('message'), 
            	'login' => $user->data()->login
            ));
            header('Location: index.php');
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>werthummer</title>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<script type="text/javascript" src="javascript/index.js"></script>
</head>
<body>
	<div class="header">
		<div class="logo">
			<h1>Wathamler onlime bad hame</h1>
		</div>
		<div class="auth-user">
			<?php 
				if (!$user->isLoggedIn()) {
					require_once 'views/auth-user.php';
				} else {
					require_once 'views/greating-user.php';
				}
			?>
		</div>
	</div>
	<div style="clear: both"></div>
	<div class="main">
		<?php 
			if (!$user->isLoggedIn()) {
				echo '<h2>welcome to our online game! <br/> Please log in or register!</h2>';
			} else {
				require_once 'views/lobby.php';
			}
		?>
	</div>
</body>
</html>