<?php
session_start();
require_once('Connections/config_db.php');


function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
 
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "addMessage")) {

  $insertSQL = sprintf("INSERT INTO requestbook (firstName, lastName, email, song, artist, cmnt, `date`, marker) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['firstName'], "text"),
                       GetSQLValueString($_POST['lastName'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
											 GetSQLValueString($_POST['song'], "text"),
                       GetSQLValueString($_POST['artist'], "text"),
                       GetSQLValueString($_POST['cmnt'], "text"),
                       GetSQLValueString($_POST['date'], "text"),
                       GetSQLValueString($_POST['date2'], "date"));

   $_SESSION["firstName"] = $_POST['firstName'];
   $_SESSION["lastName"] = $_POST['lastName'];
   $_SESSION["email"] = $_POST['email'];
	 $_SESSION["song"] = $_POST['song'];
   $_SESSION["artist"] = $_POST['artist'];
   $_SESSION["cmnt"] = $_POST['cmnt'];
   $_SESSION["firstName"] = $_POST['firstName'];
   /*
   echo '<pre>';
   print_r($_POST);
   echo "</pre>";
   echo $insertSQL;
   die();
   */
   
   // Checking confirmation code to prevent bots
   if(md5($_POST['code']) != $_SESSION['key'])
{
  		echo "Please enter correct confirmation code <a href=sign.php>click here to go back.</a>";
		echo "<SCRIPT LANGUAGE=\"JavaScript\">
		window.location=\"sign.php?error=confirmation_code_incorrect\";
		</script>";
		
		//die();
}

  mysql_select_db($database_config_db, $config_db);
  $Result1 = mysql_query($insertSQL, $config_db) or die(mysql_error());

  $insertGoTo = "added.php?date=".$HTTP_POST_VARS['date']."";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  
   unset($_SESSION['firstName']);
   unset($_SESSION['lastName']);   
   unset($_SESSION['email']);
	 unset($_SESSION['song']);
   unset($_SESSION['artist']);
   unset($_SESSION['cmnt']);
  
  header(sprintf("Location: %s", $insertGoTo));
  
  
}
include("header.php"); 
?>

<link href="forText.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {
	font-size: 12px;
	font-weight: bold;
	color: #CC0000;
}
-->
</style>
<form action="<?php echo $editFormAction; ?>" method="POST" name="addMessage" id="addMessage" onSubmit="VF_addMessage();return false;">

  <br>
  <table width="100%"  border="0" cellspacing="3" cellpadding="0">
    <tr>
      <td><table width="500" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#999999">
        <tr>
          <td><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" class="forTableBgRight">
              <tr>
                <td height="25" colspan="2">
				<?
				$error=$_GET["error"];
				if ($error=="confirmation_code_incorrect") {
				echo "<font color=red> <b>Please retype the confirmation code!</b></font><br>";
				}
				?>
				<span class="style1">Request a Song</span></td>
              </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="500" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#999999">
        <tr>
          <td><table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#FFFFFF">
              <tr>
                <td width="120" bgcolor="#F3F3F3" class="forTableBgLeft">First Name:</td>
                <td colspan="2" bgcolor="#F8F8F8" class="forTableBgRight"><input name="firstName" type="text" class="forForm" id="firstName3" value="<? echo $_SESSION["firstName"];?>" size="25">
                    <span class="forText" style="color: #FF3300">*</span></td>
              </tr>
              <tr>
                <td width="120" bgcolor="#F3F3F3" class="forTableBgLeft">Last Name: </td>
                <td colspan="2" bgcolor="#F8F8F8" class="forTableBgRight"><input name="lastName" type="text" class="forForm" id="lastName3" value="<? echo $_SESSION["lastName"];?>" size="25">
                    <span class="forText" style="color: #FF3300">*</span></td>
              </tr>
              <tr>
                <td bgcolor="#F3F3F3" class="forTableBgLeft">Email:</td>
                <td width="200" bgcolor="#F8F8F8" class="forTableBgRight"><input name="email" type="text" class="forForm" id="email3" value="<? echo $_SESSION["email"];?>" size="25">
                  <span class="forText" style="color: #FF3300">*</span></td>
                <td bgcolor="#F8F8F8" class="forTableBgRight">Won't be displayed </td>
              </tr>
              <tr>
                <td bgcolor="#F3F3F3" class="forTableBgLeft">Artist:</td>
                <td colspan="2" bgcolor="#F8F8F8" class="forTableBgRight"><input name="artist" type="text" class="forForm" id="website3" value="<? echo $_SESSION["artist"];?>" size="25"></td>
              </tr>
              <tr>
                <td bgcolor="#F3F3F3" class="forTableBgLeft">Song:</td>
                <td colspan="2" bgcolor="#F8F8F8" class="forTableBgRight"><font face="Arial, Helvetica"><input name="song" type="text" class="forForm" id="website3" value="<? echo $_SESSION["song"];?>" size="25"></td>
              </tr>
              <tr valign="top">
                <td bgcolor="#F3F3F3" class="forTableBgLeft">Extra Comments:</td>
                <td colspan="2" bgcolor="#F8F8F8" class="forTableBgRight"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr valign="top">
                      <td width="260"><textarea name="cmnt" cols="45" rows="6" class="forForm" id="textarea3"><? echo $_SESSION["cmnt"];?></textarea></td>
                      <td><span class="forText" style="color: #FF3300">*</span></td>
                    </tr>
                </table></td>
              </tr>
              <tr align="left">
                <td height="40" valign="top" class="forTableBgLeft"><img src="image.php" border="0" /></td>
                <td height="40" colspan="2" valign="top" class="forTableBgRight"><input name="code" type="text" id="code" size="10" maxlength="7" />
                    <font color="#FF6600">*</font><br />
                  Anti-spam word (required)</td>
              </tr>
              <tr>
                <td bgcolor="#F3F3F3" class="forTableBgLeft"><?php
$today = date("d M Y h:i A");      
            
?>
<input name="date" type="hidden" id="date3" value="<?php echo $today ?>"> <?php
$marker = date("Y.m.j");       
            
?>
<input name="date2" type="hidden" id="date" value="<?php echo $marker ?>"></td>
                <td colspan="2" bgcolor="#F8F8F8" class="forTableBgRight">
                  <table width="100%"  border="0" cellspacing="0" cellpadding="2">
                    <tr>
                      <td><input name="Submit" type="submit" class="forButton" value="Submit"></td>
                    </tr>
                </table></td>
              </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="500" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#999999">
        <tr>
          <td><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" class="forTableBgRight">
              <tr>
                <td height="25" colspan="2" align="center">&nbsp;&nbsp;HTML tags are not allowed. Required fields are denoted by<span class="forText" style="color: #FF3300">*</span></td>
              </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
  </table>

  <input type="hidden" name="MM_insert" value="addMessage">
</form>



<?php include("footer.php"); ?>
