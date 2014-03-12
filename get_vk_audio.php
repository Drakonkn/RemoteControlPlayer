<?php session_start();
	include "vkAPI/vk_API.php";
	ini_set('display_errors','On');
	$vk = vk::getInstance();
	if(!isset($_SESSION['uid'])){
		redirect("index.php");
	}
	$songs = $vk->api('audio.get');
	echo '<div id="song_list">';
	foreach ($songs as $key => $song) {
		echo '<div onclick="play(this)" class="song_element" path="'.$song->url.'">'.$song->title.'</div>';
	}
	echo '</div>';

?>