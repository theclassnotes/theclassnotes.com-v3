<?php 
require_once('../Connections/config_db.php'); 
include("adminOnly.php");
$currentPage = $_SERVER["PHP_SELF"];
if (isset($_POST['action'])  && isset($_POST["id"]) && $_POST['action'] == 'submitted') {
$id=$_POST["id"];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$country = $_POST['country'];
$email = $_POST['email'];
$website = $_POST['website'];
$cmnt = $_POST['cmnt'];
$firstName = $_POST['firstName'];

$editSQL = sprintf("UPDATE adesbook SET firstName='$firstName', lastName='$lastName', email='$email', website='$website', country='$country', cmnt='$cmnt'  WHERE ID='$id'");

  mysql_select_db($database_config_db, $config_db);
  $Result1 = mysql_query($editSQL, $config_db) or die(mysql_error());
  //echo $editSQL;
//  die();
  
  		echo "<SCRIPT LANGUAGE=\"JavaScript\">
		window.location=\"admin_panel.php?message=edited\";
		</script>";

}

$do = $_GET["do"];
$id = $_GET["id"];

if (!$do || !$id) {
echo "Please select an entry and an action - delete or edit!";
}
else {

if ($do =="delete") {
include("adminOnly.php");
$deleteSQL = sprintf("DELETE FROM adesbook WHERE ID='$id'");

  mysql_select_db($database_config_db, $config_db);
  $Result1 = mysql_query($deleteSQL, $config_db) or die(mysql_error());
  
  		echo "<SCRIPT LANGUAGE=\"JavaScript\">
		window.location=\"admin_panel.php?message=deleted\";
		</script>";
		
}


$maxRows_rsRead = 10;
$pageNum_rsRead = 0;
if (isset($_GET['pageNum_rsRead'])) {
  $pageNum_rsRead = $_GET['pageNum_rsRead'];
}
$startRow_rsRead = $pageNum_rsRead * $maxRows_rsRead;

mysql_select_db($database_config_db, $config_db);
$query_rsRead = "SELECT * FROM adesbook ORDER BY adesbook.marker DESC, adesbook.`time`DESC";
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

# � Peter Affentranger, ANP Affentranger Net Productions, www.anp.ch
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
            Email</td>
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
        <td align="center" class="forTableBgLeft"></td>
      </tr>
      <tr>
        <td align="center" class="forTableBgLeft"><a href="adminLogOut.php" target="_parent">Log Out</a></td>
      </tr>
    </table></td>
    <td align="left"><table width="498" border="0" align="center" cellpadding="3" cellspacing="0">
        <tr>
          <td align="center">
		  <?
		  if ($do =="edit") {
include("adminOnly.php");
mysql_select_db($database_config_db, $config_db);
$query_rsRead = "SELECT * FROM adesbook WHERE ID='$id'";
$rsRead = mysql_query($query_rsRead, $config_db) or die(mysql_error());
$row_rsRead = mysql_fetch_assoc($rsRead);
//echo $row_rsRead['firstName']; 
//die();
		  
		  ?>
		  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr>
      <td><table width="500" border="0" align="center" cellpadding="1" cellspacing="0">
        <tr>
          <td bgcolor="#999999"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" class="forTableBgRight">
              <tr>
                <td height="25" colspan="2"><span class="style1">
                  <?
echo "Editing ID:".$id;
}
}
?>
                </span></td>
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
                <td bgcolor="#F8F8F8" class="forTableBgRight"><input name="firstName" type="text" class="forForm" id="firstName3" value="<? echo $row_rsRead['firstName']; ?>" size="25" />
                    <span class="forText" style="color: #FF3300">*</span></td>
              </tr>
              <tr>
                <td width="120" bgcolor="#F3F3F3" class="forTableBgLeft">Last Name: </td>
                <td bgcolor="#F8F8F8" class="forTableBgRight"><input name="lastName" type="text" class="forForm" id="lastName3" value="<? echo $row_rsRead['lastName']; ?>" size="25" />
                    <span class="forText" style="color: #FF3300">*</span></td>
              </tr>
              <tr>
                <td bgcolor="#F3F3F3" class="forTableBgLeft">Email:</td>
                <td bgcolor="#F8F8F8" class="forTableBgRight"><input name="email" type="text" class="forForm" id="email3" value="<? echo $row_rsRead['email']; ?>" size="25" />
                    <span class="forText" style="color: #FF3300">*</span></td>
              </tr>
              <tr>
                <td bgcolor="#F3F3F3" class="forTableBgLeft">Website:</td>
                <td bgcolor="#F8F8F8" class="forTableBgRight"><input name="website" type="text" class="forForm" id="website3" value="<? echo $row_rsRead['website']; ?>" size="25" /></td>
              </tr>
              <tr>
                <td bgcolor="#F3F3F3" class="forTableBgLeft">Country:</td>
                <td bgcolor="#F8F8F8" class="forTableBgRight"><font face="Arial, Helvetica"><small>
                  <select name="country" class="forForm" id="select2">
                    <option value="">Select Country</option>
                    <option>-------------------------------------------------</option>
                    <option value="Afghanistan ">Afghanistan </option>
                    <option value="Albania">Albania</option>
                    <option value="Algeria">Algeria</option>
                    <option value="American Samoa">American Samoa</option>
                    <option value="Andorra">Andorra</option>
                    <option value="Angola">Angola</option>
                    <option value="Anguilla">Anguilla</option>
                    <option value="Antarctica">Antarctica</option>
                    <option value="Antigua And Barbuda">Antigua And Barbuda</option>
                    <option value="Argentina">Argentina</option>
                    <option value="Armenia">Armenia</option>
                    <option value="Aruba">Aruba</option>
                    <option value="Australia">Australia</option>
                    <option value="Austria">Austria</option>
                    <option value="Azerbaijan">Azerbaijan</option>
                    <option value="Bahamas, The">Bahamas, The</option>
                    <option value="Bahrain">Bahrain</option>
                    <option value="Bangladesh">Bangladesh</option>
                    <option value="Barbados">Barbados</option>
                    <option value="Belarus">Belarus</option>
                    <option value="Belgium">Belgium</option>
                    <option value="Belize">Belize</option>
                    <option value="Benin">Benin</option>
                    <option value="Bermuda">Bermuda</option>
                    <option value="Bhutan">Bhutan</option>
                    <option value="Bolivia">Bolivia</option>
                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                    <option value="Botswana">Botswana</option>
                    <option value="Bouvet Island">Bouvet Island</option>
                    <option value="Brazil">Brazil</option>
                    <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                    <option value="Brunei">Brunei</option>
                    <option value="Bulgaria">Bulgaria</option>
                    <option value="Burkina Faso">Burkina Faso</option>
                    <option value="Burundi">Burundi</option>
                    <option value="Cambodia">Cambodia</option>
                    <option value="Cameroon">Cameroon</option>
                    <option value="Canada">Canada</option>
                    <option value="Cape Verde">Cape Verde</option>
                    <option value="Cayman Islands">Cayman Islands</option>
                    <option value="Central African Republic">Central African Republic</option>
                    <option value="Chad">Chad</option>
                    <option value="Chile">Chile</option>
                    <option value="China">China</option>
                    <option value="Christmas Island">Christmas Island</option>
                    <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                    <option value="Colombia">Colombia</option>
                    <option value="Comoros">Comoros</option>
                    <option value="Congo">Congo</option>
                    <option value="Congo">Congo</option>
                    <option value="Cook Islands">Cook Islands</option>
                    <option value="Costa Rica">Costa Rica</option>
                    <option value="Cote D'Ivoire (Ivory Coast)">Cote D'Ivoire (Ivory Coast)</option>
                    <option value="Croatia (Hrvatska)">Croatia (Hrvatska)</option>
                    <option value="Cuba">Cuba</option>
                    <option value="Cyprus">Cyprus</option>
                    <option value="Czech Republic">Czech Republic</option>
                    <option value="Denmark">Denmark</option>
                    <option value="Djibouti">Djibouti</option>
                    <option value="Dominica">Dominica</option>
                    <option value="Dominican Republic">Dominican Republic</option>
                    <option value="East Timor">East Timor</option>
                    <option value="Ecuador">Ecuador</option>
                    <option value="Egypt">Egypt</option>
                    <option value="El Salvador">El Salvador</option>
                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                    <option value="Eritrea">Eritrea</option>
                    <option value="Estonia">Estonia</option>
                    <option value="Ethiopia">Ethiopia</option>
                    <option value="Falkland Islands (Islas Malvinas)">Falkland Islands (Islas Malvinas)</option>
                    <option value="Faroe Islands">Faroe Islands</option>
                    <option value="Fiji Islands">Fiji Islands</option>
                    <option value="Finland">Finland</option>
                    <option value="France">France</option>
                    <option value="French Guiana">French Guiana</option>
                    <option value="French Polynesia">French Polynesia</option>
                    <option value="French Southern Territories">French Southern Territories</option>
                    <option value="Gabon">Gabon</option>
                    <option value="Gambia, The">Gambia, The</option>
                    <option value="Georgia">Georgia</option>
                    <option value="Germany">Germany</option>
                    <option value="Ghana">Ghana</option>
                    <option value="Gibraltar">Gibraltar</option>
                    <option value="Greece">Greece</option>
                    <option value="Greenland">Greenland</option>
                    <option value="Grenada">Grenada</option>
                    <option value="Guadeloupe">Guadeloupe</option>
                    <option value="Guam">Guam</option>
                    <option value="Guatemala">Guatemala</option>
                    <option value="Guinea">Guinea</option>
                    <option value="Guinea-Bissau">Guinea-Bissau</option>
                    <option value="Guyana">Guyana</option>
                    <option value="Haiti">Haiti</option>
                    <option value="Heard and McDonald Islands">Heard and McDonald Islands</option>
                    <option value="Honduras">Honduras</option>
                    <option value="Hong Kong S.A.R.">Hong Kong S.A.R.</option>
                    <option value="Hungary">Hungary</option>
                    <option value="Iceland">Iceland</option>
                    <option value="India">India</option>
                    <option value="Indonesia">Indonesia</option>
                    <option value="Iran">Iran</option>
                    <option value="Iraq">Iraq</option>
                    <option value="Ireland">Ireland</option>
                    <option value="Israel">Israel</option>
                    <option value="Italy">Italy</option>
                    <option value="Jamaica">Jamaica</option>
                    <option value="Japan">Japan</option>
                    <option value="Jordan">Jordan</option>
                    <option value="Kazakhstan">Kazakhstan</option>
                    <option value="Kenya">Kenya</option>
                    <option value="Kiribati">Kiribati</option>
                    <option value="Korea">Korea</option>
                    <option value="Korea, North ">Korea, North </option>
                    <option value="Kuwait">Kuwait</option>
                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                    <option value="Laos">Laos</option>
                    <option value="Latvia">Latvia</option>
                    <option value="Lebanon">Lebanon</option>
                    <option value="Lesotho">Lesotho</option>
                    <option value="Liberia">Liberia</option>
                    <option value="Libya">Libya</option>
                    <option value="Liechtenstein">Liechtenstein</option>
                    <option value="Lithuania">Lithuania</option>
                    <option value="Luxembourg">Luxembourg</option>
                    <option value="Macau S.A.R.">Macau S.A.R.</option>
                    <option value="Macedonia">Macedonia</option>
                    <option value="Madagascar">Madagascar</option>
                    <option value="Malawi">Malawi</option>
                    <option value="Malaysia">Malaysia</option>
                    <option value="Maldives">Maldives</option>
                    <option value="Mali">Mali</option>
                    <option value="Malta">Malta</option>
                    <option value="Marshall Islands">Marshall Islands</option>
                    <option value="Martinique">Martinique</option>
                    <option value="Mauritania">Mauritania</option>
                    <option value="Mauritius">Mauritius</option>
                    <option value="Mayotte">Mayotte</option>
                    <option value="Mexico">Mexico</option>
                    <option value="Micronesia">Micronesia</option>
                    <option value="Moldova">Moldova</option>
                    <option value="Monaco">Monaco</option>
                    <option value="Mongolia">Mongolia</option>
                    <option value="Montserrat">Montserrat</option>
                    <option value="Morocco">Morocco</option>
                    <option value="Mozambique">Mozambique</option>
                    <option value="Myanmar">Myanmar</option>
                    <option value="Namibia">Namibia</option>
                    <option value="Nauru">Nauru</option>
                    <option value="Nepal">Nepal</option>
                    <option value="Netherlands Antilles">Netherlands Antilles</option>
                    <option value="Netherlands, The">Netherlands, The</option>
                    <option value="New Caledonia">New Caledonia</option>
                    <option value="New Zealand">New Zealand</option>
                    <option value="Nicaragua">Nicaragua</option>
                    <option value="Niger">Niger</option>
                    <option value="Nigeria">Nigeria</option>
                    <option value="Niue">Niue</option>
                    <option value="Norfolk Island">Norfolk Island</option>
                    <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                    <option value="Norway">Norway</option>
                    <option value="Oman">Oman</option>
                    <option value="Pakistan">Pakistan</option>
                    <option value="Palau">Palau</option>
                    <option value="Panama">Panama</option>
                    <option value="Papua new Guinea">Papua new Guinea</option>
                    <option value="Paraguay">Paraguay</option>
                    <option value="Peru">Peru</option>
                    <option value="Philippines">Philippines</option>
                    <option value="Pitcairn Island">Pitcairn Island</option>
                    <option value="Poland">Poland</option>
                    <option value="Portugal">Portugal</option>
                    <option value="Puerto Rico">Puerto Rico</option>
                    <option value="Qatar">Qatar</option>
                    <option value="Reunion">Reunion</option>
                    <option value="Romania">Romania</option>
                    <option value="Russia">Russia</option>
                    <option value="Rwanda">Rwanda</option>
                    <option value="Saint Helena">Saint Helena</option>
                    <option value="Saint Kitts And Nevis">Saint Kitts And Nevis</option>
                    <option value="Saint Lucia">Saint Lucia</option>
                    <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                    <option value="Saint Vincent And The Grenadines">Saint Vincent And The Grenadines</option>
                    <option value="Samoa">Samoa</option>
                    <option value="San Marino">San Marino</option>
                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                    <option value="Saudi Arabia">Saudi Arabia</option>
                    <option value="Senegal">Senegal</option>
                    <option value="Seychelles">Seychelles</option>
                    <option value="Sierra Leone">Sierra Leone</option>
                    <option value="Singapore">Singapore</option>
                    <option value="Slovakia">Slovakia</option>
                    <option value="Slovenia">Slovenia</option>
                    <option value="Solomon Islands">Solomon Islands</option>
                    <option value="Somalia">Somalia</option>
                    <option value="South Africa">South Africa</option>
                    <option value="South Georgia ">South Georgia </option>
                    <option value="Spain">Spain</option>
                    <option value="Sri Lanka">Sri Lanka</option>
                    <option value="Sudan">Sudan</option>
                    <option value="Suriname">Suriname</option>
                    <option value="Svalbard And Jan Mayen Islands">Svalbard And Jan Mayen Islands</option>
                    <option value="Swaziland">Swaziland</option>
                    <option value="Sweden">Sweden</option>
                    <option value="Switzerland">Switzerland</option>
                    <option value="Syria">Syria</option>
                    <option value="Taiwan">Taiwan</option>
                    <option value="Tajikistan">Tajikistan</option>
                    <option value="Tanzania">Tanzania</option>
                    <option value="Thailand">Thailand</option>
                    <option value="Togo">Togo</option>
                    <option value="Tokelau">Tokelau</option>
                    <option value="Tonga">Tonga</option>
                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                    <option value="Tunisia">Tunisia</option>
                    <option value="Turkey">Turkey</option>
                    <option value="Turkmenistan">Turkmenistan</option>
                    <option value="Turks And Caicos Islands">Turks And Caicos Islands</option>
                    <option value="Tuvalu">Tuvalu</option>
                    <option value="Uganda">Uganda</option>
                    <option value="Ukraine">Ukraine</option>
                    <option value="United Arab Emirates">United Arab Emirates</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <option value="United States">United States</option>
                    <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                    <option value="Uruguay">Uruguay</option>
                    <option value="Uzbekistan">Uzbekistan</option>
                    <option value="Vanuatu">Vanuatu</option>
                    <option value="Vatican City State">Vatican City State</option>
                    <option value="Venezuela">Venezuela</option>
                    <option value="Vietnam">Vietnam</option>
                    <option value="Virgin Islands (British)">Virgin Islands (British)</option>
                    <option value="Virgin Islands (US)">Virgin Islands (US)</option>
                    <option value="Wallis And Futuna Islands">Wallis And Futuna Islands</option>
                    <option value="Yemen">Yemen</option>
                    <option value="Yugoslavia">Yugoslavia</option>
                    <option value="Zambia">Zambia</option>
                    <option value="Zimbabwe">Zimbabwe</option>
                  </select>
                </small></font></td>
              </tr>
              <tr valign="top">
                <td bgcolor="#F3F3F3" class="forTableBgLeft">Message:</td>
                <td bgcolor="#F8F8F8" class="forTableBgRight"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr valign="top">
                      <td width="260"><textarea name="cmnt" cols="50" rows="6" class="forForm" id="textarea3"><? echo $row_rsRead['cmnt']; ?></textarea></td>
                      <td><span class="forText" style="color: #FF3300">*</span></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td bgcolor="#F3F3F3" class="forTableBgLeft"></td>
                <td bgcolor="#F8F8F8" class="forTableBgRight"><table width="100%"  border="0" cellspacing="0" cellpadding="2">
                    <tr>
                      <td><input type="hidden" name="action" value="submitted" />
                          <input type="hidden" name="id" value="<? echo $row_rsRead['ID']; ?>" />
                          <input type="submit" name="submit" value="Update" class="forButton" />
                      </td>
                    </tr>
                </table></td>
              </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
		  
		  </td>
        </tr>
        <tr>
          <td align="center" class="forTableBgLeft"><a href="http://www.adesdesign.net/" target="_blank" class="forText">AdesGuestbook v2.0 </a></td>
        </tr>
    </table></td>
  </tr>
</table>
</body></html>