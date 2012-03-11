<?php 
	$message_queue_key = ftok("./uploadify", 'a');
	$message_queue = msg_get_queue($message_queue_key, 0777);
	if (!msg_send ($message_queue, 1, "QUIT", true, true, $msg_err))
		echo "Msg not sent because $msg_err\n";
?>