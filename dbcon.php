<?php

ini_set ( 'mssql.textlimit' , '65536' );
ini_set ( 'mssql.textsize' , '65536' );

$dbhost = '127.0.0.1\SQLEXPRESS,1433';
$dbuser = 'sanjan';
$dbpass = 'sanjan';
$dbname = 'Sybase365';
$conn = mssql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to MSSQL');
mssql_select_db($dbname, $conn)or die("Couldn't open database");

?>