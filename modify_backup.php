<?php
require ("session.php");
require("dbcon.php"); 
include("slash.php");

if($access==1):
	header("Location:access_denied.php");	
	
else:

$alerter="";

if($_POST['updarticles']) //If submit is hit
{
   //convert all the posts to variables:
  // $alertname = $_POST['aname'];
   $alertdesc = $_POST['adesc'];
   $alertcat = $_POST['acat'];
   $alertsample = $_POST['asample'];
   $alertsolution = $_POST['solution'];
   $author=$_POST['user'];
   $artid=$_POST['artid'];
   
   
	
				//hosts
				//empty host relations for that id
				$hostempty = "delete from kb_rel1 where articleid='$artid'";
				$reshempty=mssql_query($hostempty);
				if($_POST['hosts']){
				foreach($_POST['hosts'] as $value) 
				{  
				
				 $sql = sprintf("select id from kb_hosts where hosttype='%s'",$value);  
	   
	  			$rsLimited=mssql_query($sql);
				while($rowh=mssql_fetch_assoc($rsLimited)) 
				{ 
				$hostarray[]=$rowh["id"]; 
				} 
		
				 }
				  foreach($hostarray as $hostvalue){
				  // echo intval($hostvalue);
				   $sql = "INSERT INTO kb_rel1(articleid,hostid) VALUES('".intval($artid)."','".intval($hostvalue)."')";  
				   $reshstupd=mssql_query($sql);
				 
				 }
							// }
							 //end hosts
	
						
					$resupdate=mssql_query("UPDATE kb_articles SET approved=0,last_modified='$author',updated=CURRENT_TIMESTAMP,description='".mssql_escape_string($alertdesc)."',category='$alertcat',sample='".mssql_escape_string($alertsample)."',solution='".mssql_escape_string($alertsolution)."' WHERE id='$artid'");	
						
						
						
					if($resupdate)
					{
					$resultid = mssql_query("SELECT id from kb_articles where id='$artid'"); 
							while ($rowid = mssql_fetch_row($resultid)) {
							$artid=$rowid[0];
							echo ("<meta http-equiv=\"refresh\" content=\"1;url=./view.php?article=$artid\" />");}
					}
					}		
     }
		
		
if($_GET['article']) //If submit is hit
{
	   //convert all the posts to variables:
	   $reportid = $_GET['article'];
$reportid=ltrim($reportid);
$reportid=rtrim($reportid);

$sqlmod= "SELECT id
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



	 $resmod=mssql_query($sqlmod);
	 $numrows = mssql_num_rows ($resmod);  
if($numrows!=0){

		while($row = mssql_fetch_row($resmod))
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
		$details=nl2br(strtr($row[10],Array("<"=>"&lt;",">"=>"&gt;","&"=>"&amp;")));
		$servers=$row[11];
		$application=$row[12];
		$remarks=nl2br(strtr($row[13],Array("<"=>"&lt;",">"=>"&gt;","&"=>"&amp;")));
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
		
	
		
		$sqlcat="select appname from application_details";
		$allapps=mssql_query($sqlcat);
		
}
 }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Implementation Reports - Modify Report</title>
<link href="default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jscripts/jquery.js"></script>
<script type="text/javascript" src="jscripts/jquery-simple-datetimepicker-1.12.0/jquery.simple-dtpicker.js"></script>
<link type="text/css" href="jscripts/jquery-simple-datetimepicker-1.12.0/jquery.simple-dtpicker.css" rel="stylesheet" />
<!-- TinyMCE -->
<script type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
	// General options
	mode : "textareas",
	theme : "advanced",
	plugins : "table",

	// Theme options
	theme_advanced_buttons2 : "",
	theme_advanced_buttons1 : "bold,italic,underline,|,cut,copy,paste,|,bullist,numlist,|,undo,redo,|,link,unlink,|,tablecontrols",
	theme_advanced_buttons3 : "",
	theme_advanced_buttons4 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : false
	
});



</script>
<!-- /TinyMCE -->
</head>

