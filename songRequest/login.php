<?php include("header.php"); ?>
<link href="forText.css" rel="stylesheet" type="text/css">

<form method="POST" name="login" id="login">
  <table width="400" border="0" align="center" cellpadding="3" cellspacing="1">
    <tr>
      <td width="100" class="forTableBgLeft">Username:</td>
      <td class="forTableBgRight">
      <input name="username" type="text" class="forForm" id="username">      </td>
    </tr>
    <tr>
      <td width="100" class="forTableBgLeft">Password:</td>
      <td class="forTableBgRight"><input name="password" type="password" class="forForm" id="password"></td>
    </tr>
    <tr>
      <td width="100" class="forTableBgLeft">&nbsp;</td>
      <td class="forTableBgRight"><input name="Submit" type="submit" class="forButton" value="Login"></td>
    </tr>
  </table>
</form>

<?php include("footer.php"); ?>
