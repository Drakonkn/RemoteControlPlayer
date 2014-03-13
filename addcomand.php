<?php
	include 'db/db.php';

	$command_db = new db();
	$command_db->init();
	if (isset($_POST['cmd'])){
		$cmd = $_POST['cmd'];
	}
	else{
		echo json_encode(array('result' => 'error','error_string' => 'empty command'));
		return;
	}
	
	if (isset($_COOKIE['dev_id']))
		$source = $_COOKIE['dev_id'];
	else {
		echo json_encode(array('result' => 'error','error_string' => 'erro no dev_id switch on cookie and true again'));
		return;
	}
	$dest = $_POST['dest'];
	$query = "INSERT INTO commands (cmd, source, dest) VALUES ('".$cmd."', '".$source."', '".$dest."')";
	$row_count = $command_db->request($query);
	if($row_count == 1){
		echo json_encode(array('result' => 'sucsess'));
	}
	else{
		echo json_encode(array('result' => 'error', 'error_string' => 'error in db'));
	}
?>