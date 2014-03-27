<!DOCTYPE html>
<html>
 <head>
 	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="player.css"/>
  	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  	<script type="text/javascript">
  		</script>
  	<script type="text/JavaScript" src="dev_id_cheker.js"></script>
  	<script type="text/JavaScript" src="player.js"></script>
  	<title>Music player</title>
</head>
<body>
<div id="main_wrap">
	<div class="floating" id="main_head">
		<div id="title"><img src="img/title.png"/></div>
		<div id="dev_info">
			no info
		</div>
	</div>
	<div id="content">
		<div class="text_container_l">
			<div class="text_container_r">
					<div id="right_content">
						<div id ="player_substrate">
							<div id="player_wraper">
								<table id = 'player_control'>
								  <tr>
								    <td onclick="play_prev()"><img src="img/prev_new.png" class="control_button" id="prev_button" ></img></td>
								    <td onclick="play_pause()"><img src="img/play_new.png" class="control_button" id="play_button" ></img></td>
								    <td onclick="play_next()"><img src="img/next_new.png" class="control_button" id="next_button" ></img></td>
								    <td><div id="curent_time">00:00</div></td>
								    <td>
								    	<div id="song_title"><br/></div>
								    	<div class="progress_bar" id="seek_bar" onclick="seek(event, this)"><div class="bar_inner" id="seek_inner"></div></div>
								    </td>
								    <td><div id="duration">00:00</div></td>
									<td><div class="progress_bar" id="volume_bar" onclick="volumeChange(event, this)"><div class="bar_inner" id="volume_inner"></div></div></td>
								  </tr>
								</table>
							</div>
						</div>
							<div id="list_wraper">
								
							</div>
					</div>
					<div id="left_content">
							<select id="devices" onchange="onOriginSet(this)">
	  							<option selected="selected" value = "myAudio">Мои аудиозаписи</option>
	  							<option value = "recomends">Рекомендации</option>
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