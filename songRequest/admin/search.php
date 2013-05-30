<?php 
require_once('../Connections/config_db.php'); 
include("adminOnly.php");
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rsRead = 10;
$pageNum_rsRead = 0;
if (isset($_GET['pageNum_rsRead'])) {
  $pageNum_rsRead = $_GET['pageNum_rsRead'];
}
$startRow_rsRead = $pageNum_rsRead * $maxRows_rsRead;

mysql_select_db($database_config_db, $config_db);

$keyword=$_POST["keyword"];
$option=$_POST["option"];

if (!$keyword) {
echo "Please enter a keyword to search!";
die();
}
if ($option==1) {
//echo "Name search";
$query_rsRead = "SELECT * FROM adesbook where firstName like '%$keyword%'";
//echo $query_rsRead;
//die();
}
elseif ($option==2) {
//echo "Email search";
$query_rsRead = "SELECT * FROM adesbook where email like '%$keyword%'";
//echo $query_rsRead;
//die();
}

elseif (!$option) {
//echo "name & email search";
$query_rsRead = "SELECT * FROM adesbook where firstName like '%$keyword%' or email like '%$keyword%'";
//echo $query_rsRead;
//die();
}
//die();

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
<html><head>
<link href="../forText.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {
	font-size: 14px;
	font-weight: bold;
}
#hideShow {
	position:absolute;
	left:27px;
	top:97px;
	width:343px;
	height:164px;
	z-index:1;
	background-color: #FFFFFF;
	visibility: hidden;
}
-->
</style>
<script language=javascript type='text/javascript'>
function hideDiv() {
if (document.getElementById) { // DOM3 = IE5, NS6
document.getElementById('hideShow').style.visibility = 'hidden';
}
else {
if (document.layers) { // Netscape 4
document.hideShow.visibility = 'hidden';
}
else { // IE 4
document.all.hideShow.style.visibility = 'hidden';
}
}
}

function showDiv() {
if (document.getElementById) { // DOM3 = IE5, NS6
document.getElementById('hideShow').style.visibility = 'visible';
}
else {
if (document.layers) { // Netscape 4
document.hideShow.visibility = 'visible';
}
else { // IE 4
document.all.hideShow.style.visibility = 'visible';
}
}
}
</script> 
</head>
<body>
<div id="hideShow">
<form id="form1" name="form1" method="post" action="search.php">
  <table width="100%" border="0" align="center" cellpadding="1" cellspacing="4" bgcolor="#FFFFFF">
    <tr>
      <td bgcolor="#999999"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" class="forTableBgRight">
          <tr>
            <td height="25" colspan="2"><span class="style1">Search</span></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td bgcolor="#999999"><table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#FFFFFF">
          <tr>
            <td width="120" bgcolor="#F3F3F3" class="forTableBgLeft">Keyword:</td>
            <td bgcolor="#F8F8F8" class="forTableBgRight"><input name="keyword" type="text" class="forForm" id="firstName3" size="25" /></td>
          </tr>
          <tr>
            <td width="120" bgcolor="#F3F3F3" class="forTableBgLeft">Search in: </td>
            <td bgcolor="#F8F8F8" class="forTableBgRight"> 
              <input name="option" type="radio" value="1" />
            Name 
            <input name="option" type="radio" value="2" />
            Email </td>
          </tr>
          <tr>
            <td bgcolor="#F3F3F3" class="forTableBgLeft"></td>
            <td bgcolor="#F8F8F8" class="forTableBgRight"><input type="submit" name="submit" value="Search" class="forButton" /></td>
          </tr>
          <tr>
            <td colspan="2" align="center" bgcolor="#F3F3F3" class="forTableBgLeft"> <a href="javascript:hideDiv()"><b>Close</b> </a></td>
            </tr>
      </table></td>
    </tr>
  </table>
</form>

