<?php
	require_once('core/init.php');

	$game_id = Input::get('game_id');
	$game = new Game();
	$game->getData($game_id);
	$game->addPlayer2(Session::get('logged_user'));
	Redirect::to('arena.php');
?>