window.onload = function(){
	var dev_id = getCookie('dev_id');
	if (isSet(dev_id) ){
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


function onCheckResult(data){
	var jdata = JSON.parse(data);
	if (!jdata.result){
		add_this_device();
	}
	else{
		alert(jdata.name)
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
		setCookie('dev_id',jdata.dev_id);
	}
	else{
		alert("error "+jdata.error_string)
	}
}

function getCookie(name) {
  var matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : undefined;
}

function setCookie(name,value){
	var date = new Date( new Date().getTime() + (1000 * 86400 * 365) );
	document.cookie = name+"="+value+";path=/; expires="+date.toUTCString();
}

function isSet(v){
	return !(typeof v == 'undefined');
}