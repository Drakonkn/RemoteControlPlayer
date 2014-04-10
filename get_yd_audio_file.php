<?php
	$root_dir = "https://webdav.yandex.ru/audio/";
	$acces_token = '482551308d6047f5b4946d44caa0aa27';
	if(isset($_GET['file'])){
		$url = $root_dir.$_GET['file'];
		sendFile($url,$acces_token);
	}
	else{
		$url = $root_dir;
		getFiles($url,$acces_token);
	}

	function getFiles($url,$acces_token){
		$dir_atr = getFileAttributes($url, $acces_token);
		Header('Content-Type: application/json');
		echo json_encode($dir_atr);
	}

	function sendFile($url, $acces_token)
	{
		$file_atrs = getFileAttributes($url, $acces_token);
		$file_atr = $file_atrs['songs'][0];
    	$opts = array(
  			'http'=>array(
    			'method'=>"GET",
    			'header' => 'Authorization: OAuth '.$acces_token
  			)
		);
		$context = stream_context_create($opts);

		$headers = getallheaders();
    	Header($file_atr['status']);
		Header("Connection: close");
		Header("Content-Type: application/octet-stream");
		Header("Accept-Ranges: bytes");
		Header("Content-Length: ".$file_atr['contentlength']);
		Header("Content-Disposition: Attachment; filename=".$file_atr['displayname']);
		$f = fopen ( $url , 'r', false, $context );
		while (!feof($f)){
			if (connection_aborted()) {
      			fclose($f);
				break;
			}
			echo fread($f, 10000);
		}
	}

	function getFileAttributes($url, $access_token){
		$opts = array(
	  			'http'=>array(
	    			'method'=>"PROPFIND",
	    			"header" => ["Authorization: OAuth " . $access_token,
	        				"depth: 1"]
	  			)
		);
		$context = stream_context_create($opts);
		$result = file_get_contents($url,false,$context);
		if ($http_response_header[0] == 'HTTP/1.0 207 Multi-Status'){
			$sxml = new SimpleXMLElement($result);

			$namespaces = $sxml->getNameSpaces(true);
		 	$cb = $sxml->children($namespaces['d']);
		 	$files = array();
		 	foreach ($cb->response as $response) {
			 	$file = array(
			 		'url' 			=> "get_yd_audio_file.php?file=".(string)$response->propstat->prop->displayname,
			 		'owner'			=> '0',
			 		'artist'		=> 'YandexDisk',
			 		'title'			=> (string)$response->propstat->prop->displayname,
			 		'contentlength' => (string)$response->propstat->prop->getcontentlength,
				 	'aid' 			=> (string)$response->propstat->prop->getetag,
				 	'lastmodified' 	=> (string)$response->propstat->prop->getlastmodified,
				 	'contenttype' 	=> (string)$response->propstat->prop->getcontenttype,
				 	'displayname' 	=> (string)$response->propstat->prop->displayname,
				 	'creationdate' 	=> (string)$response->propstat->prop->creationdate,
				 	'status' 		=> (string)$response->propstat->status
			 	);
				$files[] = $file;
		 	}
		 	return array('result' => 'sucsess', 'status'=>$http_response_header[0],'songs'=>$files);
		}
		else if ($file_atrs['status'] != 'HTTP/1.1 401 Unauthorized'){
			Header($file_atr['status']);
			echo json_encode(array('result' => 'error' , 'command' => 'redirect', 'url' => 'index.php' ));
			exit;
		}
		else{
			Header($file_atr['status']);
			echo json_encode(array('result' => 'error' , 'error_string' => $http_response_header[0] ));
		}
		
		
	}
?>