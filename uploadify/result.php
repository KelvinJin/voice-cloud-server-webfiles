<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<title>Result</title>
<link href="css/layout.css" rel="stylesheet" type="text/css" />
<link href="css/nav.css" rel="stylesheet" type="text/css" />
<link href="css/nav_left.css" rel="stylesheet" type="text/css" />
<link href="css/block.css" rel="stylesheet" type="text/css" />
<link href="css/button.css" rel="stylesheet" type="text/css" />
<link href="css/table.css" rel="stylesheet" type="text/css" />
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
		<li><a href="index.html">Home Page</a></li> 
		<li class="vline"></li>
		<li><a href="client.html">Join The Cloud</a></li>
		<li class="vline"></li>
		<li><a href="server.html">Server Control</a></li>
		<li class="vline"></li>
		</ul>
	</div>
</div>
<div id="wrap">
 	<div id="sider_left"></div>
 	<div id="main">
		<p>Successful Result Information:</p>
		<table>	
			<tr>
				<th>Number</th>
				<th>Name</th>
				<th>Result</th>
			</tr> 
				<?php 
					$dir=$_SERVER['DOCUMENT_ROOT'] . "/TaskResult/"."FinalResult/";
					session_start();
					$filename_result=$dir.$_SESSION["filename"].'_result.txt';
					if (!$handle = fopen ($filename_result,"r"))
					{
						echo "can not open $filename_result";
						exit;
					};
					$i = 0;
					while (!feof($handle))
					{
						$file = fgets($handle,1024);
						if (strlen($file)!= 0)
						{
							$i++;
							echo "<tr><td>$i<td><td>$file</td>";
							$file = fgets($handle,1024);
							echo "<td>$file</td></tr>";
						};
					}
					fclose($handle);
				?>
		</table>
		<p>Failed Error Information:</p>
		<table>	
			<tr>
				<th>Number</th>
				<th>Error Information</th>
			</tr> 	
				<?php
					$filename_result_fail=$dir.$_SESSION["filename"].'_result_fail.txt';
					if (!$handle = fopen ($filename_result_fail,"r"))
					{
						echo "can not open $filename_result_fail";
						exit;
					};
					$i=0;
					while (!feof($handle))
					{
						$file = fgets($handle,1024);
						if (strlen($file)!= 0)
						{
							$i++;
							echo "<tr><td>$i<td><td>$file</td>";
						}
					}
					if ($i==0) {
						echo"<p>All is successful.No Error Infomation.</p>";
					}
					fclose($handle);
							
				?>
		</table>
	</div>
</div>
 <div id="sider_right"></div>
 <div id="wrapclear"></div>
</div>
</body>
</html>
