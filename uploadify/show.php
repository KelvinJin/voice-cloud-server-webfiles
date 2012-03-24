<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<title>tasksend</title>
<script type="text/javascript"> 
function chooseAll(cName) 
{ 
    var checkboxs = document.getElementsByName(cName); 
    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = true;} 
} 
</script> 
</head>
<body>
<input type="button" onclick="chooseAll('file_ch[]')" value="choose all">
<form method="post" action="tasklist.php" name="form1">
<table border = 1 >	
	<tr>
		<th>Name</th>
		<th>UploadTime</th>
		<th>Seclect or not</th>
	</tr> 
	<?php  
		$conn=mysql_connect('localhost:3306','root','wbzdmm') 			or die("connect database fail!\n").mysql_error();
		$select=mysql_select_db('wav_test',$conn) 
		or die("connect wav database fail!\n").mysql_error();
		$str="select * from WAV_FILES order by uploadTime desc";
		$recstr=mysql_query($str);
		$row=mysql_fetch_row($recstr);
		while($row)
		{ 
			echo "<tr><td>$row[1]</td><td>$row[2]</td><td><input type=\"checkbox\" name=\"file_ch[]\" value=\"$row[0]\"></td></tr>";
			$row=mysql_fetch_row($recstr);
		}
		mysql_close($conn);
	?>
</table>
<p>Task Type</p>
	
	<input type="checkbox" name="ch[]" value="test">test<br> 
	<input type="checkbox" name="ch[]" value="Sentiment Analysis">Sentiment Analysis<br> 
	<input type="checkbox" name="ch[]" value="Homologous Analysis">Homologous Analysis<br> 
	<input type="checkbox" name="ch[]" value="Source Analysis">Source Analysis<br> 
	<input type="checkbox" name="ch[]" value="Keyword Search">Keyword Search<br>
	<input type="submit" value="submit"> </form> 
</body>
</html>
