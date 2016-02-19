<?php
  {
	  require ("session.php");
	  require("dbcon.php"); 
	  include("slash.php");
	  
	  if(isset($_POST['insertreport'])) //If submit is hit
	  {

			//convert all the posts to variables:
			$post_subject=$_POST['subject'];
			$post_fromdate=$_POST['fromdate'];
			$post_todate=$_POST['todate'];
			$post_pcr=$_POST['pcr'];
			$post_engineer=$_POST['engineer'];
			$post_crmticket=$_POST['crmticket'];
			$post_manager=$_POST['manager'];
			$post_requester=$_POST['requester'];
			$post_details=$_POST['details'];
			$post_servers=$_POST['servers'];
			$post_application=$_POST['application'];
			$post_remarks=$_POST['remarks'];
			$post_user=$_POST['user'];

	                                                  
		  $resupdate=mssql_query("INSERT INTO implementation_details 
		  (subject,fromDateTime,toDateTime,engineer,manager,requester,crbTicket,sfTicket,details,server,application,remarks,createBy,createDate)
			 values(
			'".mssql_escape_string($post_subject)."',
			'$post_fromdate',
			'$post_todate',
			'$post_engineer',
			'$post_manager',
			'$post_requester',
			'$post_pcr',
			'$post_crmticket',
			'".mssql_escape_string($post_details)."',
			'$post_servers',
			'$post_application',
        	'".mssql_escape_string($post_remarks)."',
		    '$post_user',
		    CURRENT_TIMESTAMP
     		)");       
						  
						  
						  
		  if($resupdate)
		  {
		  $resultid = mssql_query("SELECT scope_identity()"); 
			  while ($rowid = mssql_fetch_row($resultid)) {
			  $repid=$rowid[0];
			  echo ("<meta http-equiv=\"refresh\" content=\"1;url=./view.php?article=$repid\" />");}
		  }
		  
  }               
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
        <h2 class="title">New Implementation Report</h2>
        <form method="post" action="new_report.php" name="modform" id="cmodform">
          <p>
            <label class="labelstyle" for="csubject">
            <b>Subject:</b></label>
            <input type="text" style="width:700px;"
            class="inputstyle" name="subject" id="csubject"
            value="" required />
            <br />
          </p>
          <table style="margin-left:0px;" border="0" width="700px"
          cellpadding="5" bgcolor="#E8E8E8">
            <tr>
              <td>
                <b>From (UTC):</b>
              </td>
              <td>
                <input type="text" class="inputstyle"
                name="fromdate"
                value="" required />
                <script type="text/javascript">$(function(){
                $('*[name=fromdate]').appendDtpicker({"closeOnSelected": true});
                });</script>
              </td>
              <td>
                <b>To (UTC):</b>
              </td>
              <td>
                <input type="text" class="inputstyle"
                name="todate" value="" required />
                <script type="text/javascript">$(function(){
                $('*[name=todate]').appendDtpicker({"closeOnSelected": true}); });</script>
              </td>
            </tr>
            <tr>
              <td>
                <b>PCR:</b>
              </td>
              <td>
                <input type="text" class="inputstyle" name="pcr"
                value="" />
              </td>
              <td>
                <b>Engineer:</b>
              </td>
              <td>
                <input type="text" class="inputstyle"
                name="engineer" value="<?php echo($user);?>" required />
              </td>
            </tr>
            <tr>
              <td>
                <b>CRM Ticket:</b>
              </td>
              <td>
                <input type="text" class="inputstyle"
                name="crmticket"
                value="" />
              </td>
              <td>
                <b>Approving Manager:</b>
              </td>
              <td>
                <input type="text" class="inputstyle"
                name="manager" value="" required />
              </td>
            </tr>
            <tr>
              <td>
                <b></b>
              </td>
              <td>
              </td>
              <td>
                <b>Requested By:</b>
              </td>
              <td>
                <input type="text" class="inputstyle"
                name="requester"
                value="" />
              </td>
            </tr>
          </table>
          <p>
            <br />
            <b>Implementation Details:</b>
          </p>
          <p>
            <textarea id="comments" class="inputstyle"
            style="width:700px;" rows="30" name="details" required></textarea>
          </p>
          <p>
            <table style="margin-left:0px;" border="0"
            width="700px" cellpadding="5" bgcolor="#E8E8E8">
              <tr>
                <td style="width:150px;">
                  <b>Affected Servers:</b>
                </td>
                <td>
                  <input type="text" class="inputstyle"
                  style="width:500px" name="servers"
                  value="" required />
                </td>
              </tr>
              <tr>
                <td style="width:150px;">
                  <b>Affected Application:</b>
                </td>
                <td>
                  <select class="inputstyle" id="category"
                  name="application">
                    <?php
					  $allapps=mssql_query("select appname from application_details");
					  //for each row we get from mssql, echo a form input
					  while($rowcat = mssql_fetch_row($allapps)) {
					  echo ("<option value=\"$rowcat[0]\">$rowcat[0]</option>\n");
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
            <textarea id="comments" class="inputstyle"
            style="width:700px;" rows="15" name="remarks"></textarea>
          </p>
		    <p>
            <input type="hidden" value="<?php echo ($user); ?>"
            name="user" />
               <button type="submit" formmethod="post" formaction="new_report.php" name="insertreport" form="cmodform"/>Save Report</button>
          </p>
		  
        </form>
      </div>
    </div><? include("footer.php");?>
    </body>
</html>

