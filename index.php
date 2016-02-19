<?php
include("slash.php");
require ("session.php");
require("dbcon.php"); 
   //convert all the gets to variables:
   $alertname = $_GET['article'];
$query  = "SELECT * FROM (SELECT row_number() OVER (ORDER BY createdate desc) AS rownum,createby,createdate,id,subject,details FROM [implementation_details] ) AS A WHERE A.rownum BETWEEN (0+1) AND (0 + 9)";
$result = mssql_query($query);
$numrows = mssql_num_rows ($result);  
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
		<div id="welcome">
		<h2>Welcome <?php $separated=explode(" ",$user); echo " ".$separated[0];?>!</h2>

		<p><img src="images/img03.jpg" alt="" width="300" height="100" /></p>
		<p>This is a tool to store/view production changes done at the SAP SMS 365 Enterprise Services Hub with detailed steps on how it was done.<br /></p>


	</div>

	<div id="news">
		<h2 class="title">Recent Reports</h2>
	<?php


	while($row = mssql_fetch_array($result))
{

echo("<h3><a href=\"view.php?article=".$row["id"]."\">".rmslash($row["subject"])."</a></h3><p id=\"author\">by ".$row["createby"]);

if(is_null($row["createdate"])){
}
else{
		$queryx="select convert(varchar,createdate, 103) from implementation_details where id = '".$row["id"]."'";
			$result2 = mssql_query($queryx);
				$row2 = mssql_fetch_array($result2);
				echo(", $row2[0]</p><br/>");
			}
 /* $desc=rmslash($row["description"]);
  if (strlen($desc)>119){   
  $desc=substr($desc,0,120);    
echo( $desc."...</p>");
}
else{echo $desc;}*/
      
    } 
  


?>

        
	</div>

		
		
	</div>
   
<?php include("footer.php"); ?>

</body>
</html>