<?php
error_reporting(E_ALL);
	class vk{
	    protected static $_instance;
	    private static $access_token;
	    private static $uid;
	    private static $token_string;
	 
	    private function __construct(){
	    	$this->init();
	    }

	    private function init(){
	    	if (isset($_SESSION['token'])){
	    		self::$access_token = $_SESSION['token'];
	    		self::$uid = $_SESSION['uid'];
	    		return;
	    	}
			if(!isset($_GET['code']) || isset($_SESSION['code'])){
				$this->get_code();
			}
			else{
				$this->init_token_and_uid();
				$_SESSION['code'] = $_GET['code'];
				$_SESSION['token'] = self::$access_token;
				$_SESSION['uid'] = self::$uid;
			}
	    }
	 
	    private function __clone(){
	    }
	    public static function getInstance() {
	        if (null === self::$_instance) {
	            self::$_instance = new self();
	        }
	        return self::$_instance;
	    }

	    public function api($method, $params = array()){
			$token = self::$access_token;
			$param_string = "access_token=".$token;
			foreach ($params as $key => $value) {
				$param_string = $key."=".$value."&".$param_string;
			}
			$url = "https://api.vk.com/method/".$method."?".$param_string;
			$JsonRes = json_decode($this->sendGet($url));
			return $JsonRes->response;
	    }

		private function get_code()
		{
			$path = $_SERVER['HTTP_HOST'].$_SERVER["SCRIPT_NAME"];
			$url = 'https://oauth.vk.com/authorize?client_id=4223386&scope=audio,friends,offline,photos&redirect_uri=http://'.$path.'&response_type=code';
			$this->redirect($url);
		}

		private function init_token_and_uid()
		{
			$path = $_SERVER['HTTP_HOST'].$_SERVER["SCRIPT_NAME"];
			$url = "https://oauth.vk.com/access_token?client_id=4223386&client_secret=5MuEECzclzE8HV0a2aRs&code=".$_GET['code']."&redirect_uri=http://".$path;
			$JsonRes = json_decode(file_get_contents($url));
			self::$uid = $JsonRes->user_id;
			self::$access_token = $JsonRes->access_token;
			return $JsonRes->access_token.$JsonRes->user_id;
		}

		public function get_uid(){
			if (isset(self::$uid)) return self::$uid;
			if (isset($_SESSION['uid'])) return $_SESSION['uid'];
		}


		public function get_token(){
			if (isset(self::$access_token)) return self::$access_token;
			if (isset($_SESSION['token'])) return $_SESSION['token'];
			echo 'error no token';
		}

		private function redirect($url){
			header('Location: '.$url);
			exit;
		}

		private function sendGet($url)
		{
			$result = file_get_contents($url);
			$JsonRes = json_decode($result);
			return $result;
		}
	}
?>