<?php
require ("session.php");

if($access==1):
 header("Location:access_denied.php");	
	 
else:

 if($_POST['func']) //If submit is hit

{
 $artid=$_POST['articleid'];
 
 $message="";
 $message2="";
 // check if a file has been submitted
  if(isset($_FILES['file']['tmp_name']))
  {
 //for($i=1;$i<6;$i++)
 //{$message=$message.$_FILES['file']['tmp_name'][$i]." = ".$_FILES['file']['name'][$i];}
	     // loop through the array
	  for($i=0; $i < count($_FILES['file']['name']);$i++)
	  {
	  				
			  if ($_FILES["file"]['error'][$i] > 0)
				{
				if ($_FILES['file']['error'][$i]==4)
				{ 
				$message=$message."There was no file to upload at position (".($i+1).")<br/>";
				}
				else{
				$message=$message."Sorry! File upload at position (".($i+1).") terminated with error: " . $_FILES["file"]['error'][$i] . "<br/>";}
				}
			
				else
				{
			
				  if (file_exists("uploads/".$artid."_" . $_FILES["file"]['name'][$i])) // check whether file exists
				  {
				  $message =$message."File ".$artid."_".$_FILES["file"]['name'][$i] . " already exists.<br/> ";
				  }
				  else
				  {
			
				 	 move_uploaded_file($_FILES["file"]['tmp_name'][$i], // move the files from temporary folder to the main folder
				  	"uploads/".$artid."_" . $_FILES["file"]['name'][$i]);
			
				 	 $file="uploads/".$artid."_" . $_FILES["file"]['name'][$i];
			
					require("dbcon.php"); 
			
					$query  = "INSERT INTO kb_uploads(articleid,filename) VALUES ('$artid','$file')";
					$result = mssql_query($query);
				   if($result)
						{
							$message=$message."File (".($i+1).") successfully uploaded and saved into the database.<br/>";
						} 
				   }
				}
		}//end of for loop 	
	
  }// end of isset
else{
$message=$message."You did not select any file to upload.<br/><a href=\"multipleFile.php?article=".$artid."\">Click here</a> to return.";
 }

}
else{
 $message2="There was a fatal error. Probably your file was way too large.<br/><a href=\"javascript:history.go(-2)\">Click here</a> to return.<br/>";	
}

//}//big else		 					
 
 
 
 				 
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
        <?php 
		if ($message2 != ""){
		echo $message2;
		}
		else{
		echo $message."<br/><a href=\"view.php?article=".$artid."\">Click here</a> to return.<br/>";}
		?>
</div>
</div>
</div>
<? include("footer.php");?>
</body>
</html>

<?
endif;
?>




		
	
		

