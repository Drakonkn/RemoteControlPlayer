<!DOCTYPE html>
<html>
 <head>
 	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="main.css"/>
  	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  	<script type="text/JavaScript" src="scripts.js"></script>
  	<script type="text/JavaScript" src="dev_id_cheker.js"></script>

</head>
<body>
<?php session_start();
	ini_set('display_errors','On');
	
	if(isset($_GET['access_token'])){
		toJS('user_id',$_GET['user_id']);
		$token = $_GET['access_token'];
		$url = "https://api.vk.com/method/audio.get?access_token=".$token;
		$res = sendGet($url);
		$JsonRes = json_decode($res);
		$songs =  $JsonRes->response;
		$res = array();
		echo '<div id="song_list">';
		foreach ($songs as $key => $song) {
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

	function toJS($name, $value){
		echo "<form name=formName>";
		echo "<input type='hidden' id='".$name."' value='".htmlspecialchars($value)."'>";
		echo "</form> ";
	}
?>
 </div>
  <audio controls id="player">
    <source id='src' src="" type="audio/mpeg">
    Тег audio не поддерживается вашим браузером. 
  </audio>
</body>
</html>