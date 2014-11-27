<?php session_start();


	if(!isset($_GET['code'])){
		get_code();
	}
	else
		echo $_GET['code'];


	function get_code()
	{
		$path = $_SERVER['HTTP_HOST'].$_SERVER["SCRIPT_NAME"];
		$url = 'https://oauth.vk.com/authorize?client_id=4223386&scope=audio,friends,photos&redirect_uri=http://'.$path.'&response_type=code';
		redirect($url);
	}

	function redirect($url){
		header('Location: '.$url);
		exit;
	}
?>