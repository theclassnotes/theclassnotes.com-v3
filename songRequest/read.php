<?php require_once('Connections/config_db.php'); ?>
<?php require_once('Connections/config_db.php'); ?>
<?php

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rsRead = 5;
$pageNum_rsRead = 0;
if (isset($_GET['pageNum_rsRead'])) {
  $pageNum_rsRead = $_GET['pageNum_rsRead'];
}
$startRow_rsRead = $pageNum_rsRead * $maxRows_rsRead;

mysql_select_db($database_config_db, $config_db);
$query_rsRead = "SELECT * FROM requestbook ORDER BY requestbook.marker DESC, requestbook.`time`DESC";
$query_limit_rsRead = sprintf("%s LIMIT %d, %d", $query_rsRead, $startRow_rsRead, $maxRows_rsRead);
$rsRead = mysql_query($query_limit_rsRead, $config_db) or die(mysql_error());
$row_rsRead = mysql_fetch_assoc($rsRead);

if (isset($_GET['totalRows_rsRead'])) {
  $totalRows_rsRead = htmlentities($_GET['totalRows_rsRead']);
} else {
  $all_rsRead = mysql_query($query_rsRead);
  $totalRows_rsRead = mysql_num_rows($all_rsRead);
}
$totalPages_rsRead = ceil($totalRows_rsRead/$maxRows_rsRead)-1;

isset($startRow_rsRead)? $orderNum=$startRow_rsRead:$orderNum=0;

$queryString_rsRead = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsRead") == false && 
        stristr($param, "totalRows_rsRead") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsRead = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsRead = sprintf("&totalRows_rsRead=%d%s", $totalRows_rsRead, $queryString_rsRead);

# © Peter Affentranger, ANP Affentranger Net Productions, www.anp.ch
function MakeHyperlink($text) {
	$text = preg_replace("/((http(s?):\/\/)|(www\.))([\S\.]+)\b/i","<a href=\"http$3://$4$5\" target=\"_blank\">$2$4$5</a>", $text);
	$text = preg_replace("/([\w\.]+)(@)([\S\.]+)\b/i","<a href=\"mailto:$0\">$0</a>",$text);
	return nl2br($text);
}
?>
<?php include("header.php"); ?>
<table width="500"  border="0" align="center" cellpadding="1" cellspacing="0">
  <tr>
    <td><table width="100%"  border="0" cellpadding="0" cellspacing="1" class="Header_Footer_bg">
      <tr class="forText">
        <td>Displaying: <?php echo ($startRow_rsRead + 1) ?> - 
		<?php 
		if (ereg("^[0-9]+$", $totalRows_rsRead)) {
		echo min($startRow_rsRead + $maxRows_rsRead, $totalRows_rsRead); 
		}
		?> </td>
        <td align="right">Total Messages: <?php 
		
		if (ereg("^[0-9]+$", $totalRows_rsRead)) {
			  // echo "it's an Integer";
			  echo $totalRows_rsRead; 
			}
		
		
		?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><table width="497"  border="0" align="right" cellpadding="0" cellspacing="0">
      <tr>
        <td background="images/dot.gif"><img src="images/dot.gif" width="3" height="5"></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="500" border="0" align="center" cellpadding="1" cellspacing="1">

  <?php do { ?>
  <tr valign="top">
    <td class="forTableBgLeft">Date:</td>
    <td class="forTableBgRight"><?php echo $row_rsRead['date']; ?></td>
  </tr>
  <tr valign="top">
    <td width="120" class="forTableBgLeft">Name:</td>
    <td width="380" class="forTableBgRight"><?php echo $row_rsRead['firstName']; ?> <?php echo $row_rsRead['lastName']; ?></td>
  </tr>
  <tr valign="top">
    <?
	if ($showemail=="1") {
	?>
	<td width="120" class="forTableBgLeft">Email:</td>
    <td width="380" class="forTableBgRight">
	<?php 
	$email=$row_rsRead['email']; 
	$find = array('@');
	$replace = "(a)";
	$safemail = str_replace($find, $replace, $email);
	
	echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
	echo "<!-- // hide from old browsers\n";
	echo "document.write('<u>";
	echo $safemail; 
	echo "</u>'); \n";
	echo "// -->\n";
	echo "</script>\n";
	?>
	</td>
	<?
	}
	?>
  </tr>
  <?php /*START_PHP_SIRFCIT*/ ?>
  <tr valign="top">
    <td width="120" class="forTableBgLeft">Artist:</td>
    <td width="380" class="forTableBgRight"><?php echo $row_rsRead['artist']; ?></td>
  </tr>
  <?php /*END_PHP_SIRFCIT*/ ?>
  <?php /*START_PHP_SIRFCIT*/ ?>
  <tr valign="top">
    <td width="120" class="forTableBgLeft">Song:</td>
    <td width="380" class="forTableBgRight"><?php echo $row_rsRead['song']; ?></td>
  </tr>
  <?php /*END_PHP_SIRFCIT*/ ?>
  <tr valign="top">
    <td width="120" class="forTableBgLeft">Extra Comments:</td>
    <td width="380" class="forTableBgRight"><?php echo $row_rsRead['cmnt']; ?></td>
  </tr>
  <tr valign="top">
    <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td background="images/dot.gif"><img src="images/dot.gif" width="3" height="5"></td>
      </tr>
    </table></td>
  </tr>
  <?php } while ($row_rsRead = mysql_fetch_assoc($rsRead)); ?>
</table>
<table width="498"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr valign="middle" class="Header_Footer_bg">
    <td width="33%" height="20">&nbsp;
        <?php if ($pageNum_rsRead > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_rsRead=%d%s", $currentPage, max(0, $pageNum_rsRead - 1), $queryString_rsRead); ?>">Previous Page</a>
        <?php } // Show if not first page ?></td>
    <td width="33%" align="center"><a href="sign.php">Sign Guestbook</a></td>
    <td width="33%" align="right"><?php if ($pageNum_rsRead < $totalPages_rsRead) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_rsRead=%d%s", $currentPage, min($totalPages_rsRead, $pageNum_rsRead + 1), $queryString_rsRead); ?>">Next Page</a>
        <?php } // Show if not last page ?>
&nbsp;</td>
  </tr>
</table>
<table width="498" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td background="images/dot.gif"><img src="images/dot.gif" width="3" height="5" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" class="forTableBgLeft"><a href="http://www.adesdesign.net/" target="_blank" class="forText">AdesGuestbook v2.1 </a></td>
  </tr>
</table>
<?php include("footer.php"); ?>
<?php
mysql_free_result($rsRead);


?>
