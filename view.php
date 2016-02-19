<?php
require ("session.php");
include ("slash.php");
require("dbcon.php"); 	

//declare global variables
$id='';
$title='';
$fromDateTime='';
$toDateTime='';
$engineer='';
$manager='';
$requester='';
$pcr='';
$crmticket='';
$troubleticket='';
$details='';
$servers='';
$application='';
$remarks='';
$createdby='';
$editedby='';
$createDate='';
$editDate='';


function retrieveData($reportid) {
global $id,$title,$fromDateTime,$toDateTime,$engineer,$manager,$requester,$pcr,$crmticket,$troubleticket,$details,$servers,$application,$remarks,$createdby,$editedby,$createDate,$editDate;

$query  = "SELECT id
      ,subject
      ,fromDateTime
      ,toDateTime
      ,engineer
      ,manager
      ,requester
      ,crbTicket
      ,sfTicket
      ,troubleTicket
      ,details
      ,server
      ,application
      ,remarks
      ,createBy
      ,editBy
      ,createDate
      ,editDate FROM implementation_details where id='$reportid'";
$result = mssql_query($query);

		while($row = mssql_fetch_row($result))
		{
		$id=$row[0];
		$title=rmslash($row[1]);
		if(!is_null($row[2])){
		$row2 = mssql_fetch_row(mssql_query("select  convert(varchar,fromDateTime, 120) from implementation_details where id = '".$id."'"));
		$fromDateTime=$row2[0];
		}
		if(!is_null($row[3])){
		$row3 = mssql_fetch_row(mssql_query("select  convert(varchar,toDateTime, 120) from implementation_details where id = '".$id."'"));
		$toDateTime=$row3[0];
		}
		$engineer=$row[4];
		$manager=$row[5];
		$requester=$row[6];
		$pcr=$row[7];
		$crmticket=$row[8];
		$troubleticket=$row[9];
		$details=nl2br(rmslash(strtr($row[10],Array("<"=>"&lt;",">"=>"&gt;","&"=>"&amp;"))));
		$servers=$row[11];
		$application=$row[12];
		$remarks=nl2br(rmslash(strtr($row[13],Array("<"=>"&lt;",">"=>"&gt;","&"=>"&amp;"))));
		$createdby=$row[14];
		$editedby=$row[15];
		if(!is_null($row[16])){
		$row16 = mssql_fetch_row(mssql_query("select convert(varchar,createDate, 103) from implementation_details where id = '".$id."'"));
		$createDate=$row16[0];
		}
		if(!is_null($row[17])){
		$row17 = mssql_fetch_row(mssql_query("select convert(varchar,editDate, 103) from implementation_details where id = '".$id."'"));
		$editDate=$row17[0];
		}

		}
}

if  (isset($_POST['emailreport'])) {

			$post_subject=$_POST['subject'];
			$post_reportid=$_POST['emailreport'];

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
$mail->Subject    = "Implementation Report #".$post_reportid.": ".$post_subject;
$mail->Body       = generateEmailBody($post_reportid);
//HTML Body
$mail->WordWrap   = 50; // set word wrap
$mail->IsHTML(true); // send as HTML

//$mail->AddAddress("sanjan.grero@sap.com", "Sanjan Grero");
$mail->AddAddress("DL_SYB-ITOPS_TI@exchange.sap.corp", "DL_SYB-ITOPS_TI");
$mail->AddAddress("DL_SYB-AMPRODOPSTL@exchange.sap.corp", "DL_SYB-AMPRODOPSTL");
$mail->AddAddress("DL_SYB-SERVICE_DELIVERY_365@exchange.sap.corp", "DL_SYB-SERVICE_DELIVERY_365");
$mail->AddAddress("EnterpriseServices.noc@sap.com", "SAP-Enterprise Services NOC");
$mail->AddAddress("DL_SYB-PMOPSMGMT@exchange.sap.corp", "DL SYB-PMOpsMgmt");
$mail->AddAddress("DL_SYB-PM_PRODOPS_INFRASTRUCTURE_TEAM@exchange.sap.corp", "DL_SYB-PM_PRODOPS_INFRASTRUCTURE_TEAM");
$mail->AddAddress("DL_52A9C496FD84A034D1005BEE@exchange.sap.corp","DL SYB-365_PM_Implementation_Team");
$mail->AddAddress("OperatorServices.SGNOC@exchange.sap.corp", "SAP Operator Services SG NOC");
$mail->AddAddress("OperatorServices.NOC@sap.com", "SAP-Operator Services NOC");
$mail->AddAddress("DL_52440838FD84A063DE0002A4@exchange.sap.corp", "DL SYB-SD SAM ESCENG (External)");

//$mail->AddBCC("thilakshi.de.abrew@sap.com", "Thilakshi De Abrew");

$mail->Send();


}

