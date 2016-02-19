<?php
require ("session.php");		
require("dbcon.php"); 

if($access!=3):
	
	header("Location:access_denied.php");
	
else:
//complete deletion
if($_GET['article']) //If submit is hit
{
	   //convert all the posts to variables:
	   $delid = $_GET['article'];
	$sqldel = "select title from kb_articles where id='$delid'";
	 $resdel=mssql_query($sqldel);
	 	while($rowdel = mssql_fetch_row($resdel))
			{
				$delart  = $rowdel[0];
			} 
			$message = "Are you sure you want to delete the article \"$delart\"?<br/><br/>
        <a class=\"button\" href=\"delete.php?delete=$delid\"><span>yes</span></a>
        <a class=\"button\" href=\"view.php?article=$delid\"><span>no</span></a>
        "; 
	 }
if($_GET['delete']) //If deletion confirmed
{
	   //convert all the posts to variables:
	   $confid = $_GET['delete'];
	$sqlconf1 = "delete from kb_articles where id='$confid'";
	 $artdelconf1=mssql_query($sqlconf1);
	 	$sqlconf2 = "delete from kb_rel1 where articleid='$confid'";
	 $reldelconf2=mssql_query($sqlconf2);
	 $sqlconf3="delete from kb_uploads where articleid='$confid'";
	 $upddelconf3=mssql_query($sqlconf3);
	 $message="Article deleted successfully! <br/>You will be redirected to home page within 5 seconds.<meta http-equiv=\"refresh\" content=\"5;url=./index.php\" />";
	 }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Knowledge 365 - Delete Article</title>
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
<? include("footer.php");?>
</body>
</html>

<?
endif;
?>
