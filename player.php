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
	if(!isset($_SESSION['uid'])){
		$path = $_SERVER["SCRIPT_NAME"];
		redirect("login.php?ret=".$path);
	}
	include "vkAPI/vk_API.php";
	ini_set('display_errors','On');
	$vk = vk::getInstance();
	$songs = $vk->api('audio.get');
	echo '<div id="song_list">';
	foreach ($songs as $key => $song) {
		echo '<div onclick="play(this)" class="song_element" path="'.$song->url.'">'.$song->title.'</div>';
	}


	function toJS($name, $value){
		echo "<div style='display: none;' id='".$name."'>".htmlspecialchars($value)."</div>";
	}

	function redirect($url){
		header('Location: '.$url);
			exit;
	}
?>
 </div>
  <audio controls id="player">
    <source id='src' src="" type="audio/mpeg">
    Тег audio не поддерживается вашим браузером. 
  </audio>
</body>
</html>