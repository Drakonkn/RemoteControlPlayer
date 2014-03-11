<?php
	include 'db/db.php';

	$command_db = new db();
	$command_db->init();
	$cmd = $_POST['cmd'];
	if (isset($_COOKIE['dev_id']))
		$source = $_COOKIE['dev_id'];
	else {
		echo "error, please true again";
		return;
	}
	$dest = $_POST['dest'];
	$query = "INSERT INTO commands (cmd, source, dest) VALUES ('".$cmd."', '".$source."', '".$dest."')";
	$command_db->request($query);
?>