window.onload = function(){
	var dev_id = getCookie('dev_id');
	var user_id = fromPHP('user_id');
	if (isSet(dev_id) )
			alert("dev ID = "+dev_id);
	else{
		var dev_name = prompt("введите имя устройства");
		$.post(
			'devadd.php',
			{
				dev_id: dev_id,
				user_id: user_id,
				dev_name: dev_name
			},
			onAjaxSuccess
		);
		}
	}

function onAjaxSuccess(data){
	var jdata = JSON.parse(data);
	if (isSet(jdata.error)){
		alert(jdata.error);
	}
	else{
		setCookie('dev_id',jdata.dev_id);
	}

}

function fromPHP(name)
  { 
  	//alert(document.getElementById(name).value);
	return document.getElementById(name).value;//.value; 
  }


function getCookie(name) {
  var matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : undefined;
}

function setCookie(name,value){
	document.cookie = name+"="+value;
}

function isSet(v){
	return !(typeof v == 'undefined');
}