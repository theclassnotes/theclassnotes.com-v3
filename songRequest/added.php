<?php require_once('Connections/config_db.php'); ?>
<?php
mysql_select_db($database_config_db, $config_db);
$query_rsBook = "SELECT * FROM adesbook ORDER BY `date` ASC";
$rsBook = mysql_query($query_rsBook, $config_db) or die(mysql_error());
$row_rsBook = mysql_fetch_assoc($rsBook);
$totalRows_rsBook = mysql_num_rows($rsBook);
?>
<?php include("header.php"); ?>
<link href="forText.css" rel="stylesheet" type="text/css">
<table width="500" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr>
    <?php if ($totalRows_rsBook == 0) { // Show if recordset empty ?>
    <td><div align="center">
        <p class="forHeader">Message Not Added!</p>
        <p class="forText">Please go back and correct your entry.</p>
    </div></td>
    <?php } // Show if recordset empty ?>
  </tr>
  <tr>
    <?php if ($totalRows_rsBook > 0) { // Show if recordset not empty ?>
    <td class="forText"><div align="center">
        <p>Thank you, your message has been added.<br>
      Please go to <a href="read.php">Read Messages</a>  to see your message. </p>
    </div></td>
<?php include("send_mail.php"); ?>
	
    <?php } // Show if recordset not empty ?>
  </tr>
</table>


<?php include("footer.php"); ?>
<?php
mysql_free_result($rsBook);
?>
