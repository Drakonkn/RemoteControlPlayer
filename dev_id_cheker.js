window.onload = function(){
	var dev_id = getValue('dev_id');
	if (dev_id){
		$.post(
			'devadd.php',
			{
				action: 'check',
				dev_id: dev_id
			
			},
			onCheckResult
		);
	}
	else{
		add_this_device();
	}
}

function getMyDevice(){
	$.post(
		'devadd.php',
		{
			action: 'get',
		},
		onGetDev
	);
}

function onGetDev(data){
	var jdata = JSON.parse(data);
	if(jdata.result == 'error'){
		alert(jdata.error_string);
		window.location = "login.php?ret="+window.location.pathname;
			return;
	}
	var devices = document.getElementById('devices');
	if (devices){
		for (key in jdata){
			var li = document.createElement('option');
			li.id = jdata[key].id;
			li.innerHTML = jdata[key].name;
			devices.appendChild(li);
		}
	}		
}


function onCheckResult(data){
	var jdata = JSON.parse(data);
	if (!jdata.result){
		add_this_device();
	}
	else{
		getMyDevice();
		setVisibleDevName(jdata.name);
	}
}

function add_this_device(){
	var dev_name
	while (!dev_name){
		dev_name = prompt("Название устройства");
	}
	$.post(
		'devadd.php',
		{
			action: 'add',
			dev_name: dev_name	
		},
	onAddDevice
	);
}

function onAddDevice(data){
	var jdata = JSON.parse(data);
	if (jdata.result == 'sucsess'){
		alert("Устройство успешно добавлено \n ID:"+jdata.dev_id);
		setValue('dev_id',jdata.dev_id);
		getMyDevice();
		setVisibleDevName(jdata.dev_name);
	}
	else{
		alert("error "+jdata.error_string)
	}
}

function getValue(name) {
	return localStorage[name];
}

function setValue(name,value){
	localStorage[name] = value;
}

function setVisibleDevName(name){
	var dev_info = document.getElementById('dev_info');
	if(dev_info){
		dev_info.innerHTML = name;
	}
}