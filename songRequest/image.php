<?
session_start();
// confirmation code generation
$md5 = md5(microtime() * mktime());

// let's bring it down to 5 digits and make all caps
$string = strtoupper(substr($md5,0,5));

$captcha = imagecreatefrompng("images/captcha.png");

$black = imagecolorallocate($captcha, 0, 0, 0);
$line = imagecolorallocate($captcha,233,14,91);

//creating two lines
//imageline($captcha,10,11,39,29,$line);
//imageline($captcha,40,0,164,29,$line);

imagestring($captcha, 233, 20, 10, $string, $black);

//write the confirmation code into session
$_SESSION['key'] = md5($string);

//finally generate the image
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // In the past
header("Pragma: no-cache");
header("Content-type: image/png");
imagepng($captcha);
?>