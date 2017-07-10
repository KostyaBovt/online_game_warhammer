<?php
	require_once 'core/init.php';

	$sql = file_get_contents('warhammer.sql');

	$db = new PDO("mysql:host=" . Config::get('host'), Config::get('username'), Config::get('password'));


	try {
	    $db->exec($sql);
	}
	catch (PDOException $e)
	{
	    echo $e->getMessage();
	    die();
	}

	Redirect::to('index.php');
?>