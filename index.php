<!DOCTYPE html>
<html>
 <head>
 	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="main.css"/>
	<script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>
	<title>Wellcome</title>
	<script type="text/javascript">

		var login_button
		var user_name
		var play_button
		var control_button
		var first_name
		var last_name
		var user_photo
		var buttons
		var you_enter
	  
	window.onload = function (){
		you_enter = document.getElementById('you_enter');
		login_button = document.getElementById('login_button');
		user_name = document.getElementById('user_name');
		play_button = document.getElementById('ref_play');
		control_button = document.getElementById('ref_contol');
		first_name = document.getElementById('first_name');
		last_name = document.getElementById('last_name');
		user_photo = document.getElementById('user_photo');
		buttons = document.getElementById('buttons');

		VK.init({
		    apiId: 4223386
		});
		VK.Auth.getLoginStatus(function(response){
		    if(response.session)
		    {
		        authInfo(response);
		    }
		    else{
		    	onNotAuth()
		    }
		});
		
	}

	function onNotAuth(){
		login_button.style.visibility = "visible";
		you_enter.innerHTML = "Вы не авторизованы"
		play_button.remove()
		control_button.remove()
		first_name.style.visibility = "hidden"
		last_name.style.visibility = "hidden"
		user_photo.src = "https://vk.com/images/deactivated_100.gif"
	}

	function authInfo(response) {
		console.log(response.session.user)
	  	login_button.remove();
	  	buttons.appendChild(play_button)
	  	buttons.appendChild(control_button)
	  	play_button.style.visibility = "visible";
	  	control_button.style.visibility = "visible";
		login_button.style.visibility = "hidden";
		VK.Api.call('users.get', {fields: "photo_100"}, function(r) {
		if(r.response) {
		    user_photo.src = r.response[0].photo_100;
		  	user_name.style.visibility = "visible";
		  	first_name.style.visibility = "visible";
		  	last_name.style.visibility = "visible";
			first_name.innerHTML = r.response[0].first_name
			last_name.innerHTML = r.response[0].last_name
		}
		}); 
	}
	</script>
</head>
<body>
<?php session_start();?>
	<div id="content">
	<div id='user_info' class="block" >
		<div id='user_name'>
			<img id='user_photo' />
			<div id="you_enter" >Вы вошли как:</div>
			<div id='first_name'></div>
			<div id='last_name'></div>
		</div>
	</div>
	<div id = 'buttons' >
		<div id='ref_play' class='button right block' onclick='javascript: window.location="player.php";'><span class="before"></span><div class="align">К плееру</div></div>
		<div id='ref_contol' class='button left block' onclick='javascript: window.location="cmd.php";'><span class="before"></span><div class="align">К управлению</div></div>
		<div id='login_button' style="width: 100%;" class='big_button block' onclick='javascript: VK.Auth.login(authInfo,8);'><span class="before"></span><div class="align">Войти</div></div>
	</div>
	</div>
</body>
</html>