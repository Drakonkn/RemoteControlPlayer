<?php session_start(); 
	if (isset($_GET['ret'])){
		$retURL = $_GET['ret'];
		$_SESSION['ret']=$retURL;
	}
	if(isset($_GET['code'])){
		$token = get_token();
		$retURL = $_SESSION['ret'];
		redirect($retURL."?access_token=".$token);
	}
	else{
		get_code();
	}

	function get_code()
	{
		header('Location: https://oauth.vk.com/authorize?client_id=4223386&scope=audio,friends,offline&redirect_uri=http://'.$_SERVER['HTTP_HOST'].'/token.php&response_type=code');
		//echo "<script> top.location.href='https://oauth.vk.com/authorize?client_id=4223386&scope=audio,friends,offline&redirect_uri=http://localhost/token.php&response_type=code'</script>";
	}

	function get_token()
	{
		$url = "https://oauth.vk.com/access_token?client_id=4223386&client_secret=5MuEECzclzE8HV0a2aRs&code=".$_GET['code']."&redirect_uri=http://".$_SERVER['HTTP_HOST']."/token.php";
		$JsonRes = json_decode(file_get_contents($url));
		return $JsonRes->access_token."&user_id=".$JsonRes->user_id;
	}

	function doing($token){
		 $url = "https://api.vk.com/method/friends.get?timestamp=".time()."&fields=uid,first_name,last_name,nickname,sex,bdate&random=".time()."&access_token=".$token;
		 $res = sendGet($url);
		 $JsonRes = json_decode($res);
		 $songs =  $JsonRes->response;
		 foreach ($songs as $song) {
		 	echo "<p> ".$song->first_name.$song->last_name."</p>";
		 }
	}


	function sendGet($url)
	{
		$result = file_get_contents($url);
		$JsonRes = json_decode($result);
		return $result;
	}

	function redirect($url){
		header('Location: '.$url);
	}
?>