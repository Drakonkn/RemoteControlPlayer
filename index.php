<!DOCTYPE html>
<html>
 <head>
 	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="main.css"/>
	<script src="http://vkontakte.ru/js/api/openapi.js" type="text/javascript"></script>
	<script type="text/javascript">
	  window.onload = function(){
	  	alert("init");
		  VK.init({
		    apiId: 4223386
		  });
	  }
	  function authInfo(response) {
	  	alert("out");
		  if (response.session) {
		    alert('user: '+response.session.mid);
		  } else {
		    alert('not auth');
		  }
		}
</script>
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
	//var_dump($user);
	echo "<div id='user_info' ><img id='user_photo' src='".$user[0]->photo_medium."'></img>";
	echo "<div id='user_name'>".$user[0]->first_name."<br/>".$user[0]->last_name."</div></div>";
	echo "<div onclick='VK.Auth.logout(authInfo);'>Это не вы?</div>";
	function redirect($url){
		header('Location: '.$url);
			exit;
	}
?>
<div id="ref_play" class="button" onclick="javascript: window.location='player.php';">К плееру</div>
<div id="ref_contol" class="button" onclick="javascript: window.location='cmd.php';">К управлению</div>
</body>
</html>