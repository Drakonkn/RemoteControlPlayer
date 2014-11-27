<!DOCTYPE html>
<html>
 <head>
 	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="player.css"/>
  	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  	<script type="text/JavaScript" src="js/marquee.js"></script>
  	<script type="text/JavaScript" src="dev_id_cheker.js"></script>
  	<script type="text/JavaScript" src="player.js"></script>
  	<script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>
	<script type="text/javascript">
	  VK.init({
	    apiId: 4223386
	  });
	</script>
  	<title>Music player</title>
</head>
<body>
<div id="main_wrap">
	<div class="floating" id="main_head">
		Аудио плеер
		<a href="/index.php">
			<div id="dev_info">
				 no info
			</div>
		</a>
		<div id="logout_button" onclick="VK.Auth.logout(onNotLogin)">logout</div>
	</div>
	
	<div id="content">
		<div class="text_container_l">
			<div class="text_container_r">
					<div id="right_content">
						<div id ="player_substrate">
							<div id="player_wraper">
								<table id = 'player_control'>
								  <tr>
								    <td ><div cmd="prev" onclick="send(this)" class="button_container"><img width="36px" height="145px" src="img/prev_new.png" class="control_button" id="prev_button" ></img></div></td>
								    <td ><div cmd="play" onclick="send(this)" class="button_container"><img width="36px" height="145px" src="img/play_new.png" class="control_button" id="play_button" ></img></div></td>
								    <td ><div cmd="next" onclick="send(this)" class="button_container"><img width="36px" height="145px" src="img/next_new.png" class="control_button" id="next_button" ></img></div></td>
								    <td> <div id="curent_time">00:00</div></td>
								    <td>
								    	<div id="song_title"><br/></div>
								    	<div class="progress_bar" id="seek_bar"><div class="bar_inner" id="seek_inner"></div></div>
								    </td>
								    <td><div id="duration">00:00</div></td>
									<td><div class="progress_bar" id="volume_bar" ><div class="bar_inner" id="volume_inner"></div></div></td>
									<td><div onclick="mute(this)" class="button_mute_container"><img width="36px" height="109px" src="img/mute_new.png" class="control_button" id="next_button" ></img></div></td>
									<td><div onclick="loop(this)" class="button_container"><img width="36px" height="145px" src="img/loop_new.png" class="control_button" id="next_button" ></img></div></td>
								  </tr>
								</table>
							</div>
						</div>
							<div id="list_wraper">
								
							</div>
					</div>
					<div id="left_content">
							<select id="origin" onchange="onOriginSet(this)">
	  							<option selected="selected" value = "myAudio">Мои аудиозаписи</option>
	  							<option value = "recomends">Рекомендации</option>
	  							<option value = "yd">Yandex.Disk</option>
							</select>
							<select id="devices">
							</select>
					</div>

			</div>
		</div>




	</div>
</div>
<audio id="player">
	<source id="src" src="" type="audio/mpeg">
	Тег audio не поддерживается вашим браузером. 
</audio>
</body>
</html>