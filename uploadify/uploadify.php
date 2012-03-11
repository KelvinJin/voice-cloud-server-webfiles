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
function SaveUploadedInfo($filename,$uploaded)
{
	if (!$handle = fopen($filename,'a'))
	 {
		echo "can not open $filename";
		exit;
	}else
	{
		if (!fwrite($handle,$uploaded.$_FILES['Filedata']['error']))
		{
			echo "can not write to $filename";
			exit;
		}
		fclose($handle);
	}
	
}

$uploadinfofile=$_SERVER['DOCUMENT_ROOT'] . "/UploadedInfo/" . $_SERVER["REMOTE_ADDR"] .'_'.date("Ymd"). ".txt";
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_REQUEST['folder'] . '/';
	$targetFile = $targetPath . $_FILES['Filedata']['name'];

	move_uploaded_file($tempFile, $targetFile);
	SaveUploadedInfo($uploadinfofile,$showName. "\r\n");
	echo "OK\n";//there is something wrong that i cannot remove this line!
	//echo str_replace($_SERVER['DOCUMENT_ROOT'],'', $targetFile);
	$mysql_server_name='localhost:3306';//database location
	$mysql_username='root';
	$mysql_password='wbzdmm';
	$mysql_database='wav_test';
	$conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password);
	mysql_select_db($mysql_database,$conn);  
	if ($conn==FALSE)
  	{
		mysql_close($conn);
  		die('Could not connect: ' . mysql_error());
  	}
	$filemd5=md5_file($targetFile);
	$uploadTime=date("Y-m-d H:i:s");
	$name=$_FILES['Filedata']['name'];
	$showName=date("YmdHis").$_FILES['Filedata']['name'];
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
	
	

//save info to database
	
}
?>
