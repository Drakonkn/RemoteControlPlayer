<?php
	include "db/db.php";
	if (!isset($_POST['user_id']) || !isset($_POST['dev_name'])){
		echo json_encode($arrayName = array('error' => 'no user id or dev name'));
		return;
	}

	$dev_name = $_POST['dev_name'];
	$user_id = $_POST['user_id'];

	if (isset($_POST['dev_id'])){
		$dev_id = $_POST['dev_id'];
	}
	else{
		$dev_id = md5(rand().'sol');
	}
	add_devid_to_db($dev_id,$user_id, $dev_name);
	echo json_encode($ar = array('dev_id' => $dev_id));



	function has_in_db($dev_id){
		$db = new db('command',true);
		$db->init();
		$user_id = $_POST['user_id'];
		$query = "SELECT id FROM device WHERE id='".$dev_id."'";
		if ($db->request($query)->num_rows == 0)
			return false;
		else 
			return true;
	}

	function add_devid_to_db($dev_id,$user_id, $dev_name){
		if (!has_in_db($dev_id)){
			$db = new db('command',true);
			$db->init();
			$query = "INSERT INTO device (owner,id,name) VALUES ('".$user_id."','".$dev_id."','".$dev_name."')";
			$db->request($query);
		}
	}

	function chek_dev_id(){
		if (!isset($_COOKIE['dev_id'])){
			$dev_id = md5(rand().sol);
			setcookie('dev_id',$dev_id);
		}
		else 
			$dev_id = $_COOKIE['dev_id'];
			add_devid_to_db($dev_id);
	}

?>