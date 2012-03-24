<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<title>tasklist</title> 
</head>
<body>
<?php 
/*  
 something
 */
function SaveTaskInfo($filename,$task_info)
{
	if (!$handle = fopen($filename,'a'))
	 {
		echo "can not open $filename";
		exit;
	}else
	{
		$conn=mysql_connect('localhost:3306','root','wbzdmm') 			or die("connect database fail!\n").mysql_error();
		$select=mysql_select_db('wav_test',$conn) 
			or die("connect wav database fail!\n").mysql_error();
		//$ss="set names gbk";
		//$aa=mysql_query($ss);
		foreach($task_info as $value)
		{
			$pos = strpos($value,' ');
			$row1 = substr($value,0,$pos);
			$row2 = substr($value,$pos+1);
			mysql_query("set names 'utf8'"); 
			$str="select * from WAV_FILES WHERE wavMd5='$value'";
			$recstr=mysql_query($str) or die (mysql_error());
			$row=mysql_fetch_row($recstr);
			$filepath=$row[3];
			if (!fwrite($handle,$filepath))
			{
				
				echo "can not write to $filename";
				exit;
			}
			fwrite($handle,"\n");
		}
		fwrite($handle,"\n");
		fclose($handle);
		mysql_close($conn);
	}
	
}

	$temp =$_SERVER['DOCUMENT_ROOT'] . "/TaskList/" . $_SERVER["REMOTE_ADDR"] .'_'. date("Ymd_His").'_';
	$msg=$_SERVER["REMOTE_ADDR"] .'_'. date("Ymd_His").'_';
	$filename_r = $_SERVER['DOCUMENT_ROOT'] . "/UploadedInfo/" . $_SERVER["REMOTE_ADDR"] .'_'.date("Ymd"). ".txt";
	$file_ch=$_POST["file_ch"];
	
	SaveTaskInfo($filename_r,$file_ch);
	
	$ch = $_POST["ch"];
	if(!empty($ch))
	{
		//create message queue
		$message_queue_key = ftok(".", 'a');
		
		$message_queue = msg_get_queue($message_queue_key, 0777);
		//echo $message_queue;
		//set taskId according to the taskname
		switch ($ch[0])
		{
			case "test":
				$buf = '0';
				break;
			case "Sentiment Analysis":
				$buf = '1';
				break;
			case "Homologous Analysis":
				$buf = '2';
				break;
			case "Source Analysis":
				$buf = '3';
				break;
			case "Keyword Search":
				$buf = '4';
				break;
		}	
		$filename_w=$temp.$buf.".txt";
		if (copy($filename_r,$filename_w)==FALSE)
			echo "Creating tasklist failed.";
		if (!msg_send ($message_queue, 1, $msg.$buf, true, true, $msg_err))
			echo "Msg not sent because $msg_err\n";
		unlink($filename_r);
		
		//send task to assigned ipc number
		$message_queue_key=ftok($filename_w,'a');
		$message_queue = msg_get_queue($message_queue_key, 0777);
		
		if (msg_receive ($message_queue, 2, $msg_type, 1024, $msg_result, true, 0, $msg_error))
		{
			
		} else
		{
			echo "Received $msg_error fetching message\n";
		}
		msg_remove_queue($message_queue);
		session_start();
		$_SESSION["filename"]=$msg.$buf;
		header("Location: result.php");
		
	}else
	{
		echo "Please choose a task type";
	}
	
?>
</body>
</html>
