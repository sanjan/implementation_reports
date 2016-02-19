<?php
require ("session.php");		
require("dbcon.php"); 

if($access!=3):
	
	header("Location:access_denied.php");
	
else:		
if($_GET['delete']) //If submit is hit
{
$fileid=$_GET['delete'];



		$query1  = "select articleid,filename from kb_uploads where id=$fileid";
		$result1 = mssql_query($query1);

		if($result1)
				{
				while($row1 = mssql_fetch_row($result1))
				{
				$tmpfile=$row1[1];
				$artid=$row1[0];
				}
				//unlink($tmpfile);
				$resdel=mssql_query("delete from kb_uploads where id=$fileid");
				if($resdel){
				$message="Attachment has been deleted successfully.
				<br/>You will be redirected to the article within 5 seconds.<meta http-equiv=\"refresh\" content=\"5;url=./view.php?article=".$artid."\" />";
				}
				} 
}
if($_GET['file']) //If submit is hit
{
$fileid=$_GET['file'];
	   //convert all the posts to variables:
	 $query2  = "select articleid,filename from kb_uploads where id=$fileid";
		$result2 = mssql_query($query2);

		if($result2)
				{
				while($row2 = mssql_fetch_row($result2))
				{
				$delfile=$row2[1];
				$article=$row2[0];
				}
			$message = "Are you sure you want to delete the file \"$delfile\"?<br/><br/>
        <a class=\"button\" href=\"deletefile.php?delete=$fileid\"><span>yes</span></a>
        <a class=\"button\" href=\"view.php?article=$article\" ><span>no</span></a>"; 
	 }
	 }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Knowledge 365 - Attach a file to article</title>
<link href="default.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php include("header.php"); ?>
<div id="content">
	
    	<div class="post">
        <h2 class="title">Delete Attachment</h2>
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