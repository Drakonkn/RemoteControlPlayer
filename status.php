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
	

	function authOpenAPIMember() {
		$session = array();
		$member = FALSE;
		$valid_keys = array('expire', 'mid', 'secret', 'sid', 'sig');
		$app_cookie = $_COOKIE['vk_app_4223386'];
		if ($app_cookie) {
		    $session_data = explode ('&', $app_cookie, 10);
		    foreach ($session_data as $pair) {
			    list($key, $value) = explode('=', $pair, 2);
			    if (empty($key) || empty($value) || !in_array($key, $valid_keys)) {
			    	continue;
			      }
			    $session[$key] = $value;
			}
		    foreach ($valid_keys as $key) {
		      if (!isset($session[$key])) return $member;
		    }
		    ksort($session);

			$sign = '';
		    foreach ($session as $key => $value) {
		    	if ($key != 'sig') {
		    		$sign .= ($key.'='.$value);
		    	}
		    }
		    $sign .= "5MuEECzclzE8HV0a2aRs";
		    $sign = md5($sign);
		    if ($session['sig'] == $sign && $session['expire'] > time()) {
		    	$member = array(
		        'id' => intval($session['mid']),
		        'secret' => $session['secret'],
		        'sid' => $session['sid']
		      );
	    	}
  		}
  		return $member;
	}

	$member = authOpenAPIMember();

	if($member !== FALSE) {

	switch ($action) {
		case 'set':
			set_status($member);
			break;
		case 'get':
			get_status($member);
			break;
	}
	} else {
	  	echo "no authority";
	}




	function get_status($member){
		$command_db = new db(true);
		$command_db->init();
		$query = "SELECT name,status,played_song FROM device WHERE owner = ".$member["id"];
		$sql_res = $command_db->request($query);
		if ($sql_res->num_rows == 0)
			echo json_encode(array('result' => 'error'));
		else {
			$out = array();
			while ($dev = $sql_res->fetch_array(MYSQL_ASSOC)){
				$out[] = array('name' => $dev['name'],'status' => $dev['status'],'played_song' => $dev['played_song']);
			}
			//var_dump($out);
			echo json_encode(array('result' => 'sucsess','results'=> $out ));
		}
	}


	function set_status($member){
		$command_db = new db(true);
		$command_db->init();
		$dev_id = $_POST['dev_id'];
		if (isset($_POST['status']) && isset($_POST['song_name'])){
			$status = $command_db->mysqli->real_escape_string($_POST['status']);
			$song = $command_db->mysqli->real_escape_string($_POST['song_name']);
		}
		else{
			echo json_encode(array('result' => 'error','error_string' => 'no status or song name in post request'));
			return;
		}

		$query = "UPDATE device SET status='".$status."',played_song='".$song."' WHERE id = '".$dev_id."'";
		$row_count = $command_db->request($query);
		if ($row_count == 1){
			echo json_encode(array('result' => 'sucsess'));
		}
		else{
			echo json_encode(array('result' => 'error','error_string' => 'erro in db'));
		}
	}
	

?>