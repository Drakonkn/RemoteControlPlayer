<!DOCTYPE html>
<html>
 <head>
 	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="main.css"/>
  	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  	<script type="text/JavaScript" src="scripts.js"></script>

</head>
<body>
<?php
	ini_set('display_errors','On');
	if(isset($_GET['access_token'])){
		$token = $_GET['access_token'];
		$url = "https://api.vk.com/method/audio.get?access_token=".$token;
		$res = sendGet($url);
		$JsonRes = json_decode($res);
		$songs =  $JsonRes->response;
		$res = array();
		echo '<div id="song_list">';
		foreach ($songs as $key => $song) {
			$res[] = array('path' => $song->url,'name'=>$song->title);
			echo '<div onclick="play(this)" class="song_element" path="'.$song->url.'">'.$song->title.'</div>';
		}

	}
	else
		header('Location: token.php?ret='.$_SERVER['REQUEST_URI']);

	function sendGet($url)
	{
		$result = file_get_contents($url);
		$JsonRes = json_decode($result);
		return $result;
	}
?>
 </div>
  <audio controls id="player">
    <source id='src' src="" type="audio/mpeg">
    Тег audio не поддерживается вашим браузером. 
  </audio>
</body>
</html>