function generateEmailBody($reportid){
	retrieveData($reportid);
	
global $id,$title,$fromDateTime,$toDateTime,$engineer,$manager,$requester,$pcr,$crmticket,$troubleticket,$details,$servers,$application,$remarks,$createdby,$editedby,$createDate,$editDate,$user;

$body  ="<table width=\"1250\" border=\"0\" cellspacing=\"0\">";
$body .="<tr bordercolor=\"0\"><td height=\"73\" colspan=\"2\" bgcolor=\"#003283\"><div align=\"center\"><p><font size=\"5\" face=\"calibri\" color=\"##E6F1FA\">Implementation Report:";
$body .="$id</font></p></div></td></tr>";
$body .="<tr bordercolor=\"0\"><td colspan=\"2\" bgcolor=\"#F0AB00\">&nbsp;</td></tr>";
$body .="<tr>";
$body .="<td colspan=\"2\" bordercolor=\"0\" bgcolor=\"##E6F1FA\"><p><br><font size=\"3\" face=\"calibri\" color=\"#003283\"><b>Subject</font></b><br>";
$body .= "<a href=\"http://172.24.229.66:8080/implementationreports/view.php?article=$id\"><font size=\"3\" face=\"calibri\">$title</font></a><br><br></p></td>";
$body .="</tr>";
$body .="<tr>";
$body .="<td width=\"350\" bordercolor=\"0\" bgcolor=\"##E6F1FA\"><p><font size=\"3\" face=\"calibri\" color=\"#003283\"><b>From: </font></b><font size=\"3\" face=\"calibri\">$fromDateTime GMT</font><br></p></td>";
$body .="<td width=\"350\" bgcolor=\"##E6F1FA\"><p><font size=\"3\" face=\"calibri\" color=\"#003283\"><b>To: </font></b><font size=\"3\" face=\"calibri\">$toDateTime GMT</font><br></p></td>";
$body .="</tr>";
$body .="<tr>";
$body .="<td bordercolor=\"0\" bgcolor=\"##E6F1FA\"><font size=\"3\" face=\"calibri\" color=\"#003283\"><b><br>PCR Number</font></b><br><font size=\"3\" face=\"calibri\">$pcr</font><br><br></td>";
$body .="<td bgcolor=\"##E6F1FA\"><p><font size=\"3\" face=\"calibri\" color=\"#003283\"><b><br>Engineer Name</font></b><br><font size=\"3\" face=\"calibri\">$engineer</font><br><br></p></td>";
$body .="</tr>";
$body .="<tr>";
$body .="<td bordercolor=\"0\" bgcolor=\"##E6F1FA\"><p><font size=\"3\" face=\"calibri\" color=\"#003283\"><b>SAP CRM Ticket</font></b><br><font size=\"3\" face=\"calibri\">$crmticket</font><br><br></p></td>";
$body .="<td bgcolor=\"##E6F1FA\"><p><font size=\"3\" face=\"calibri\" color=\"#003283\"><b>Approving Manager</font></b><br><font size=\"3\" face=\"calibri\">$manager</font><br><br></p></td>";
$body .="</tr>";
$body .="<tr>";
if ( trim($troubleticket) != ""){
$body .="<td bordercolor=\"0\" bgcolor=\"##E6F1FA\"><p><font size=\"3\" face=\"calibri\" color=\"#003283\"><b>Trouble Ticket</b></font><br><font size=\"3\" face=\"calibri\">$troubleticket</font><br><br></p></td>";
}
else{
$body .="<td bordercolor=\"0\" bgcolor=\"##E6F1FA\"><p><font size=\"3\" face=\"calibri\" color=\"#003283\"><b></b></font><br><font size=\"3\" face=\"calibri\"></font><br><br></p></td>";	
}
$body .="<td bgcolor=\"##E6F1FA\"><p><font size=\"3\" face=\"calibri\" color=\"#003283\"><b>Requester Name</font></b><br><font size=\"3\" face=\"calibri\">$requester</font><br><br></p></td>";
$body .="</tr>";
$body .="<tr bordercolor=\"0\">";
$body .="<td colspan=\"2\">&nbsp;</td>";
$body .="</tr>";
$body .="<tr>";
$body .="<td colspan=\"2\" bordercolor=\"0\" bgcolor=\"##E6F1FA\">";
$body .="<p><font size=\"3\" face=\"calibri\" color=\"#003283\"><b><br>Implementation Procedures/Details</font></b></p>";
$body .="<p><font size=\"2\" face=\"Consolas, monaco, monospace\">$details</font><br><br></p>";
$body .="</td>";
$body .="</tr>";
$body .="<tr>";
$body .="<td height=\"40\" bordercolor=\"0\" bgcolor=\"##E6F1FA\"><p><font size=\"3\" face=\"calibri\" color=\"#003283\"><b>Server(s) Affected</font></b><br><font size=\"3\" face=\"calibri\">$servers</font><br><br></p></td>";
$body .="<td bgcolor=\"##E6F1FA\"><p><font size=\"3\" face=\"calibri\" color=\"#003283\"><b>Application Affected</font></b><br><font size=\"3\" face=\"calibri\">$application</font><br><br></p></td>";
$body .="</tr>";
$body .="<tr bordercolor=\"0\"><td height=\"18\" colspan=\"2\">&nbsp;</td></tr>";
$body .="<tr bordercolor=\"0\">";
$body .="<td height=\"18\" colspan=\"2\" bgcolor=\"##E6F1FA\"><p><font size=\"3\" face=\"calibri\" color=\"#003283\"><b><br>Remarks</font></b><br><font size=\"2\" face=\"Consolas, monaco, monospace\">$remarks</font><br><br></p></td>";
$body .="</tr>";
$body .="<tr bordercolor=\"0\">";
$body .="<td height=\"18\" colspan=\"2\" bgcolor=\"##E6F1FA\"><p><font size=\"3\" face=\"calibri\" color=\"#003283\"><b><br><b><br>Sender: </font></b><font size=\"3\" face=\"calibri\">$user<br><br>";
$body .="</tr>";
$body .="</table>";

return $body;
	
}

