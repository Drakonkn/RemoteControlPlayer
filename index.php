<?php
ini_set('display_errors','On');
$dir = "audio/";
$files = array();
if (is_dir($dir)) {
   if ($dh = opendir($dir)) {
       while (($file = readdir($dh)) !== false) {
       		if(filetype($dir . $file) !== "dir"){
       			$files[] = $arrayName = array('path' => $dir . $file, 'name' => $file ); 
       		}
       }
       closedir($dh);
   }
}
echo json_encode($files);
?>