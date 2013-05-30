<html>
<head>
<title>AdesGuestbook v.20</title>
<meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="forText.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="javascript"><!--
function VF_addMessage(){ //v2.1
<!--start_of_saved_settings-->
<!--type,textarea,name,cmnt,required,true,isBadChars,<>&fslash;&bslash;&obrack2;&cbrack2;&obrack3;&cbrack3;&percent;&amper;&dollar;&hash;&semi;,errMsg,Please&space;enter&space;your&space;message&stop;&space;Please&space;note&space;that&space;HTML&space;tags&space;are&space;not&space;allowed&stop;-->
<!--type,text,name,website,required,false,isBadChars,<>&obrack2;&cbrack2;&obrack3;&cbrack3;&percent;&amper;&dollar;&hash;&semi;,errMsg,HTML&space;tags&space;are&space;not&space;allowed&stop;-->
<!--type,text,name,email,required,true,isEmail,errMsg,Please&space;enter&space;your&space;Email-->
<!--type,text,name,lastName,required,true,isBadChars,<>&fslash;&bslash;&obrack2;&cbrack2;&obrack3;&cbrack3;&percent;&amper;&dollar;&hash;&semi;,errMsg,Please&space;enter&space;your&space;Last&space;Name-->
<!--type,text,name,firstName,required,true,isBadChars,<>&fslash;&bslash;&obrack2;&cbrack2;&obrack3;&cbrack3;&percent;&amper;&dollar;&hash;&semi;,errMsg,Please&space;enter&space;your&space;First&space;Name&stop;&space;-->
<!--end_of_saved_settings-->
	var theForm = document.forms['addMessage'];
	var emailRE = /(@\w[-._\w]*\w\.\w{2,3})$/;
	var userRE5 = new RegExp("((<)|(>)|(/)|(\\\\)|(\\[)|(])|({)|(})|(%)|(&)|(\\$)|(#)|(;))+","g");
	var userRE3 = new RegExp("((<)|(>)|(\\[)|(])|({)|(})|(%)|(&)|(\\$)|(#)|(;))+","g");
	var userRE1 = new RegExp("((<)|(>)|(/)|(\\\\)|(\\[)|(])|({)|(})|(%)|(&)|(\\$)|(#)|(;))+","g");
	var userRE0 = new RegExp("((<)|(>)|(/)|(\\\\)|(\\[)|(])|({)|(})|(%)|(&)|(\\$)|(#)|(;))+","g");
	var errMsg = "";
	var setfocus = "";

	if ((theForm['cmnt'].value == "") || (userRE5.test(theForm['cmnt'].value))){
		errMsg = "Please enter your message\. Please note that HTML tags are not allowed\.";
		setfocus = "['cmnt']";
	}
	if (theForm['website'].value != ""){
		if (userRE3.test(theForm['website'].value)){
			errMsg = "HTML tags are not allowed\.";
			setfocus = "['website']";
		}
	}
	if (!emailRE.test(theForm['email'].value)){
		errMsg = "Please enter your Email";
		setfocus = "['email']";
	}
	if ((theForm['lastName'].value == "") || (userRE1.test(theForm['lastName'].value))){
		errMsg = "Please enter your Last Name";
		setfocus = "['lastName']";
	}
	if ((theForm['firstName'].value == "") || (userRE0.test(theForm['firstName'].value))){
		errMsg = "Please enter your First Name\. ";
		setfocus = "['firstName']";
	}
	
		if ((theForm['code'].value == "") || (userRE0.test(theForm['firstName'].value))){
		errMsg = "Please enter confirmation code!\ ";
		setfocus = "['firstName']";
	}
	
	if (errMsg != ""){
		alert(errMsg);
		eval("theForm" + setfocus + ".focus()");
	}
	else theForm.submit();
}//-->
</script>
</head>

<body>