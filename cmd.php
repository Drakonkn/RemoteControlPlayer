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
		<link rel="stylesheet" type="text/css" href="player.css"/>
		<title>Remote control</title>
		<script type="text/javascript">
			$.post(
			'devadd.php',
			{
				action: 'get'
			},
			onGetDev);
		var dev_status;
		setInterval(status_update,1000);


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
			  onComandSend
			);
		}

		function onComandSend(data)
		{
			var jdata = JSON.parse(data);
			if (jdata.result == error){
				alert(jdata.error_string);
			}
		}

		function status_update(){
			$.post('status.php',{action: 'get'},onStatus_update)
		}

		function onStatus_update(data){
			var jdata = JSON.parse(data);
			if (jdata.result == 'error'){
				alert(jdata.error_string);
			}
			var devices = document.getElementById('devices');
			dev_status = jdata.results;
			var table = document.getElementById('table');
			table.innerHTML = "";
			for (dev in jdata.results){
				var row = document.createElement('tr');

				var name = document.createElement('td');
				name.innerHTML = jdata.results[dev].name;
				row.appendChild(name);

				var status = document.createElement('td');
				status.innerHTML = jdata.results[dev].status;
				row.appendChild(status);

				var played_song = document.createElement('td');
				played_song.innerHTML = jdata.results[dev].played_song;
				row.appendChild(played_song);
				
				table.appendChild(row);
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
	<select id="devices"></select>
	<table id="table">
	</table>
	</body>
</html>
