<!-- doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN"-->
<html>
<head>
	<TITLE>Admin Center Login</TITLE>

	

	<meta name="robots" content="noindex,nofollow">

    <link href="../forText.css" rel="stylesheet" type="text/css">
</head>



<body onload="window.document.adminLoginForm.formuser.focus()">
<!--START OF adminLoginForm.php -->
<blockquote>
	<p><br></p>
	<!--  -->
	<form method="post" name="adminLoginForm" action="adminLogin.php">
	<?php $loginAttempts = !isset($_POST['loginAttempts'])?1:$_POST['loginAttempts'] + 1;?>
		<input type="hidden" name="loginAttempts" value="<?php echo $loginAttempts;?>">
		<table width="300" border="0" align="center" cellpadding="5">
  <tr> 
    <th colspan=2 class="forTableBgLeft">Login to Admin Center</th>
  </tr>
  <tr> 
    <td width="80" class="forTableBgRight">Username:</td>
    <td class="forTableBgRight"> <input name="formuser" type="text" class="forForm" value="<?php echo $formuser;?>"> </td>
  </tr>
  <tr> 
    <td width="80" class="forTableBgRight">Password:</td>
    <td class="forTableBgRight"> <input name="formpassword" type="password" class="forForm" value="<?php echo $formpassword;?>">    </td>
  </tr>
  <tr>
    <td width="80" class="forTableBgRight">&nbsp;</td>
    <td class="forTableBgRight"><input class="forButton" type="submit" name="submit" value="Login"></td>
  </tr>
</table>
	</form>
</blockquote>		
<!--END of adminLoginForm.php -->
</body>
</html>