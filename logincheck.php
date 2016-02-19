<?php
require("dbcon.php");



// DATABASE CONNECTION STUFF GOES HERE
$userid = $_REQUEST['userid'];
$password  = $_REQUEST['password'];

$query = "SELECT * FROM user_details WHERE (username='$userid') AND (password='$password')";
$result = mssql_query($query);
$num = mssql_num_rows($result);
while($row = mssql_fetch_row($result))
		{
$log=$row[0];
$username=$row[2];
$accesslevel=$row[3];
}
if($num==1){
// IF THE NUMBER OF ROWS IS EQUAL TO ONE THEN THE USERNAME AND PASSWORD ENTERED ARE PRESENT IN THE DATABASE SO THE USER IS VALID.
// AS IT'S A VALID USER SET THE SESSION VARIABLES TO SHOW THEY ARE VALID
session_start();

$_SESSION['valid_user'] = true;
$_SESSION['user']=$username;
$_SESSION['access']=$accesslevel;
$_SESSION['login']=$log;
$gotourl=$_SESSION['oldURL'];

if (isset($gotourl)){
echo"<meta http-equiv=\"refresh\" content=\"0;url=$gotourl\" />";
}
else {
echo"<meta http-equiv=\"refresh\" content=\"0;url=index.php\" />";	
}
die();
 // KILL THE SCRIPT SO IT DOESN'T GO ANY FURTHER

}else{
// THE USER OR PASSWORD IS NOT VALID SO SEND THEM BACK TO THE login.php PAGE

header('Location:login.php');
echo("Invalid username/passsword");
die();

}
?>