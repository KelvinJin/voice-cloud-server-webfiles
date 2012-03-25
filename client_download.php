<?php 
	$file_dir = '/home/owenwj/prog/';
	$name = 'Client.zip';
	if (!file_exists($file_dir.$name)){
	
		header("Content-type: text/html; charset=utf-8");
	
		echo "File not found!";
	
		exit;
	
	} else {
	
		$file = fopen($file_dir.$name,"r");
	
		Header("Content-type: application/octet-stream");
	
		Header("Accept-Ranges: bytes");
	
		Header("Accept-Length: ".filesize($file_dir . $name));
	
		Header("Content-Disposition: attachment; filename=".$name);
	
		echo fread($file, filesize($file_dir.$name));
		fclose($file);
	}
?>

