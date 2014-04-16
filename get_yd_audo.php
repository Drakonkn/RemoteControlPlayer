<?php
	api();

	function api(){
		$acces_token = '482551308d6047f5b4946d44caa0aa27';
		$url = "https://webdav.yandex.ru/audio/842583521073.mp3";
		$Res = sendGet($url,$acces_token);
		echo $Res;
	}

	function sendGet($url, $acces_token)
	{

    	$opts = array(
  			'http'=>array(
    			'method'=>"GET",
    			'header' => 'Authorization: OAuth '.$acces_token
  			)
		);

		$context = stream_context_create($opts);


		$result = file_get_contents($url,false,$context);
		return $result;
	}

?>