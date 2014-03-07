<?php
	include 'db/db.php';
	$db = new db('command',true);
	$db->init();

	$devid = $_COOKIE['dev_id'];//$_POST['dest'];
	/////////////////// FIX ME
	$query = "SELECT cmd FROM commands WHERE isSucess=0 AND ( dest = 2 OR dest = '".$devid."');";
	//echo $query;
	///////////////////////////
	$result = $db->request($query);
	$query = "UPDATE commands SET isSucess = 1 WHERE isSucess=0 AND ( dest = 2 OR dest = '".$devid."');";
	$db->request($query);
	$cmds = array();
	while ($line = $result->fetch_array(MYSQL_ASSOC)) {
	    $cmds[] = $line;
	}
		echo json_encode($cmds);
?>