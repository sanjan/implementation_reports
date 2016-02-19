<?php

require ("session.php");
require("dbcon.php"); 
include("slash.php");

if($access==1):

	header("Location:access_denied.php");	
	
else:

$hostarray = array();
//mail and adding relations
if($_POST['Add']) //If submit is hit
{
	
	// inserting article into kb_articles							
		$resinsert=mssql_query("INSERT INTO kb_articles (category,author,updated,title,description,sample,solution,approved,last_modified) 
							   VALUES ('". $_SESSION['post']['alertcat'] ."', '". $_SESSION['post']['author'] . "', CURRENT_TIMESTAMP, '".mssql_escape_string($_SESSION['post']['alertname']) ."', '".mssql_escape_string($_SESSION['post']['alertdesc'])."', '".mssql_escape_string($_SESSION['post']['alertsample'])."', '".mssql_escape_string($_SESSION['post']['alertsolution'])."','0', '". $_SESSION['post']['author'] . "')");
		
						
	   // querying for the article's id
	    $query=mssql_query("SELECT id FROM kb_articles WHERE title='". $_SESSION['post']['alertname'] . "'");
		while($row=mssql_fetch_array($query))
		{
			$articleid = $row['id'];
		}
		


		foreach($_POST['hosts'] as $value) {  
	
	   $sql = sprintf("select id from kb_hosts where hosttype='%s'",$value);  
	   
	   //$sql = sprintf("INSERT INTO kb_rel1(articleid,hostid) VALUES('%s','%s')", $articleid,$value);  
	   // $resfin=mssql_query($sql);
		$rsLimited=mssql_query($sql);
		while($row=mssql_fetch_assoc($rsLimited)) 
		{ 
		$hostarray[]=$row["id"]; 
		} 
		

	 }
	 foreach($hostarray as $hostvalue){
	  // echo intval($hostvalue);
	   $sql = "INSERT INTO kb_rel1(articleid,hostid) VALUES('".intval($articleid)."','".intval($hostvalue)."')";  
	   $resfin=mssql_query($sql);
	 
	 }
	 if ($resfin)
	 {
	 	unset($_SESSION['post']);
	 $message="<meta http-equiv=\"refresh\" content=\"0;url=approval_request.php?artid=$articleid\" />";
	 /*$message= "Thanks for your contribution! Article has been saved successfully.<br/> Your article is subject to approval from the Administrator.<br/>
		If you would like to attach any supporting document for this article, <a href=\"multipleFile.php?article=$articleid\">Click here</a>.
		<br/>Else, <a href=\"index.php\">click here</a> to return to the Home Page.<meta http-equiv=\"refresh\" content=\"20;url=index.php\" />";*/

	 }
	 
}

//complete addition
if($_GET['success'])
{
$status=$_GET['success'];
$artiid=$_GET['aid'];
if ($status=='true')
{
$message= "Thanks for your contribution! Article has been saved successfully.<br/> Your article is subject to approval from the Administrator.<br/>
		If you would like to attach any supporting document for this article, <a href=\"multipleFile.php?article=$artiid\">Click here</a>.
		<br/>Else, <a href=\"index.php\">click here</a> to return to the Home Page.<meta http-equiv=\"refresh\" content=\"20;url=index.php\" />";
}

}  

 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Knowledge 365</title>
<link href="default.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include("header.php"); ?>
<div id="content">
	
    	<div class="post">
        <div class="prompt">
			<?php echo $message; ?>
            </div>
		</div>
	</div>
<?php include("footer.php"); ?>
</body>
</html>

<?
endif;
?>