<?php 
require ("session.php");

if($access==1):

	header("Location:access_denied.php");	
	
else:

if($_GET['article']) //If submit is hit
{
require("dbcon.php"); 
   //convert all the posts to variables:
   $articleid = $_GET['article'];
   $title = $_GET['title'];
$query  = "SELECT id,title FROM kb_articles where id='$articleid'";
$result = mssql_query($query);
while($row = mssql_fetch_row($result))
		{
			$id    = $row[0];
			$title = $row[1];
		} 
 } 

  
  // specify a few variables.. 
  $numOfUploads = 5;         // number of files to upload
// $maxFileSize  = 20000000;    // maximum file size in bytes 
  
  ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Knowledge 365 - Attach files to article "<?php echo $title; ?>"</title>
<link href="default.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php include("header.php"); ?>
<div id="content">

    	<div class="post">
        <h2 class="title">Attach files to article "<?php echo ($title); ?>"</h2>
        <div class="prompt">
        Attach:
<form action = "upload.php" method="post" enctype="multipart/form-data">
  <input type="hidden" name="MAX_FILE_SIZE" value="5242880">
  <input type ="hidden" value="<?php echo ($id); ?>" name="articleid" />
  <?php
  $num = 0;
  while($num < $numOfUploads)
    {
        echo '<div><input name="file[]" type="file"></div>';
        $num++;
        }
  ?>

  <input type="submit" value="Upload" name="func" class="formbutton">

  </form>
<p>Note: Maximum file size for an attachment is 5MB.</p>
</div>
</div>
</div>
<? include("footer.php");?>
</body>
</html>

<?
endif;
?>

