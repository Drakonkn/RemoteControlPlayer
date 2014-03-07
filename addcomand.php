<?php
	include 'db/db.php';
	$dbname = 'command';

	$command_db = new db($dbname);
	$command_db->init();
	$cmd = $_POST['cmd'];
	if (isset($_COOKIE['dev_id']))
		$source = $_COOKIE['dev_id'];
	else {
		echo "error, please true again";
		return;
	}
	$dest = 2;//$_POST['dest'];
	$query = "INSERT INTO commands (cmd, source, dest) VALUES ('".$cmd."', '".$source."', '".$dest."')";
	$command_db->request($query);
?>