<body onload="setfocus()" >
<?php include("header.php"); ?>
<div id="content">
	
    	<div class="post">
        <h2 class="title">Modify Report</h2>

			<form method="post" action="modify.php" name="modform">
					<p>
					 <b>Subject:</b><input type="textbox"  style="width:700px;" class="inputstyle" name="subject" value="<?php echo($title);?>" />
<br/>
<?php 
if (!empty($alerter)){
echo("<script language=\"Javascript\">alert (\"$alerter\")</script>"); }?>
</p>

	 <table style="margin-left:0px;" border="0" width="700px" cellpadding="5"  bgcolor="#E8E8E8" >
	 <tr><td><b>From (UTC): </b></td><td><input type="textbox"  class="inputstyle" name="fromdate" value="<?php echo($fromDateTime);?>" />
	 <script type="text/javascript">
		$(function(){
			$('*[name=fromdate]').appendDtpicker();
		});
	</script></td>
	 <td><b>To (UTC):</b></td><td><input type="textbox"  class="inputstyle" name="todate" value="<?php echo($toDateTime);?>" /><script type="text/javascript">
		$(function(){
			$('*[name=todate]').appendDtpicker();
		});
	</script></td></tr>
	 <tr><td><b>PCR: </b></td><td><input type="textbox"  class="inputstyle" name="pcr" value="<?php echo($pcr);?>" /></td>
	 <td><b>Engineer: </b></td><td><input type="textbox"  class="inputstyle" name="engineer" value="<?php echo($engineer);?>" /></td></tr>
	 <tr><td><b>CRM Ticket: </b></td><td><input type="textbox"  class="inputstyle" name="crmticket" value="<?php echo($crmticket);?>" />
	 </td><td><b>Approving Manager: </b></td><td><input type="textbox"  class="inputstyle" name="manager" value="<?php echo($manager);?>" /></td></tr>
	 <tr><td><b>Trouble Ticket: </b></td><td><input type="textbox"  class="inputstyle" name="troubleticket" value="<?php echo($troubleticket);?>" /></td>
	 <td><b>Requested By: </b></td><td><input type="textbox"  class="inputstyle" name="requester" value="<?php echo($requester);?>" /></td></tr>
	 </table>
	
<p><br/><b>Implementation Details:</b></p>
<p><textarea id="comments" class="inputstyle" style="width:700px;" rows="30" name="details"><?php echo($details);?></textarea></p>

<p>

    <table style="margin-left:0px;" border="0" width="700px" cellpadding="5" bgcolor="#E8E8E8" >
	 <tr><td style="width:150px;"><b>Affected Servers: </b></td><td><input type="textbox"  class="inputstyle" style="width:500px" name="servers" value="<?php echo($servers);?>" /></td>
	</tr><tr> <td style="width:150px;"><b>Affected Application:</b></td>
	 <td>

<select class="inputstyle"id="category" name="application">
<?php

			//for each row we get from mssql, echo a form input
			while($rowcat = mssql_fetch_row($allapps)) {
			if($rowcat[0]==$application){
			echo ("<option value=\"$rowcat[0]\" SELECTED>$rowcat[0]</option>\n");
			}
			else
			{
			echo ("<option value=\"$rowcat[0]\">$rowcat[0]</option>\n");
			}
			
			}
			
?>
</select>
</td></tr>
	</table>

</p>

<p><label class="labelstyle" for="comments">Remarks:</label><br /><br />
<textarea id="comments" class="inputstyle" style="width:700px;" rows="25" name="remarks"><?php echo($remarks);?></textarea></p>

<p>

<p><br/>
<input type="submit" name="updarticle" id="x" value="Save Report" class="formbutton" /></p>

<input type ="hidden" value="<?php echo ($user); ?>" name="user" />
<input type ="hidden" value="<?php echo($reportid);?>" name="artid" />
					
				</form>

		</div>
	</div>
<? include("footer.php");?>
</body>
</html>

<?
endif;
?>