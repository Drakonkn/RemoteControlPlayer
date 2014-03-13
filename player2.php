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
		Аудио плеер
		<div id="dev_info">
			no info
		</div>
		<div id="audio_info">
			no info
		</div>
	</div>
	<div id="content">
		<div class="text_container_l">
			<div class="text_container_r">
					<div id="right_content">
						<div id="player_wraper">
							<audio controls id="player">
							  		<source id="src" src="" type="audio/mpeg">
							  		Тег audio не поддерживается вашим браузером. 
							</audio>
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
</body>
</html>