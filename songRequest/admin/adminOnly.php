<?php
session_start();
if(   (!isset($_SESSION['adminUser'])) || (!isset($_SESSION['adminPassword'])) ) {
	include_once("adminLogin.php");
	echo "<SCRIPT LANGUAGE=\"JavaScript\">
		window.location=\"index.php?message=login\";
		</script>";
	exit;
}


if( ($_SESSION['adminUser'] != ADMINUSER) || ($_SESSION['adminPassword'] != ADMINPASSWORD) ) {
	
	include_once("adminLogin.php");
	echo "<SCRIPT LANGUAGE=\"JavaScript\">
		window.location=\"index.php?message=login\";
		</script>";
	
	
	exit;
}
?>