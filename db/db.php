<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
class db{
	private $host;
	private $login;
	private $password;
	private $dbname;
	public $mysqli;
	private $result;
	function __construct($_silent=false,$_dbname='u344320',$_host='u344320.mysql.masterhost.ru',$_login='u344320',$_password='cralisma4a6i') {
       $this->host = $_host;
       $this->login = $_login;
       $this->password = $_password;
       $this->dbname = $_dbname;
       $this->silent = $_silent;
   }

   function init(){
   		if($this->mysqli = mysqli_connect($this->host, $this->login, $this->password,$this->dbname))
   			if (!$this->silent) echo "Соединение установлено";
   		else
   			if (!$this->silent) echo ('Не удалось соединиться: ' . mysqli_error($this->mysqli));
   }

   function request($query){
    //echo $query;
		$this->result = $this->mysqli->query($query) or die('Запрос не удался: ' . mysqli_error($this->mysqli));
		return $this->result;
   }

   function lastRes(){
   		return $this->result;
   }


}
?>