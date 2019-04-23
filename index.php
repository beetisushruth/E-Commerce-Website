<?php
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	$uri = $uri.$_SERVER['HTTP_HOST'].'/dbms';
	header('Location: '.$uri.'/login.php');
	exit;
?>
Something is wrong with the XAMPP installation :-(
