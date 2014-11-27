<?php
	include 'db/db.php';


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
		$command_db = new db(true);
		$command_db->init();
		if (isset($_POST['cmd'])){
			$cmd = $_POST['cmd'];
		}
		else{
			echo json_encode(array('result' => 'error','error_string' => 'empty command'));
			return;
		}
		
		if (isset($_POST['dev_id']))
			$source = $_POST['dev_id'];
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
	}
	else{
		echo json_encode(array('result' => 'error', 'error_string' => 'not auth'));
	}


?>