if($_GET['article']) //If submit is hit
{

   //convert all the posts to variables:
   retrieveData($_GET['article']);
}


			

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo "Report #".$id.": ".$title; ?></title>
<link href="default.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="jscripts/jquery.js">
    </script>
    <script type="text/javascript"
    src="jscripts/sweetalert-master/dist/sweetalert-dev.js">
    </script>
    <link type="text/css"
    href="jscripts/sweetalert-master/dist/sweetalert.css"
    rel="stylesheet" />

</head>

<body>

<?php

 include("header.php"); ?>

<div id="content">
	  	<div class="post">
	<h2 class="title"><?php echo "Report #".$id.": ".$title; ?></h2>
   <p class="author"><b>Created by:</b>  <?php echo $createdby; ?></p>
	<div class="entry">

	 <table style="margin-left:5px;" border="0" width="690px" cellpadding="5" bgcolor="#E8E8E8">
	 <tr><td><b>From: </b><?php echo $fromDateTime; ?> UTC</td>
	 <td><b>To:</b> <?php echo $toDateTime; ?> UTC</td></tr>
	 <tr><td><b>PCR: </b><?php echo $pcr; ?> </td>
	 <td><b>Engineer: </b><?php echo $engineer; ?> </td></tr>
	 <tr><td><b>CRM Ticket: </b><?php echo $crmticket; ?> </td>
	 <td><b>Approving Manager: </b><?php echo $manager; ?> </td></tr>
	 <tr><td><b>Trouble Ticket: </b><?php echo $troubleticket; ?> </td>
	 <td><b>Requested By: </b><?php echo $requester; ?> </td></tr>
	 </table>
	 <br/>
	 	 <table border="0" width="690px" >
	 <tr><td>
	 <p style="margin-left:10px;"><b>Implementation Details :</b></p>
    <?php 
    if($details!=" ");
	{
	echo ("<div style=\"margin-left:10px;overflow:hidden;word-break:break-all;width=690px;font-family: Consolas, monaco, monospace;\">");
	
	echo ($details);
	echo ("</div>");
    }
	?>
	</td></tr>
	 </table>
   <br/>
    <table style="margin-left:5px;" border="0" width="690px" cellpadding="5"  bgcolor="#E8E8E8">
	 <tr><td><b>Affected Servers: </b><?php echo $servers; ?></td><td><b>Affected Application:</b> <?php echo $application; ?></td></tr>
	</table>
	 
    <br/>
    <p style="margin-left:10px;"><b>Remarks:</b></p>
    <div style="margin-left:10px;overflow:hidden;word-break:break-all;width=690px;font-family: Consolas, monaco, monospace;"><?php echo $remarks; ?><br/><br/></div>
     
    </div>
    <div class="meta">
				<p class="byline">Posted on: <?php echo $createDate; ?></p>
		</div>
		</div>
 	<div class="meta">
					<p class="links">
				<button onClick="window.location.href = 'modify.php?article=<?php echo $id ?>';">Modify</button>
				<button id="email" >Email Report</button>
				<button onClick="window.print()">Print</button>
				  </p>
	</div>	
		
	</div>

<script>
document.getElementById("email").onclick = function(){
	
	swal({
		title: "Are you sure?",
		text: "email will be sent out to all technical operations staff!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#4FB81C',
		confirmButtonText: 'Yes, send it!',
		cancelButtonText: "No, cancel please!",
		closeOnConfirm: false,
		closeOnCancel: false
	},
	function(isConfirm){
    if (isConfirm){
       $.ajax({
      url:'view.php', //===PHP file name====
      data:"subject=<?php echo $title; ?>&emailreport=<?php echo $id; ?>",
      type:'POST',
      success:function(data){
        console.log(data);
        //Success Message == 'Title', 'Message body', Last one leave as it is
	    swal("Success!", "Email sent!", "success");
      },
      error:function(data){
        //Error Message == 'Title', 'Message body', Last one leave as it is
	    swal("Oops...", "Something went wrong :(", "error");
      }
    });
   // e.preventDefault(); //This is to Avoid Page Refresh and Fire the Event "Click"
   
    } else {
      swal("Cancelled", "Email will not be sent :)", "error");
    }
	});
	
 
	
	
	
};
</script>
	
<? include("footer.php");?>
</body>
</html>



