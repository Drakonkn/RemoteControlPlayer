<?php session_start();
	include "vkAPI/vk_API.php";
	ini_set('display_errors','On');
	$vk = vk::getInstance();
	if(!isset($_SESSION['uid'])){
		echo array('result' => 'error' , 'command' => 'redirect', 'url' => 'index.php' );
		return;
	}
	if (isset($_POST['origin'])){
		$origin = $_POST['origin'];
	}
	else{
		$origin = "myAudio";
	}
	switch ($origin) {
		case "myAudio":
			$songs = $vk->api('audio.get');
			break;
		case "recomends":
			$songs = $vk->api('audio.getRecommendations');
			break;
		default:
			$songs = $vk->api('audio.get');
			break;
	}
	 

	$result = array('result' => 'sucsess' , 'songs' => $songs );
	if (empty($result)){
		echo array('result' => 'error' , 'command' => 'redirect', 'url' => 'index.php' );
		return;
	}
	echo json_encode($result);
?>