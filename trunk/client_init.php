<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<title>client_init</title> 
</head>
<body>
<?php
	
	$message_queue_key = ftok("./client/", 'a');
	
	$message_queue = msg_get_queue($message_queue_key, 0777 | IPC_PRIVATE);
	$filename = "./client/".$_SERVER["REMOTE_ADDR"].".txt";
	if (!$handle = fopen ($filename,"w"))
	{
		echo "can not open $filename";
		exit;
	};
	fputs($handle,$_SERVER["REMOTE_ADDR"]."\n");
	fputs($handle,"8080"."\n");
	fputs($handle,"1"."\n");
	fputs($handle,"\n");
	if (!msg_send ($message_queue, 1, $_SERVER["REMOTE_ADDR"], true, true, $msg_err))
			echo "Msg not sent because $msg_err\n";
?>
</body>
</html>
