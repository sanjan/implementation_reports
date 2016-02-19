<?php
require ("session.php");
include ("slash.php");

require("dbcon.php"); 

if($access!=3):
	
	header("Location:access_denied.php");
	
else:		
   //convert all the posts to variables:
 
$query  = "SELECT * FROM implementation_details order by createdate desc";
$result = mssql_query($query);
$numofart=mssql_num_rows($result);


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
	<h2 class="title">List of All Implementation Reports</h2>
	<div class="entry">
    <?php 
    echo ("<h4>Currently there are $numofart report(s). </h4>");
	?>
    <table border="1" style="border-collapse:collapse" cellpadding="2"  width="100%">
    <tr><td>Title</td><td>Author</td><td>Added On</td></tr>
    <?php
	while($row = mssql_fetch_row($result))
		{
		$title=rmslash($row[1]);
		$authorid=$row[14];
		$id=$row[0];
$statstr="";
					if(!is_null($row[3])){

				$query2 = "select convert(varchar,createdate, 103) from implementation_details where id = '".$id."'";
					$result2 = mssql_query($query2);
						$row2 = mssql_fetch_row($result2);
						$date=$row2[0];
						}
			$queusr = "select createby from implementation_details where id='$id'";
			$resusr = mssql_query($queusr);

			while($rowusr = mssql_fetch_row($resusr))
			{
				$authorname  = $rowusr[0];
			}  

			
			echo ("<tr><td><a href=\"view.php?article=$id\">$title</a></td><td>$authorid</td><td>$date</td></tr>");
			
			}
	
	?>
</table>

 
   
    
    

    
    
    

    
    </div>
 
  

		</div>
	</div>
<? include("footer.php");?>
</body>
</html>

<?
endif;
?>