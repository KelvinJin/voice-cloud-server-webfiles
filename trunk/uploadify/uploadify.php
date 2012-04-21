<?php
/*
Uploadify v2.1.4
Release Date: November 8, 2010

Copyright (c) 2010 Ronnie Garcia, Travis Nickels

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

function get_database_info()
{
	global $mysql_server_name;
	global $mysql_username;
	global $mysql_password;
	global $mysql_database;
	$dir=$_SERVER['DOCUMENT_ROOT'].'/config';
	if (!$fp_config = fopen($dir, "r"))
	{
		echo "config file doesn't exist!\n";
		exit;
	}
	while(!feof($fp_config))
	{
		$temp = fgets($fp_config);

		if (strpos($temp, "db_ip") === 0)
		{
			$databaseinfo0 = substr($temp, 6,-1);

		}

		if (strpos($temp, "db_port") === 0)
		{
			$databaseinfo1 = substr($temp, 8,-1);
		}

		if (strpos($temp, "db_username") === 0)
		{
			$databaseinfo2 = substr($temp, 12,-1);
		}

		if (strpos($temp, "db_password") === 0)
		{
			$databaseinfo3 = substr($temp, 12,-1);
		}
	}
	$mysql_server_name=$databaseinfo0.':'.$databaseinfo1;
	$mysql_username=$databaseinfo2;
	$mysql_password=$databaseinfo3;
	$mysql_database='wav_test';
    	fclose($fp_config);
}

function get_sharefolder_info()
{
	global $mysql_server_name;
	global $mysql_username;
	global $mysql_password;
	global $mysql_database;
	global $sharepath;
	global $user;
	global $pass;
	$connnn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password)or die("connect database fail!\n").mysql_error();
	$select=mysql_select_db('wav_test',$connnn)or die("connect wav database fail!\n").mysql_error();
	$str="select * from ROOTMENU";
	$recstr=mysql_query($str) or die (mysql_error());
	$row=mysql_fetch_row($recstr);
	$sharepath=str_replace('\\','/',$row[0]);
	$user=$row[1];
	$pass=$row[2];
	mysql_close($connnn);
}

if (!empty($_FILES)) {
	global $mysql_server_name;
	global $mysql_username;
	global $mysql_password;
	global $mysql_database;
	global $sharepath;
	global $user;
	global $pass;
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$filemd5=md5_file($tempFile);
	//$targetPath = $_SERVER['DOCUMENT_ROOT'].'/uploadfiles/';
	$showName=date("YmdHis").$_FILES['Filedata']['name'];
	//$targetFile = $targetPath . $showName;
	get_database_info();
	get_sharefolder_info();
	//move_uploaded_file($tempFile, $targetFile);
	echo "OK\n";//there is something wrong that i cannot remove this line!
	//echo str_replace($_SERVER['DOCUMENT_ROOT'],'', $targetFile);
	$conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password);
	mysql_select_db($mysql_database,$conn);  
	if ($conn==FALSE)
  	{
		mysql_close($conn);
  		die('Could not connect: ' . mysql_error());
  	}
	$uploadTime=date("Y-m-d H:i:s");
	$name=$_FILES['Filedata']['name'];
	$sql="select * from WAV_FILES where wavMd5='$filemd5'";
	$recstr=mysql_query($sql) or die (mysql_error());
	$num=mysql_num_rows($recstr);
	if ($num > 0)
	{
		exit;
	}

	$sql="insert into WAV_FILES values('$filemd5','$name','$uploadTime','$showName')";
	$status=mysql_query($sql);
	if($status==FALSE)
	{
		//echo "insert fail!\n";
		mysql_close($conn);
		//echo("<script type='text/javascript'> alert('file existed!');self.location.href='http://127.0.0.1/index.html';</script>");
		
		exit;
	}
	mysql_close($conn);
	$com="smbclient -c \"put $tempFile $showName\" $sharepath -U $user $pass";
	system($com);

//save info to database
	
}

?>
