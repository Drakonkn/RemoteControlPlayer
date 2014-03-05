<!DOCTYPE html>
<html>
 <head>
 	<meta charset="utf-8">
</head>
<body>
<?php
	ini_set('display_errors','On');
	if(isset($_GET['code'])){
		$token = get_token();
		echo "<script> top.location.href='http://localhost/test.php?access_token=".$token."'</script>";
		doing($token);
	}
	else{
		get_code();
	}

	function get_code()
	{
		echo "<script> top.location.href='https://oauth.vk.com/authorize?client_id=4223386&scope=audio,friends,offline&redirect_uri=http://localhost/token.php&response_type=code'</script>";
	}

	function get_token()
	{
		$url = "https://oauth.vk.com/access_token?client_id=4223386&client_secret=5MuEECzclzE8HV0a2aRs&code=".$_GET['code']."&redirect_uri=http://localhost/token.php";
		$JsonRes = json_decode(file_get_contents($url));
		return $JsonRes->access_token;
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
?>


</body>
</html>