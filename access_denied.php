<?php
require ("session.php");		
require("dbcon.php");

	$message="You are not authorised to view this page.<br/><a href=\"index.php\">Click here</a> to return to the main page.";	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Implementation Reports</title>
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
