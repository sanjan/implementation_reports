<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php

$servername="localhost\sqlexpress,4272";
$username="sanjan";
$password="sanjan";
$connection = mssql_connect($servername,$username, $password)or die("Couldn't connect to SQL Server on $servername");
mssql_select_db("Sybase365", $connection)or die("Couldn't open database");
$sql = "select name from kb_users where userid='sanjan';";



$result= mssql_query($sql);

while($row = mssql_fetch_array($result))
{
  echo "<li>"  . $row["name"] . "</li>";
}
	mssql_close ($connection);
	?>
</body>
</html>
