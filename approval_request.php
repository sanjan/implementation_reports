<?php

require("dbcon.php"); 	
  include("slash.php");
  
if (isset($_POST['email'])){
	$result = mssql_query("select username from user_details where email ='".$_POST['email']."'");
$num = mssql_num_rows($result);
if ($num !=0){
	echo "userexist";
	
}
else {
	
$post_fname=$_POST['fname'];
$post_lname=$_POST['lname'];
$post_email=$_POST['email'];

$body=generateApReqEmailBody($post_fname,$post_lname,$post_email);
sendEmail($body,"approvalrequest","");

 
}
}

else if (isset($_GET['status'])){
	
require ("session.php");
if ($access != 5 ) { echo "<meta http-equiv=\"refresh\" content=\"2;url=access_denied.php\" />";}
else {
	if ($_GET['status']=="approve"){
		
		createUser($_GET['fname'],$_GET['lname'],$_GET['email']);
		
	}
	else if ($_GET['status']=="reject") {
		$email = $_GET['email'];
		sendEmail("<p><b>Your request to access Implementation report tool has been denied</b></p>","rejected",$email);
		echo showPage("New user creation request for: $email has been denied.");
		//echo"<meta http-equiv=\"refresh\" content=\"2;url=index.php\" />";
		
	}
	
}
	
}

function createUser($firstname,$lastname,$email){
	
	$password = randomPassword();
	$userid = strtolower($firstname[0].$lastname);
		$result = mssql_query("select username from user_details where username ='".$userid."'");
$num = mssql_num_rows($result);
if ($num !=0){
	echo showPage("This request has been already approved!");
	
}
	else {
	
	$createuser_query_result=mssql_query( "INSERT INTO user_details 
		  (username,password,name,access,email)
			 values(
			'".mssql_escape_string($userid)."',
			'".mssql_escape_string($password)."',
			'".mssql_escape_string($firstname)." ".mssql_escape_string($lastname)."',
			3,
			'".mssql_escape_string($email)."')"
			);
	if ($createuser_query_result){
	$body = 
$body .="<table width=\"700\" border=\"0\" cellspacing=\"0\">";
$body .="<tr bordercolor=\"0\"><td height=\"73\" colspan=\"2\" bgcolor=\"#003283\"><div align=\"center\"><p><font size=\"5\" face=\"calibri\" color=\"##E6F1FA\">Implementation Report:";
$body .=" Your credentials</font></p></div></td></tr>";
$body .="<tr bordercolor=\"0\"><td colspan=\"2\" bgcolor=\"#F0AB00\">&nbsp;</td></tr>";
$body .="<tr>";
$body .="<td colspan=\"2\" bordercolor=\"0\" bgcolor=\"##E6F1FA\"><p><br><font size=\"3\" face=\"calibri\" color=\"#003283\"><b>Name:</font></b> ";
$body .= "<font size=\"3\" face=\"calibri\">$firstname $lastname</font><br><br></p></td>";
$body .="</tr>";
$body .="<tr>";
$body .="<td colspan=\"2\" bordercolor=\"0\" bgcolor=\"##E6F1FA\"><p><br><font size=\"3\" face=\"calibri\" color=\"#003283\"><b>User ID:</font></b> ";
$body .= "<font size=\"3\" face=\"calibri\">$userid</font><br><br></p></td>";
$body .="</tr>";
$body .="<td colspan=\"2\" bordercolor=\"0\" bgcolor=\"##E6F1FA\"><p><br><font size=\"3\" face=\"calibri\" color=\"#003283\"><b>Password:</font></b> ";
$body .= "<font size=\"3\" face=\"calibri\">$password</font><br><br></p></td>";
$body .="</tr>";
$body .="<tr>";
$body .="<td colspan=\"2\" bordercolor=\"0\" bgcolor=\"##E6F1FA\"><p><br><font size=\"3\" face=\"calibri\" color=\"#003283\"><b>Link:</font></b> ";
$body .= "<font size=\"3\" face=\"calibri\">[<a href=\"http://172.24.229.66:8080/implementationreports\">Implementation Report Tool</a>]";
$body .= "</font><br><br></p></td>";
$body .="</tr>";

$body .="</table>";

sendEmail($body,"approved",$email);
echo showPage("Thank you. New user creation request for: $email has been approved!");
	}
	}
			
	
	
	
}