</div>
<table width="750"  border="0" align="left" cellpadding="3" cellspacing="3">
  <tr>
    <td width="220" align="left" valign="top"><table width="200" border="0" align="center" cellpadding="5" cellspacing="1">
      <tr>
        <td align="center" class="forTableBgLeft style1">Welcome Admin</td>
      </tr>
      <tr>
        <td align="center" class="forTableBgLeft"><a href="admin_panel.php">Main Page</a> </td>
      </tr>
      <tr>
        <td align="center" class="forTableBgLeft"><a href="javascript:showDiv()">Search</a></td>
      </tr>
      <tr>
        <td align="center" class="forTableBgLeft"><?
		if ($_GET["message"]=="deleted") {
		echo "<font color=red>Deleted successfully!</font>";
		}
		
		if ($_GET["message"]=="edited") {
		echo "<font color=red>Edited successfully!</font>";
		}
		?></td>
      </tr>
      <tr>
        <td align="center" class="forTableBgLeft"><a href="adminLogOut.php" target="_parent">Log Out</a></td>
      </tr>
    </table></td>
    <td align="left"><table width="500"  border="0" align="center" cellpadding="1" cellspacing="0">
      <tr>
        <td><table width="100%"  border="0" cellpadding="0" cellspacing="1" class="Header_Footer_bg">
            <tr class="forText">
              <td>Displaying: <?php echo ($startRow_rsRead + 1) ?> -
                  <?php 
		if (ereg("^[0-9]+$", $totalRows_rsRead)) {
		echo min($startRow_rsRead + $maxRows_rsRead, $totalRows_rsRead); 
		}
		?>
              </td>
              <td align="right">Total Messages:
                  <?php 
		
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
              <td background="../images/dot.gif"><img src="../images/dot.gif" width="3" height="5"></td>
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
          <td width="120" class="forTableBgLeft">Email:</td>
          <td width="380" class="forTableBgRight"><?php 
	 echo "<a href=\"mailto:>".$row_rsRead['email']."\">".$row_rsRead['email']."</a>"; 
	?>
          </td>
        </tr>
        <?php /*START_PHP_SIRFCIT*/ if ($row_rsRead['website']!=""){ ?>
        <tr valign="top">
          <td width="120" class="forTableBgLeft">Website:</td>
          <td width="380" class="forTableBgRight"><?php echo MakeHyperlink($row_rsRead['website']); ?></td>
        </tr>
        <?php } /*END_PHP_SIRFCIT*/ ?>
        <?php /*START_PHP_SIRFCIT*/ if ($row_rsRead['country']!=""){ ?>
        <tr valign="top">
          <td width="120" class="forTableBgLeft">Country:</td>
          <td width="380" class="forTableBgRight"><?php echo $row_rsRead['country']; ?></td>
        </tr>
        <?php } /*END_PHP_SIRFCIT*/ ?>
        <tr valign="top">
          <td width="120" class="forTableBgLeft">Message:</td>
          <td width="380" class="forTableBgRight"><?php echo $row_rsRead['cmnt']; ?></td>
        </tr>
        <!-- generate admin features-->
        <tr valign="top">
          <td width="120" class="forTableBgLeft">&nbsp;</td>
          <td width="380" height="30" align="right" valign="middle" class="forTableBgRight"><a href="action.php?do=delete&id=<? echo $row_rsRead["ID"];?>" onClick="return confirm('Are you sure you want to delete message from <? echo $row_rsRead["firstName"];?>?')"><img src="appimage/delete.jpg" border="0"></a> <a href="action.php?do=edit&id=<? echo $row_rsRead["ID"];?>"><img src="appimage/edit.jpg" border="0"></a> </td>
        </tr>
        <!-- end-->
        <tr valign="top">
          <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td background="../images/dot.gif"><img src="../images/dot.gif" width="3" height="5"></td>
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
          <td width="33%" align="center">&nbsp;</td>
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
                <td background="../images/dot.gif"><img src="../images/dot.gif" width="3" height="5" /></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td align="center" class="forTableBgLeft"><a href="http://www.adesdesign.net/" target="_blank" class="forText">AdesGuestbook v2.0 </a></td>
        </tr>
    </table></td>
  </tr>
</table>
</body></html>
<?php
mysql_free_result($rsRead);


?>