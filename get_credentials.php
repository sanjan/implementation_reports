<?php

require("dbcon.php"); 	
  include("slash.php");
  
if (isset($_POST['email'])){
	$result = mssql_query("select username,name from user_details where email ='".$_POST['email']."'");
$num = mssql_num_rows($result);
if ($num ==0){
	echo "nouser";
}
else {
	$usersname='';
	$name='';
	while($row = mssql_fetch_row($result))
		{
		$usersname=$row[0];
		$name=$row[1];
		}
		
$post_email=$_POST['email'];

sendCredentials($usersname,$name,$post_email);

 
}
}



function sendCredentials($userid,$uname,$email){
	
	$password = randomPassword();

$updateuser_query_result=mssql_query( "update user_details set password='".mssql_escape_string($password)."' where email='".mssql_escape_string($email)."'");

	if ($updateuser_query_result){
	$body = 
$body .="<table width=\"700\" border=\"0\" cellspacing=\"0\">";
$body .="<tr bordercolor=\"0\"><td height=\"73\" colspan=\"2\" bgcolor=\"#003283\"><div align=\"center\"><p><font size=\"5\" face=\"calibri\" color=\"##E6F1FA\">Implementation Report:";
$body .=" Your credentials</font></p></div></td></tr>";
$body .="<tr bordercolor=\"0\"><td colspan=\"2\" bgcolor=\"#F0AB00\">&nbsp;</td></tr>";
$body .="<tr>";
$body .="<td colspan=\"2\" bordercolor=\"0\" bgcolor=\"##E6F1FA\"><p><br><font size=\"3\" face=\"calibri\" color=\"#003283\"><b>Name:</font></b> ";
$body .= "<font size=\"3\" face=\"calibri\">$uname</font><br><br></p></td>";
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

sendEmail($body,$email);
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



function sendEmail($bodytext,$useremail){
	
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


$mail->Subject    = "Your credentials for implementation report tool";
$mail->AddAddress($useremail);

//mail->AddBCC("sanjan.grero@sap.com", "Grero, Sanjan");

if(!$mail->Send()){
	echo "error sending email";
}

}




?>
