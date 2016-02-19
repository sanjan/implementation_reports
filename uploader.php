<?php
require ("session.php");

if($access==1):

	 header("Location:access_denied.php");	
	 
else:

if($_POST['func']) //If submit is hit
{
 $artid=$_POST['articleid'];
if($_FILES["file"]["name"]!=""){ // check the file name
if ($_FILES["file"]["size"] < 2000000) // check the file size
  {
  if ($_FILES["file"]["error"] > 0)
    {
    $message= "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {

      if (file_exists("uploads/".$artid."_" . $_FILES["file"]["name"])) // check whether file exists
      {
      $message = "File ".$artid."_".$_FILES["file"]["name"] . " already exists. ";
      }
    else
      {

      move_uploaded_file($_FILES["file"]["tmp_name"], // move the files from temporary folder to the main folder
      "uploads/".$artid."_" . $_FILES["file"]["name"]);

      $file="uploads/".$artid."_" . $_FILES["file"]["name"];

		require("dbcon.php"); 

		$query  = "INSERT INTO kb_uploads(articleid,filename) VALUES ('$artid','$file')";
		$result = mssql_query($query);
		if($result)
				{
				$message="File successfully uploaded and saved into the database.
				<br/>You will be redirected to the homepage within 5 seconds.<meta http-equiv=\"refresh\" content=\"5;url=./index.php\" />";
				} 

      }
    }
  }
else
  {
$message="Sorry. The file size is too big.Please select a file less than 20MB of size.<br/><a href=\"attachfile.php?article=".$artid."\">Click here</a> to return.";
  }
 }
 else{
 $message="You did not select any file to upload.<br/><a href=\"attachfile.php?article=".$artid."\">Click here</a> to return.";
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
        <h2 class="title">File Uploader</h2>
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