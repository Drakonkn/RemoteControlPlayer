<?php
	include 'db/db.php';
	$db = new db(true);
	$db->init();
	if(!isset($_COOKIE['dev_id'])){
		echo json_encode(array('result' => 'error','error_string'=>'device have not dev_id' ));
		return ;
	}
	if (!isset($_COOKIE['dev_id'])){
		echo "error";
		return;
	}
	$dev_id = $_COOKIE['dev_id'];
	$query = "SELECT cmd FROM commands WHERE isSucess=0 AND dest = '".$dev_id."';";
	$result = $db->request($query);
	$query = "UPDATE commands SET isSucess = 1 WHERE isSucess=0 AND dest = '".$dev_id."';";
	$db->request($query);
	$cmds = array();
	while ($line = $result->fetch_array(MYSQL_ASSOC)) {
	    $cmds[] = $line;
	}
		echo json_encode($cmds);
?>