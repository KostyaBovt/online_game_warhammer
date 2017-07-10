<?php
	require_once 'core/init.php';

		$game = new Game();
		$game->getData(Session::get('active_game'));
		$game->finishGame();
		Redirect::to('index.php');
?>