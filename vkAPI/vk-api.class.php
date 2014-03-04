<?php
/**
 * VK API class for vk.com
 *
 * @package API Tools
 * @link <a href="http://vk.com/byvlad">vk.com/byvlad</a>
 * @author Vladyslav Karpenko
 * @version 1.0
 */
 
class vkapi {
 public $api_secret;
 public $app_id;
 public $api_uid;
 
function __construct($app_id, $api_key, $api_uid) {
 $this -> app_id = $app_id;
 $this -> api_key = $api_key;
 $this -> api_uid = $api_uid;
 }
 
function api($method, $params = false){
 if (!$params)
 $params = array();
 
$params['api_id'] = $this->app_id;
 $params['method'] = $method;
 $params['test_mode'] = 1;
 $params['v'] = '2.0';
 
ksort($params);
 
$sig = '';
 
foreach($params as $k=>$v)
 $sig .= $k . '=' . $v;
 
$params['sig'] = md5($this->api_uid . $sig . $this->api_key);
 
$ch = curl_init('http://api.vk.com/api.php');
 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($ch, CURLOPT_REFERER, 'http://vk.com/app' . $this->app_id);
 curl_setopt($ch, CURLOPT_POST, 1);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
 curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
 curl_setopt($ch, CURLOPT_USERAGENT, 'Opera/9.80 (Windows NT 5.1; U; ru) Presto/2.2.15 Version/10.00');
 
$data = curl_exec($ch);
 curl_close($ch);
 
return simplexml_load_string($data);
 }
 
function params($params) {
 $pice = array();
 foreach($params as $k=>$v) {
 $pice[] = $k . '=' . urlencode($v);
 }
 return implode('&',$pice);
 }
 
function file_send($url, $file, $path) {
 $ch = curl_init($url);
 
curl_setopt($ch, CURLOPT_POST, 1);
 curl_setopt($ch, CURLOPT_POSTFIELDS, array('file1' => '@' . $path . $file));
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 
$data = json_decode(curl_exec($ch));
 
curl_close($ch);
 
return $data;
 }
}
?>