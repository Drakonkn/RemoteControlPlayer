<?php session_start();
	if(!isset($_SESSION['uid'])){
		$path = $_SERVER["SCRIPT_NAME"];
		redirect("login.php?ret=".$path);
	}
	function redirect($url){
		header('Location: '.$url);
			exit;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="main.css"/>
		<script type="text/javascript">
			$.post(
			'devadd.php',
			{
				action: 'get'
				
			},
			onGetDev);


		function onGetDev(data){
			var jdata = JSON.parse(data);
			if(jdata.result == 'error'){
				alert(jdata.error_string);
				window.location = "login.php?ret="+window.location.pathname;
				return;
			}
			var devices = document.getElementById('devices');
			for (key in jdata){
				var li = document.createElement('option');
				li.id = jdata[key].id;
				li.innerHTML = jdata[key].name;
				devices.appendChild(li);
			}
			
		}


		function send(button){
			var cmd = button.getAttribute('cmd');
			var devices = document.getElementById('devices');
			dest_dev_id = devices[devices.selectedIndex].id;
			$.post(
			  "addcomand.php",
			  {
			  	dest: dest_dev_id,
			    cmd: cmd,
			  },
			  onAjaxSuccess
			);
			 
			function onAjaxSuccess(data)
			{
			  //alert(data);
			}
		}
		</script>
		<script type="text/JavaScript" src="dev_id_cheker.js"></script>
	</head>
	<body>
	<input type="button" class="button" value="play" id="play" cmd="play" onclick="send(this)"></input>
	<input type="button" class="button" value="pause" id="pause" cmd="pause" onclick="send(this)"></input>
	<input type="button" class="button" value="prev" id="prev" cmd="prev" onclick="send(this)"></input>
	<input type="button" class="button" value="next" id="next" cmd="next" onclick="send(this)"></input>
	<br/>
	<input type="button" class="button" value="Vol_UP" id="vol_up" cmd="vol_up" onclick="send(this)"></input>
	<input type="button" class="button" value="Vol_Down" id="vol_dow" cmd="vol_dow" onclick="send(this)"></input>
	<select id="devices">
	  
	</select>
	</body>
</html>
