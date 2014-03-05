<?php
ini_set('display_errors','On');
if(isset($_GET['access_token']))
	echo $_GET['access_token'];
else
	header('Location: token.php');	
?>