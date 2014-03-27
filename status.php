<?php
session_start();
	include 'db/db.php';
	if (isset($_POST['action'])){
		$action = $_POST['action'];
	}
	else {
		echo json_encode(array('result' => 'error','error_string' => 'no action'));
		return;
	}
	

	switch ($action) {
		case 'set':
			set_status();
			break;
		case 'get':
			get_status();
			break;
//		default:
//			break;
	}



	function get_status(){
		$command_db = new db(true);
		$command_db->init();
		if (!isset($_SESSION['uid'])){
			echo json_encode(array('result' => 'error','error_string' => 'no uid'));
			return;
		}
		$query = "SELECT name,status,played_song FROM device WHERE owner = ".$_SESSION['uid'];
		//echo $query;
		$sql_res = $command_db->request($query);
		if ($sql_res->num_rows == 0){
			echo json_encode(array('result' => 'error'));
			return;
		}
		else {
			$out = array();
			while ($dev = $sql_res->fetch_array(MYSQL_ASSOC)){;
				//echo mb_detect_encoding($dev['status']);
				$out[] = array('name' => $dev['name'],'status' => $dev['status'],'played_song' => $dev['played_song']);
			}
			//var_dump($out);
			echo json_encode(array('result' => 'sucsess','results'=> $out ));
		}

	}


	function set_status(){
		$command_db = new db(true);
		$command_db->init();
		if (isset($_COOKIE['dev_id']))
			$source = $_COOKIE['dev_id'];
		else {
			echo json_encode(array('result' => 'error','error_string' => 'no dev_id. Pleas reload page and true again'));
			return;
		}
		
		if (isset($_POST['status']) && isset($_POST['song_name'])){
			$status = $_POST['status'];
			//echo mb_detect_encoding($status);
			$song = $_POST['song_name'];
			//$song = iconv('utf-8', 'utf-8//IGNORE', $song);
		}
		else{
			echo json_encode(array('result' => 'error','error_string' => 'no status or song name in post request'));
			return;
		}

		$query = "UPDATE device SET status='".$status."',played_song='".$song."' WHERE id = '".$source."'";
		$row_count = $command_db->request($query);
		if ($row_count == 1){
			echo json_encode(array('result' => 'sucsess'));
		}
		else{
			echo json_encode(array('result' => 'error','error_string' => 'erro in db'));
		}
	}
	

?>