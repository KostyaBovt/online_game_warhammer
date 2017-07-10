<?php
	require_once 'core/init.php';

	$game = new Game();
	$game->create();
	echo $game;
	$game->addPlayer1(Session::get('logged_user'));
	Redirect::to('arena.php');
?>