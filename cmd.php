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
	<div class="button" id="play" cmd="play" onclick="send(this)">play</div>
	<div class="button" id="pause" cmd="pause" onclick="send(this)">pause</div>
	<div class="button" id="prev" cmd="prev" onclick="send(this)">prev</div>
	<div class="button" id="next" cmd="next" onclick="send(this)">next</div>
	<br/>
	<div class="button" id="vol_up" cmd="vol_up" onclick="send(this)">Vol_UP</div>
	<div class="button" id="vol_dow" cmd="vol_dow" onclick="send(this)">Vol_Down</div>
	<select id="devices">
	  
	</select>
	</body>
</html>
