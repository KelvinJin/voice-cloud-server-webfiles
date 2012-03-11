


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<title>SHOW</title> 
</head>
<body>
<table border = 1 >	
	<tr>
		<th>序号</th>
		<th>文件名</th>
	</tr>
	<?php 
		$filename = $_SERVER['DOCUMENT_ROOT'] . "/UploadedInfo/" . $_SERVER["REMOTE_ADDR"] . ".txt";
		$handle = fopen ($filename,"r");
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
		unlink($filename);
	?>
</table>
<p>Task Type:</p>
<form method="post" action="show.php" name="form1"> 
	<input type="checkbox" name="ch[]" value="测试>Test<br> 
	<input type="checkbox" name="ch[]" value="情感分析">ͬ情感分析<br> 
	<input type="checkbox" name="ch[]" value="同源分析">同源分析<br> 
	<input type="checkbox" name="ch[]" value="关键字检索">关键字检索<br>
	<input type="checkbox" name="ch[]" value="声源分析">声源分析<br> 
	<input type="submit" value="提交任务"> </form> 
</body>
