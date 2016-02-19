<?php
require ("session.php");
require("dbcon.php"); 

if($access==1):

	header("Location:access_denied.php");	
	
else:

$query  = "SELECT DISTINCT hosttype FROM kb_hosts";
$result = mssql_query($query);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Knowledge 365 - Select the hosts related to this article</title>
<link href="default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" >
function checkAllFields(ref) {
  var chkAll = document.getElementById('checkAll');
  var checks = document.getElementsByName('hosts[]');
  var boxLength = checks.length;
  var allChecked = false;
  var totalChecked = 0;
  if ( ref == 1 ) {
    if ( chkAll.checked == true ) {
      for ( i=0; i < boxLength; i++ ) {
        checks[i].checked = true;
      }
    }
    else {
      for ( i=0; i < boxLength; i++ ) {
        checks[i].checked = false;
      }
    }
  }
  else {
    for ( i=0; i < boxLength; i++ ) {
      if ( checks[i].checked == true ) {
        allChecked = true;
        continue;
      }
      else {
        allChecked = false;
        break;
      }
    }
    if ( allChecked == true ) {
      chkAll.checked = true;
    }
    else {
      chkAll.checked = false;
    }
  }
  for ( j=0; j < boxLength; j++ ) {
    if ( checks[j].checked == true ) {
      totalChecked++;
	}
  }

}
</script>


</head>

<body>
<?php include("header.php"); ?>

<div id="content">
	
    	<div class="post">
	
	<form method="post" action="result.php" name="selecthostform">

    
    
			<p><label class="labelstyle">Select Applicable Host Types:</label><br />
            
			<?php
			//for each row we get from mssql, echo a form input
			while ($row = mssql_fetch_row($result)) {
			echo "<input name=\"hosts[]\" type=\"checkbox\" value=\"$row[0]\"/>$row[0](s)<br/>";
			}
			
			?>
			</p>
                        <p><input type="checkbox" onclick="checkAllFields(1);" id="checkAll" /> Select All Types</p>
              
            <input type="submit" name="Add" id="x" value="Add" class="formbutton"  />
            <input type="button" name="Add" id="x" value="Back" class="formbutton"onClick="location.href='add_article.php'" />
             
			</form>
                      
             
		</div>
	</div>
<? include("footer.php");?>
</body>
</html>

<?
endif;
?>