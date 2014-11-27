<?php
	session_start();
	include "db/db.php";
	if (!isset($_POST['action'])){
		echo "no action";
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
  	$action = $_POST['action'];
	switch ($action) {
		case 'check':
			echo id_is_in_db($member);
			break;
		case 'add':
			add_devid_to_db($member);
			break;
		case 'get':
			echo get_dev_by_uid($member);
			break;
		default:
			break;
	}
} else {
  	echo "no authority";
}


	function get_dev_by_uid($member){
		$owner_id = $member['id'];
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

	function id_is_in_db($member){
		$user_id = $member["id"];
		$dev_id = $_POST['dev_id'];
		$db = new db(true);
		$db->init();
		$query = "SELECT name,owner FROM device WHERE owner='".$user_id."' AND id='".$dev_id."'";
		$res = $db->request($query);
		if ($res->num_rows == 0)
			return json_encode(array('result' => false));
		else {
			$dev = $res->fetch_array();
			return json_encode(array('result' => true,'name'=>$dev['name'],'owner'=>$dev['owner']));
		}
	}

	function has_in_db($dev_id, $user_id,$dev_name){
		$db = new db(true);
		$db->init();
		$query = "SELECT id FROM device WHERE owner='".$user_id."' AND
		 									  id='".$dev_id."' AND 
		 									  name='".$dev_name."'";
		if ($db->request($query)->num_rows == 0)
			return false;
		else 
			return true;
	}

	function add_devid_to_db($member){
		$dev_name = $_POST['dev_name'];
		$user_id = $member['id'];
		$dev_id = $dev_id = dev_id();
		$db = new db(true);
		$db->init();
		if(!has_in_db($dev_id, $user_id,$dev_name)){
			$query = "INSERT INTO device (owner,id,name) VALUES ('".$user_id."','".$dev_id."','".$dev_name."')";
			if( $db->request($query)){
				echo json_encode(array('result' => 'sucsess','dev_id' => $dev_id, 'dev_name' => $dev_name));
			}
			else{
				echo json_encode(array('result' => 'error','error_string' => 'Can not add ind DB' ));
			}
		}
	}

	function dev_id(){
		$dev_id = md5(rand()."oh7o6ri^%#E$");
		return $dev_id;
	}

?>