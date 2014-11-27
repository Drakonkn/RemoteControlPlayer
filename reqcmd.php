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
		$db = new db(true);
		$db->init();
	  	$dev_id = $_GET['dev_id'];
		$query = "SELECT cmd FROM commands WHERE isSucess=0 AND dest = '".$dev_id."';";
		$result = $db->request($query);
		$query = "UPDATE commands SET isSucess = 1 WHERE isSucess=0 AND dest = '".$dev_id."';";
		$db->request($query);
		$cmds = array();
		while ($line = $result->fetch_array(MYSQL_ASSOC)) {
		    $cmds[] = $line;
		}
		echo json_encode($cmds);
	} else {
	  	echo json_encode(array('result' => 'error','error_string'=>'device have not dev_id' ));
		return ;
	}

?>