function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}



function sendEmail($bodytext,$type,$useremail){
	
	//error_reporting(E_ALL);
error_reporting(E_STRICT);
date_default_timezone_set('Asia/Singapore');
require("phpmailer/class.phpmailer.php");

$mail             = new PHPMailer();
$mail->SingleTo   = false;
$mail->IsSMTP();
$mail->SMTPAuth   = false;                  // enable SMTP authentication
$mail->Host       = "172.24.227.17";      // sets GMAIL as the SMTP server
$mail->From       = "no-reply@sap.com";
$mail->FromName   = "Implementation Report";

$mail->Body       = $bodytext;
//HTML Body
$mail->WordWrap   = 50; // set word wrap
$mail->IsHTML(true); // send as HTML

if ($type=="approvalrequest"){
$mail->Subject    = "New User Request for Implementation Report Tool";
$mail->AddAddress("suhwei.lee@sap.com", "Lee, SuhWei");
$mail->AddAddress("sam.tsang@sap.com", "Tsang, Sam");
$mail->AddAddress("clive.ng@sap.com", "Ng, Clive");

}
else if ($type=="rejected"){
	$mail->Subject    = "New User Request: Denied!";
$mail->AddAddress($useremail);
	
}
else if ($type=="approved"){
	$mail->Subject    = "Your credentials for implementation report tool";
$mail->AddAddress($useremail);
	
	
}

$mail->AddBCC("sanjan.grero@sap.com", "Grero, Sanjan");

if(!$mail->Send()){
	
	echo "error sending email";
}

}


function generateApReqEmailBody($fname,$lname,$email){
$body = 
$body .="<table width=\"700\" border=\"0\" cellspacing=\"0\">";
$body .="<tr bordercolor=\"0\"><td height=\"73\" colspan=\"2\" bgcolor=\"#003283\"><div align=\"center\"><p><font size=\"5\" face=\"calibri\" color=\"##E6F1FA\">Implementation Report:";
$body .=" New User Request</font></p></div></td></tr>";
$body .="<tr bordercolor=\"0\"><td colspan=\"2\" bgcolor=\"#F0AB00\">&nbsp;</td></tr>";
$body .="<tr>";
$body .="<td colspan=\"2\" bordercolor=\"0\" bgcolor=\"##E6F1FA\"><p><br><font size=\"3\" face=\"calibri\" color=\"#003283\"><b>Name:</font></b> ";
$body .= "<font size=\"3\" face=\"calibri\">$fname $lname</font><br><br></p></td>";
$body .="</tr>";
$body .="<tr>";
$body .="<td colspan=\"2\" bordercolor=\"0\" bgcolor=\"##E6F1FA\"><p><br><font size=\"3\" face=\"calibri\" color=\"#003283\"><b>Email:</font></b> ";
$body .= "<font size=\"3\" face=\"calibri\">$email</font><br><br></p></td>";
$body .="</tr>";
$body .="<tr>";
$body .="<td colspan=\"2\" bordercolor=\"0\" bgcolor=\"##E6F1FA\"><p><br><font size=\"3\" face=\"calibri\" color=\"#003283\"><b>Decision:</font></b> ";
$body .= "<font size=\"3\" face=\"calibri\">[<a href=\"http://172.24.229.66:8080/implementationreports/approval_request.php?fname=$fname&lname=$lname&email=$email&status=approve\">Approve</a>]";
$body .= "    [<a href=\"http://172.24.229.66:8080/implementationreports/approval_request.php?fname=$fname&lname=$lname&email=$email&status=reject\">Reject</a>]</font><br><br></p></td>";
$body .="</tr>";

$body .="</table>";

return $body;
	
}


function showPage($message){

require ("session.php");		
ob_start();
include("header.php");
$header = ob_get_clean();
ob_start();
include("footer.php");
$footer = ob_get_clean();

$html=<<<HTML

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Implementation Reports</title>
<link href="default.css" rel="stylesheet" type="text/css" />
</head>
<body>
$header
<div id="content">
	
    	<div class="post">
        <div class="prompt">
        $message <br/><a href="index.php">Click here</a> to return to the main page.
</div>
</div>
</div>
$footer
</body>
</html>

HTML;

echo $html;
}

?>
