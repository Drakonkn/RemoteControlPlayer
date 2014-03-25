<!DOCTYPE html>
<html>
 <head>
 	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="main.css"/>
</head>
<body>
<?php session_start();
	if(!isset($_SESSION['uid'])){
		$path = $_SERVER["SCRIPT_NAME"];
		redirect("login.php?ret=".$path);
	}
	include "vkAPI/vk_API.php";
	$vk = vk::getInstance();
	$params['uids'] = $_SESSION['uid'];
	$params['fields'] = 'photo_medium,first_name,last_name';
	$user = $vk->api('users.get',$params);
	echo "<div id='user_info' >";
		echo "<div id='user_name'>";
			echo "Вы вошди как: ";
			echo "<img id='user_photo' src='".$user[0]->photo_medium."'/>";
			echo "<div id='first_name'>".$user[0]->first_name."</div>";
			echo "<div id='last_name'>" .$user[0]->last_name."</div>";
		echo "</div>";
		echo "<form id = 'buttons'>";
			echo "<input type='button' value='К плееру' id='ref_play' class='button' onclick='javascript: window.location=\"player.php\";'/>";
			echo "<input type='button' value='К управлению' id='ref_contol' class='button' onclick='javascript: window.location=\"cmd.php\";'/>";
		echo "</form>";
	echo "</div>";

	function redirect($url){
		header('Location: '.$url);
			exit;
	}
?>
</body>
</html>