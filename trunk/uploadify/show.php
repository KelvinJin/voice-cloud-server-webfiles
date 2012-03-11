<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<title>tasksend</title> 
</head>
<body>
<table border = 1 >	
	<tr>
		<th>NO</th>
		<th>filename</th>
	</tr>
	<?php 
		/*  something   */
		$filename =$_SERVER['DOCUMENT_ROOT'] . "/UploadedInfo/" . $_SERVER["REMOTE_ADDR"] .'_'.date("Ymd"). ".txt";
		if (!$handle = fopen ($filename,"r"))
		{
				echo "can not open $filename";
				exit;
		};
		$i = 0;
		while (!feof($handle))
		{
			$file = fgets($handle,1024);
			$i++;
			if (strlen($file)!= 0)
			{
				echo "<tr><td>$i</td><td>$file</td></tr>";
			}
		}
		fclose($handle);
		//unlink($filename);
	?>
</table>
<p>Task Type</p>
<form method="post" action="tasklist.php" name="form1"> 
	<input type="checkbox" name="ch[]" value="test">test<br> 
	<input type="checkbox" name="ch[]" value="Sentiment Analysis">Sentiment Analysis<br> 
	<input type="checkbox" name="ch[]" value="Homologous Analysis">Homologous Analysis<br> 
	<input type="checkbox" name="ch[]" value="Keyword Search">Keyword Search<br>
	<input type="checkbox" name="ch[]" value="Source Analysis">Source Analysis<br> 
	<input type="submit" value="submit"> </form> 
</body>
</html>
