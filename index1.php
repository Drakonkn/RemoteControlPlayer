<script type="text/JavaScript" src="Oauth.js"></script>
<?php
	ini_set('display_errors','On');
	if($_GET['code']){
		$token = get_token();
		 $url = "https://api.vk.com/method/friends.get?timestamp=".time()."&random=".time()."&access_token=".$token;
		 $res = sendGet($url);
		 $JsonRes = json_decode($res);
		 $songs =  $JsonRes->response;
		 foreach ($songs as $key => $song) {
		 	//echo "<p>".$key."   ".$song->url."</p>";
		 	echo "<p>".$key."   ".$song."</p>";
		 }
	}
	else{
		echo '<form>';
		echo '<input type="button" onclick="showAuthWindows()">';
		echo '</form>';
	}

	function get_token()
	{
		$url = "https://oauth.vk.com/access_token?client_id=4223386&client_secret=5MuEECzclzE8HV0a2aRs&code=".$_GET['code']."&redirect_uri=http://localhost/index1.php&";
		// use key 'http' even if you send the request to https://...
		$options = array(
		    'http' => array(
		        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
		        'method' => 'GET',
		    ),
		);
		$context = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		$JsonRes = json_decode($result);
		return $JsonRes->access_token;
	}


	function sendGet($url)
	{
		//$url = "https://oauth.vk.com/access_token?client_id=4223386&client_secret=5MuEECzclzE8HV0a2aRs&code=".$_GET['code']."&redirect_uri=http://localhost/index1.php&";
		// use key 'http' even if you send the request to https://...
		$options = array(
		    'http' => array(
		        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
		        'method' => 'GET',
		    ),
		);
		$context = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		$JsonRes = json_decode($result);
		return $result;
	}


?>


