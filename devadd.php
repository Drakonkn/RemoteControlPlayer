<?php
	session_start();
	include "db/db.php";
	if (!isset($_POST['action'])){
		echo "no action";
		return;
	}
	$action = $_POST['action'];

	switch ($action) {
		case 'check':
			echo id_is_in_db();
			break;
		case 'add':
			add_devid_to_db();
			break;
		case 'get':
			echo get_dev_by_uid();
			break;
//		default:
//			break;
	}


	function get_dev_by_uid(){
		if (!isset($_SESSION['uid'])){
			//var_dump($_SESSION);
			echo json_encode(array('result' => 'error','error_string' => 'pleas login'));
			return;
		}
		$owner_id = $_SESSION['uid'];
		$db = new db(true);
		$db->init();
		$query = "SELECT id,name FROM device WHERE owner='".$owner_id."'";
		$sql_res = $db->request($query);
		if ($sql_res->num_rows == 0)
			return json_encode(array('result' => false));
		else {
			$out = array();
			while ($dev = $sql_res->fetch_array(MYSQL_ASSOC)){;
				$out[] = array('id' => $dev['id'],'name' => $dev['name']);
			}
			return json_encode($out);
		}
	}

	function id_is_in_db(){
		if (!isset($_POST['dev_id'])){
			echo json_encode(array('result' => 'error','error_string' => 'no dev_id'));
			return;
		}
		$dev_id = $_POST['dev_id'];
		$db = new db(true);
		$db->init();
		$query = "SELECT id,name,owner FROM device WHERE id='".$dev_id."'";
		$res = $db->request($query);
		if ($res->num_rows == 0)
			return json_encode(array('result' => false));
		else {
			$dev = $res->fetch_array();
			return json_encode(array('result' => true,'name'=>$dev['name'],'owner'=>$dev['owner']));
		}
	}

	function has_in_db($dev_id){
		$db = new db(true);
		$db->init();
		$query = "SELECT id FROM device WHERE id='".$dev_id."'";
		if ($db->request($query)->num_rows == 0)
			return false;
		else 
			return true;
	}

	function add_devid_to_db(){
		if (!isset($_SESSION['uid'])){
			echo json_encode(array('result' => 'error','error_string' => 'no vk session'));
			return;
		}
		$dev_name = $_POST['dev_name'];
		$user_id = $_SESSION['uid'];
		$dev_id = dev_id();
		if (!has_in_db($dev_id)){
			$db = new db(true);
			$db->init();
			$query = "INSERT INTO device (owner,id,name) VALUES ('".$user_id."','".$dev_id."','".$dev_name."')";
			$db->request($query);
			echo json_encode(array('result' => 'sucsess','dev_id' => $dev_id));
		}
	}

	function dev_id(){
		if (!isset($_COOKIE['dev_id'])){
			$dev_id = md5(rand());
		}
		else {
			$dev_id = $_COOKIE['dev_id'];
		}
		return $dev_id;
	}

?>