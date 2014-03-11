<?php
	include "vkAPI/vk_API.php";
	error_reporting(E_ALL);
	session_start();
	if (isset($_GET['ret']))
		$_SESSION['ret'] = $_GET['ret'];
	$vk = vk::getInstance();
	if (isset($_SESSION['ret']) && isset($_SESSION['uid'])){
		redirect($_SESSION['ret']);
	}
	else{
		echo "error";
	}

	function redirect($url){
		header('Location: '.$url);
	}
?>