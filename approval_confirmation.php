<?php
require ("session.php");
require("dbcon.php"); 
require("phpmailer/class.phpmailer.php");
error_reporting(E_STRICT);
if($access!=3){
	header("Location:access_denied.php");
	}
else{		
if($_GET['article']) //If submit is hit
{
$articleid=$_GET['article'];



		$query1  = "select id,title,author from kb_articles where id=$articleid";
		$result1 = mssql_query($query1);

		if($result1)
				{
				while($row1 = mssql_fetch_row($result1))
				{
				$articletitle=$row1[1];
				$authorid=$row1[2];
				}
				$message = "Please confirm the aprroval status for article \"$articletitle\" by $authorid: <br/><br/>
        <a class=\"button\" href=\"approval_confirmation.php?approved=$articleid\"><span>Approved</span></a>
        <a class=\"button\" href=\"approval_confirmation.php?rejected=$articleid\" ><span>Rejected</span></a>";
				
				
				} 
}
elseif($_GET['approved']) 
{
$apartid=$_GET['approved'];

	 $query2  = "update kb_articles set approved='1' where id=$apartid";
		$result2 = mssql_query($query2);

		if($result2)
				{
				$articletitle2 = mssql_fetch_row(mssql_query("select title from kb_articles where id=$apartid"));
				$message = sendEmail($articletitle2[0])."<meta http-equiv=\"refresh\" content=\"2;url=./view.php?article=$apartid\" />"; // send email to noc members
							
				}
			
	 
}

elseif($_GET['rejected']) //If submit is hit
{
$apartid=$_GET['rejected'];
	   //convert all the posts to variables:
	 $query2  = "update kb_articles set approved='2' where id=$apartid";
		$result2 = mssql_query($query2);

		if($result2)
				{
				$message ="<p>Article rejected.</p> <meta http-equiv=\"refresh\" content=\"2;url=./view.php?article=$apartid\" />";
				}
			
	 
}
}
// send email to noc members
function sendEmail($arttitle){


date_default_timezone_set('Asia/Singapore');

$mail             = new PHPMailer();
$mail->SingleTo   = false;
$mail->IsSMTP();
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->Host       = "ssl://smtp.gmail.com:465";      // sets GMAIL as the SMTP server
$mail->Username   = "sybase365nockb@gmail.com";  // GMAIL username
$mail->Password   = "sg_noc123";            // GMAIL password
$mail->From       = "am_noc@sybase.com";
$mail->FromName   = "AM NOC Knowledge Base";
$mail->Subject    = "New article on AM NOC Knowledge Base";
$mail->Body       = "<p>A new article - \"$arttitle\" <br/> has been posted to the AM NOC knowledge base.</p><p>Click on the link to check it out: <a href=\"http://10.34.61.117/nkb/index.php\">http://10.34.61.117/nkb/index.php</a></p><p>- AM NOC Knowledge Base</p>";
//HTML Body
$mail->WordWrap   = 50; // set word wrap
$mail->IsHTML(true); // send as HTML
$emailQueryString="select email from kb_users where dept='noc'";
$emailQuery=mssql_query($emailQueryString);


$arr=array();
    while ($emailAddress = mssql_fetch_array($emailQuery,MSSQL_NUM))
    {

	 $arr[]=$emailAddress[0];
 
    }
	
foreach ($arr as $value) {
 $mail->AddAddress($value);
}	

$resulttext="";
if(!$mail->Send()) {
  echo "". $mail->ErrorInfo;
} else {
 $resulttext = "<p>Article approved.</p>";
}
//mssql_free_result($result);
//    mssql_close($link); 
return $resulttext;
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Knowledge 365 - Approve article confirmation</title>
<link href="default.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php include("header.php"); ?>
<div id="content">
	
    	<div class="post">
        <h2 class="title">Approve article</h2>
        <div class="prompt">
        <?php echo $message; ?>
</div>
</div>
</div>
<? include("footer.php");?>
</body>
</html>

