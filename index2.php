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
		echo $token;
	}
	else{
		echo("<script> top.location.href='https://oauth.vk.com/authorize?client_id=4223386&scope=audio,friends,offline&redirect_uri=http://localhost/token2.php&response_type=code'</script>");
	}

	function get_token()
	{
		$url = "https://oauth.vk.com/access_token?client_id=4223386&client_secret=5MuEECzclzE8HV0a2aRs&code=".$_GET['code']."&redirect_uri=http://localhost/token2.php";
		$JsonRes = json_decode(file_get_contents($url));
		return $JsonRes->access_token;
	}
?>


</body>
</html>