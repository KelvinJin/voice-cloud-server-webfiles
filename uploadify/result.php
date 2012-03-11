<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<title>result</title> 
</head>
<body>
<?php 
	echo "<p>result:</p>";
	$dir=$_SERVER['DOCUMENT_ROOT'] . "/TaskResult/"."FinalResult/";
	session_start();
	$filename_result=$dir.$_SESSION["filename"].'_result.txt';
	if (!$handle = fopen ($filename_result,"r"))
	{
		echo "can not open $filename_result";
		exit;
	};
	echo "<p>success:</p>";
	while (!feof($handle))
	{
		$file = fgets($handle,1024);
		if (strlen($file)!= 0)
		{
			echo "<p>$file</p>";
		}
	}
	fclose($handle);
	
	$filename_result_fail=$dir.$_SESSION["filename"].'_result_fail.txt';
	if (!$handle = fopen ($filename_result_fail,"r"))
	{
		echo "can not open $filename_result_fail";
		exit;
	};
	echo "<p>fail:</p>";
	$i=0;
	while (!feof($handle))
	{
		$file = fgets($handle,1024);
		$i++;
		if (strlen($file)!= 0)
		{
			echo "<p>$file</p>";
		}
	}
	if ($i!=0) {
		echo"<p>over</p>";
	}
	fclose($handle);
	
	
?>
</body>
</html>
