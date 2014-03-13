<?php session_start();
	include "vkAPI/vk_API.php";
	ini_set('display_errors','On');
	$vk = vk::getInstance();
	if(!isset($_SESSION['uid'])){
		redirect("index.php");
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
	 
	echo '<div id="song_list">';
	foreach ($songs as $key => $song) {
		echo '<div onclick="play(this)" title="'.$song->title.'" artist="'.$song->artist.'" class="song_element" path="'.$song->url.'">'.$song->artist." - ".$song->title.'</div>';
	}
	echo '</div>';

?>