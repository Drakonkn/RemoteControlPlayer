<!DOCTYPE html>
<html>
 <head>
 	<meta charset="utf-8">
</head>
<body>
<?php
	ini_set('display_errors','On');
	if (isset($_GET['access_token']))
		echo $_GET['access_token'];
	else if (isset($_GET['code'])) get_token();
		else echo("<script> top.location.href='https://oauth.vk.com/authorize?client_id=4223386&scope=audio,friends,offline&redirect_uri=http://localhost/get_token.php&response_type=code'</script>");
	
	


	function get_kode(){
		echo("<script> top.location.href='https://oauth.vk.com/authorize?client_id=4223386&scope=audio,friends,offline&redirect_uri=http://localhost/getToken.php&response_type=code'</script>");
	}
	function get_token()
	{
		$url = "https://oauth.vk.com/access_token?client_id=4223386&client_secret=5MuEECzclzE8HV0a2aRs&code=".$_GET['code']."&redirect_uri=http://localhost/get_token.php";
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
?>


</body>
</html>