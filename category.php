<?php
require ("session.php");
include("slash.php");
require("dbcon.php"); 

//complete deletion
if($_GET['id']) //If submit is hit
{
	   //convert all the posts to variables:
	   $catid = $_GET['id'];
	   $catname=$_GET['name'];
	   if (!empty($catid)){


$sqlsearch="select * from kb_articles where category=$catid";

	 $ressearch=mssql_query($sqlsearch);
	 $numrows = mssql_num_rows ($ressearch);  
}
 }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Knowledge 365 - Search Article</title>
<link href="default.css" rel="stylesheet" type="text/css" />
</head>

<body >
<?php include("header.php"); ?>

<div id="content">
	
    	<div class="post">
        <h2 class="title">Articles posted under <?php echo "\"$catname\""; ?></h2>
        		<?php

if($numrows!=0){

	while($row = mssql_fetch_array($ressearch))
{

echo("<h3><a href=\"view.php?article=".$row[0]."\">".$row["title"]."</a></h3><p id=\"author\">by ".$row["author"]);

if(is_null($row["updated"])){
}
else{
		$query2 = "select convert(varchar,updated, 103) from kb_articles where id = '".$row[0]."'";
			$result2 = mssql_query($query2);
				$row2 = mssql_fetch_array($result2);
				echo(", $row2[0]</p>");
			}
$desc=$row["description"];
  if (strlen($desc)>119){   
  $desc=substr($desc,0,120);    
echo( $desc."...");
}
else{echo $desc;}
}      
}
?>

		</div>
	</div>
<? include("footer.php");?>
</body>
</html>