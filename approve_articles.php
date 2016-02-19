<?php
require ("session.php");
include ("slash.php");

require("dbcon.php"); 

if($access!=3):
	
	header("Location:access_denied.php");
	
else:		
   //convert all the posts to variables:
 
$query  = "SELECT * FROM kb_articles where approved='0'";
$result = mssql_query($query);

$query3  = "SELECT * FROM kb_articles where approved='2'";
$result3 = mssql_query($query3);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Knowledge 365 - Articles Pending Approval</title>
<link href="default.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include("header.php"); ?>

<div id="content">
	
    	<div class="post">
	<h2 class="title">Articles pending approval</h2>
	<div class="entry">
    <table border="1" style="border-collapse:collapse" cellpadding="2" width="100%">
    <tr><td>Article Title</td><td>Author</td><td>Added On</td></tr>
    <?php
	while($row = mssql_fetch_row($result))
		{
		$title=rmslash($row[4]);
		$authorid=$row[2];
		$id=$row[0];


					if(!is_null($row[3])){

				$query2 = "select convert(varchar,updated, 103) from kb_articles where id = '".$id."'";
					$result2 = mssql_query($query2);
						$row2 = mssql_fetch_row($result2);
						$date=$row2[0];
						}
			$queusr = "select name from kb_users where userid='$authorid'";
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
  <h2 class="title">Rejected Articles</h2>
	<div class="entry">
    <table border="1" style="border-collapse:collapse" cellpadding="2" width="100%">
    <tr><td>Article Title</td><td>Author</td><td>Added On</td></tr>
    <?php
	while($row3 = mssql_fetch_row($result3))
		{
		$rtitle=rmslash($row3[4]);
		$rauthorid=$row3[2];
		$rid=$row3[0];


					if(!is_null($row3[3])){

				$query4 = "select convert(varchar,updated, 103) from kb_articles where id = '".$rid."'";
					$result4 = mssql_query($query4);
						$row4 = mssql_fetch_row($result4);
						$rdate=$row4[0];
						}
			$rqueusr = "select name from kb_users where userid='$rauthorid'";
			$rresusr = mssql_query($rqueusr);

			while($rrowusr = mssql_fetch_row($rresusr))
			{
				$rauthorname  = $rrowusr[0];
			}  
			echo ("<tr><td><a href=\"view.php?article=$rid\">$rtitle</a></td><td>$rauthorid</td><td>$rdate</td></tr>");
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