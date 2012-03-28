<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<title>Database Info</title>
<link href="uploadify/css/layout.css" rel="stylesheet" type="text/css" />
<link href="uploadify/css/nav.css" rel="stylesheet" type="text/css" />
<link href="uploadify/css/nav_left.css" rel="stylesheet" type="text/css" />
<link href="uploadify/css/block.css" rel="stylesheet" type="text/css" />
<link href="uploadify/css/button.css" rel="stylesheet" type="text/css" />
<link href="uploadify/css/table.css" rel="stylesheet" type="text/css" />
<script type="text/javascript"> 
	function chooseAll(cName) 
	{ 
		var checkboxs = document.getElementsByName(cName); 
		for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = true;} 
	} 
</script> 
</head>
<body>
<body>
<div id="header">
	<div id="nav">
		<ul>
		<li><a href="uploadify/index.html">Home Page</a></li> 
		<li class="vline"></li>
		<li><a href="uploadify/client.html">Join The Cloud</a></li>
		<li class="vline"></li>
		<li><a href="uploadify/server.html">Server Control</a></li>
		<li class="vline"></li>
		</ul>
	</div>
</div>
<div id="wrap">
 	<div id="sider_left"></div>
 	<div id="main">
		<form method="post" action="tasklist.php" name="form1">
		<table>	
			<tr>
				<th>Number</th>
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
				$i = 0;
				while($row)
				{ 
					$i++;
					echo "<tr><td>$i</td><td>$row[1]</td><td>$row[2]</td><td><input type=\"checkbox\" name=\"file_ch[]\" value=\"$row[0]\"></td></tr>";
					$row=mysql_fetch_row($recstr);
				}
				mysql_close($conn);
			?>
		</table>
		<input type="button" onclick="chooseAll('file_ch[]')" value="choose all">
		<p>Task Type</p>
			
			<input type="checkbox" name="ch[]" value="test">test<br> 
			<input type="checkbox" name="ch[]" value="Sentiment Analysis">Sentiment Analysis<br> 
			<input type="checkbox" name="ch[]" value="Homologous Analysis">Homologous Analysis<br> 
			<input type="checkbox" name="ch[]" value="Source Analysis">Source Analysis<br> 
			<input type="checkbox" name="ch[]" value="Keyword Search">Keyword Search<br>
			<input type="submit" value="submit"> </form> <br />
	</div>
</div>
 <div id="sider_right"></div>
 <div id="wrapclear"></div>
</div>
</body>
</html>
