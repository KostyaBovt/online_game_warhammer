<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$GLOBALS['config'] = array(
		'host' => '127.0.0.1',
		'username' => 'root',
		'password' => 'kbovtpass',
		'db' => 'warhammer'
	);

	spl_autoload_register(function($class) {
		require_once 'classes/' . $class . '.class.php';
	});

	
?>