<?php
require ("session.php");
require("dbcon.php"); 
include ("slash.php");


if(isset($_POST['keyword'])) //If submit is hit
{
	   //convert all the posts to variables:
	   $term = $_POST['keyword'];
	   if (!empty($term))
	   {
		$term=ltrim($term);
		$term=rtrim($term);
		
if (ctype_digit((string)$term)){
	
	$q="id=$term";
}
else{
$kt=split(" ",$term);//Breaking the string to an array of words
// Now let us generate the sql
while(list($key,$val)=each($kt)){
if($val<>" " and strlen($val) > 0)
{
	
	$q .= "subject like '%$val%' or details like '%$val%' or server like '%$val%' or engineer like '%$val%' or ";}

}// end of while
$q=substr($q,0,(strLen($q)-3)); // this will remove the last or from the string.
}
	   
/*
$sqlsearch="declare @searchstring varchar(200); 
			set @searchstring =REPLACE('$term', ' ','*\" OR \"*');
			set @searchstring ='\"*'+ @searchstring + '*\"';

 select * from kb_articles AR inner join containstable(kb_articles,*,@searchstring) as FT on AR.id=FT.[key]  where AR.approved='1' order by rank desc;";
*/
$sqlsearch="select * from implementation_details where $q order by createDate desc";
			 $ressearch=mssql_query($sqlsearch);
			 $numrows = mssql_num_rows ($ressearch);  
		}
 }//'FORMSOF(INFLECTIONAL,')
 
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Implementation Reports</title>
<script type="text/javascript">
function setfocus(){
    document.searchform.keyword.focus();
}
</script>
<link href="default.css" rel="stylesheet" type="text/css" />

</head>

<body onload="setfocus()" >
<?php include("header.php"); ?>

<div id="content">
	
    	<div class="post">
        <h2 class="title">Search Report</h2>
        <div class="searchform">
        <form method="post" action="search.php" name="searchform" id="csearchform">
        <input type="textbox"  size="60" class="inputstyle" name="keyword" />
        <button type="submit" formmethod="post" formaction="search.php" name="search" form="csearchform"/>search</button>
        </form>
        </div>
        <br/>
		<?php

if(($numrows!=0)and($term!="%")){
echo ("We found <b>$numrows</b> report(s) matching your query <b>\"$term\"</b>.<br/><br/>");
	while($row = mssql_fetch_array($ressearch))
    {

		echo("<h3><a href=\"view.php?article=".$row[0]."\">Report #".$row[0].": ".rmslash($row["subject"])."</a></h3><p id=\"author\">by ".$row["createBy"]);

                  if(!is_null($row["editDate"]))
				  {
						$query2 = "select convert(varchar,editDate, 103) from implementation_details where id = '".$row[0]."'";
						$result2 = mssql_query($query2);
						$row2 = mssql_fetch_array($result2);
						echo(", $row2[0]</p>");
	              }
				  else if (!is_null($row["createDate"]))
				  {
						$query2 = "select convert(varchar,createDate, 103) from implementation_details where id = '".$row[0]."'";
						$result2 = mssql_query($query2);
						$row2 = mssql_fetch_array($result2);
						echo(", added on: $row2[0]</p>");
	              }
				  echo  "<br/>";
				  $desc=rmslash($row["details"]);
					if (strlen($desc)>200)
					{   
					    $desc=nl2br(substr($desc,0,201));    
					    echo( $desc."...</p>");
					}
					else{echo $desc;}
					echo  "<br/><br/>";
    }      
}
else {
if ($_POST['keyword'])
	   {
echo ("<p>Your search - <b>\"$term\"</b> - did not match any report.  </p><p style=\"margin-top: 1em;\">Suggestions:</p><ul><li>Make sure all words are spelled correctly.</li><li>Try different keywords.</li><li>Try more general keywords.</li></ul>");
}
}

?>

		</div>
	</div>
	<br/>
<?php include("footer.php"); ?>
</body>
</html>