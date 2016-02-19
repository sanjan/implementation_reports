<?php 
require ("session.php");
require("dbcon.php");

if($access==1):

	header("Location:access_denied.php");	
	
else:

if($_GET['article']) //If submit is hit
{
   //convert all the posts to variables:
   $articleid = $_GET['article'];
$query  = "SELECT id,title FROM kb_articles where id='$articleid'";
$result = mssql_query($query);
while($row = mssql_fetch_row($result))
		{
			$id    = $row[0];
			$title = $row[1];
		} 
 } 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Knowledge 365 - Attach a file to article "<?php echo $title; ?>"</title>
<link href="default.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php include("header.php"); ?>
<div id="content">
	
    	<div class="post">
        <h2 class="title">Attach a file to article "<?php echo ($title); ?>"</h2>
        <div class="prompt">
<form action="uploader.php" method="POST" enctype="multipart/form-data">
<input type ="hidden" value="<?php echo ($id); ?>" name="articleid" />
<label class="labelstyle" for="comments">Attach :</label><input type="file" name="file" class="inputstyle">&nbsp;
<input type="submit" value="Upload" name="func"  class="formbutton">
</form>
<p>Note: Maximum file size for an attachment is 20MB.</p>
</div>
</div>
</div>
<? include("footer.php");?>
</body>
</html>

<?
endif;
?>
