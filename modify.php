<?php
  {
	  require ("session.php");
	  require("dbcon.php"); 
	  include("slash.php");
	  
	  if(isset($_POST['updatearticle'])) //If submit is hit
	  {

			//convert all the posts to variables:
			$post_subject=$_POST['subject'];
			$post_fromdate=$_POST['fromdate'];
			$post_todate=$_POST['todate'];
			$post_pcr=$_POST['pcr'];
			$post_engineer=$_POST['engineer'];
			$post_crmticket=$_POST['crmticket'];
			$post_manager=$_POST['manager'];
			$post_troubleticket=$_POST['troubleticket'];
			$post_requester=$_POST['requester'];
			$post_details=$_POST['details'];
			$post_servers=$_POST['servers'];
			$post_application=$_POST['application'];
			$post_remarks=$_POST['remarks'];
			$post_user=$_POST['user'];
			$post_reportid=$_POST['reportid'];

	                                                  
		  $resupdate=mssql_query("UPDATE implementation_details SET 
		  subject='".mssql_escape_string($post_subject)."',
		  fromDateTime='$post_fromdate',
		  toDateTime='$post_todate',
		  engineer='$post_engineer',
		  manager='$post_manager',
		  requester='$post_requester',
		  crbTicket='$post_pcr',
		  sfTicket='$post_crmticket',
		  troubleTicket='$post_troubleticket',
		  details='".mssql_escape_string($post_details)."',
		  server='$post_servers',
		  application='$post_application',
		  remarks='".mssql_escape_string($post_remarks)."',
		  editBy='$post_user',
		  editDate=CURRENT_TIMESTAMP
		  WHERE id=$post_reportid");       
						  
						  
						  
		  if($resupdate)
		  {
		  $resultid = mssql_query("SELECT id from implementation_details where id='$post_reportid'"); 
			  while ($rowid = mssql_fetch_row($resultid)) {
			  $repid=$rowid[0];
			  echo ("<meta http-equiv=\"refresh\" content=\"1;url=./view.php?article=$repid\" />");}
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
	        ,editDate 
			FROM implementation_details where id='$reportid'";
	  
	  
	  
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
	                  $details=rmslash(trim($row[10]));
	                  $servers=$row[11];
	                  $application=$row[12];
					  $remarks=rmslash(trim($row[13]));
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
	  
 
  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type"
    content="text/html; charset=utf-8" />
    <title>Implementation Reports</title>
    <link href="default.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="jscripts/jquery.js">
    </script>
    <script type="text/javascript"
    src="jscripts/jquery-simple-datetimepicker-1.12.0/jquery.simple-dtpicker.js">
    </script>
    <link type="text/css"
    href="jscripts/jquery-simple-datetimepicker-1.12.0/jquery.simple-dtpicker.css"
    rel="stylesheet" />
    <script type="text/javascript"    src="jscripts/jquery.validate.js">
    </script>
	<script type="text/javascript">
	$(document).ready(function(){
   $("#cmodform").validate({
      rules: {
         csubject: {
            required: true
               }
         },
         messages: {
            csubject: "Required Field"
         }
		 
		         submitHandler: function(form) {
            form.submit();
        }
     });
});
	</script>

  </head>
  <body onload="setfocus()">
    <?php include("header.php"); ?>
    <div id="content">
      <div class="post">
        <h2 class="title">Modify Report: #<?php echo $id; ?></h2>
        <form method="post" action="modify.php" name="modform" id="cmodform">
          <p>
            <label class="labelstyle" for="csubject">
            <b>Subject:</b></label>
            <input type="text" style="width:700px;"
             name="subject" id="csubject"
            value="<?php echo($title);?>" required />
            <br />
          </p>
          <table style="margin-left:0px;" border="0" width="700px"
          cellpadding="5" bgcolor="#E8E8E8">
            <tr>
              <td>
                <b>From (UTC):</b>
              </td>
              <td>
                <input type="text" 
                name="fromdate"
                value="<?php echo($fromDateTime);?>" />
                <script type="text/javascript">$(function(){
                $('*[name=fromdate]').appendDtpicker({"closeOnSelected": true});
                });</script>
              </td>
              <td>
                <b>To (UTC):</b>
              </td>
              <td>
                <input type="text" 
                name="todate" value="<?php echo($toDateTime);?>" />
                <script type="text/javascript">$(function(){
                $('*[name=todate]').appendDtpicker({"closeOnSelected": true}); });</script>
              </td>
            </tr>
            <tr>
              <td>
                <b>PCR:</b>
              </td>
              <td>
                <input type="text"  name="pcr"
                value="<?php echo($pcr);?>" />
              </td>
              <td>
                <b>Engineer:</b>
              </td>
              <td>
                <input type="text" 
                name="engineer" value="<?php echo($engineer);?>" required />
              </td>
            </tr>
            <tr>
              <td>
                <b>CRM Ticket:</b>
              </td>
              <td>
                <input type="text" 
                name="crmticket"
                value="<?php echo($crmticket);?>" />
              </td>
              <td>
                <b>Approving Manager:</b>
              </td>
              <td>
                <input type="text" 
                name="manager" value="<?php echo($manager);?>" required />
              </td>
            </tr>
            <tr>
              <td>
                <b>Trouble Ticket:</b>
              </td>
              <td>
                <input type="text" 
                name="troubleticket"
                value="<?php echo($troubleticket);?>" />
              </td>
              <td>
                <b>Requested By:</b>
              </td>
              <td>
                <input type="text" 
                name="requester"
                value="<?php echo($requester);?>" />
              </td>
            </tr>
          </table>
          <p>
            <br />
            <b>Implementation Details:</b>
          </p>
          <p>
            <textarea id="comments" 
            style="width:700px;" rows="30" name="details" required><?php echo($details);?></textarea>
          </p>
          <p>
            <table style="margin-left:0px;" border="0"
            width="700px" cellpadding="5" bgcolor="#E8E8E8">
              <tr>
                <td style="width:150px;">
                  <b>Affected Servers:</b>
                </td>
                <td>
                  <input type="text" 
                  style="width:500px" name="servers"
                  value="<?php echo($servers);?>" />
                </td>
              </tr>
              <tr>
                <td style="width:150px;">
                  <b>Affected Application:</b>
                </td>
                <td>
                  <select  id="category"
                  name="application">
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
                </td>
              </tr>
            </table>
          </p>
          <p>
            <label class="labelstyle" for="comments">
            Remarks:</label>
            <br />
            <br />
            <textarea id="comments" 
            style="width:700px;" rows="15" name="remarks"><?php echo($remarks);?></textarea>
          </p>
          <p>
            <input type="hidden" value="<?php echo ($user); ?>"
            name="user" />
            <input type="hidden" value="<?php echo($reportid);?>"
            name="reportid" />
              <button type="submit" formmethod="post" formaction="modify.php" name="updatearticle" form="cmodform"/>Save Report</button>
          </p>
        </form>
      </div>
    </div><? include("footer.php");?>
    </body>
</html>
	  <?php } ?>
