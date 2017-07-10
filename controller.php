<?php
	require_once 'core/init.php';

	$action = Input::get('action');
	$speed = Input::get('speed');


	$game = new Game();
	$game->getData(Session::get('active_game'));
	
	if ($game->validateAction($action)) {
		$game->executeAction($action, $speed);
	}
	if ($game->getAtt('winner') == 0)
		$game->checkWinner();
	//print_r($game);
	Redirect::to('arena.php');
?>