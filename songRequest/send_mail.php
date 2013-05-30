<?php 
  	$to = "your@email.com";
	$msg .= "AdesGuestbook Notification:\n";
	$msg .= "New message has just been added to your guestbook. Please check.\n\n";
	mail($to, AdesGuestbook, $msg) or die ("Couldn't send mail!");
    ?>