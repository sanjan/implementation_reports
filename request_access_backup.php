<?php

if  (isset($_POST['createprofile'])) {

			$post_fname=$_POST['first_name'];
			$post_lname=$_POST['last_name'];
			$post_email=$_POST['email'];

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
$mail->Subject    = "New User Request from: $post_fname $post_lname";
$mail->Body       = generateEmailBody($post_fname,$post_lname,$post_email);
//HTML Body
$mail->WordWrap   = 50; // set word wrap
$mail->IsHTML(true); // send as HTML

$mail->AddAddress("sanjan.grero@sap.com", "Sanjan Grero");

//$mail->AddBCC("thilakshi.de.abrew@sap.com", "Thilakshi De Abrew");

if($mail->Send()) {
 echo "<meta http-equiv=\"refresh\" content=\"0;url=login.php\" />";
}


}

function generateEmailBody($fname,$lname,$email){
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
$body .= "<font size=\"3\" face=\"calibri\">[<a href=\"http://172.24.229.66:8080/implementationreports/approve_user.php?fname=$fname&lname=$lname&email=$email&status=approve\">Approve</a>]";
$body .= "    [<a href=\"http://172.24.229.66:8080/implementationreports/approve_user.php?fname=$fname&lname=$lname&email=$email&status=reject\">Reject</a>]</font><br><br></p></td>";
$body .="</tr>";

$body .="</table>";

return $body;
	
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Implementation Reports</title>
<link href="default.css" rel="stylesheet" type="text/css" />

</head>

<body onload="setfocus()" >
<?php include("header.php"); ?>

<div id="content">
	
    	<div class="post">
        <h2 class="title">Request access</h2>
        <div class="prompt">
<form action="request_access.php" method="POST" name="profileform" id="cprofileform">
<table border="0" width="50%">
    <tr><td>First Name:</td><td> <input type="text"  size="30" class="inputstyle" name="first_name" value="" placeholder="Enter your first name" required /></td></tr>
    <tr><td>Last Name:</td><td> <input type="text"  size="30" class="inputstyle" name="last_name" value="" placeholder="Enter your last name" required /></td></tr>    
    <tr><td>Email:</td><td> <input type="email"  size="30" class="inputstyle" name="email" value="" placeholder="Enter a valid email address" required /></td></tr>
            <tr><td></td><td>
			 <button type="submit" formmethod="post" formaction="request_access.php" name="createprofile" form="cprofileform"/>Send Request</button>
			</td></tr>
            </table>

</form>
<p></p>
</div>
   
	

		</div>
	</div>
	
<?php include("footer.php"); ?>
</body>
</html>