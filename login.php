<?php session_start();
	include "vkAPI/vk_API.php";
	error_reporting(E_ALL);
	if (isset($_GET['ret']))
		$_SESSION['ret'] = $_GET['ret'];
	$vk = vk::getInstance();
	if (isset($_SESSION['ret']) && isset($_SESSION['uid'])){
		$ret = $_SESSION['ret'];
		redirect($ret);
		unset($_SESSION['ret']);
	}
	else{
		echo "error";
		echo "ret = ".$_SESSION['ret'];
	}

	function redirect($url){
		header('Location: '.$url);
	}
?>