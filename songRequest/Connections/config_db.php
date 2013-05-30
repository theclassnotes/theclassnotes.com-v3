<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_config_db = "localhost";
$database_config_db = "[redacted]";
$username_config_db = "[redacted]";
$password_config_db = "[redacted]";
$config_db = mysql_pconnect($hostname_config_db, $username_config_db, $password_config_db) or trigger_error(mysql_error(),E_USER_ERROR);

// if you don't want to show Emails in your guestbook change to 0, if you want to show change the value to 1
$showemail=0;

// Admin username and password settings
define("ADMINUSER", "[redacted]"); // admin username
define("ADMINPASSWORD", "[redacted]"); // admin password
?>