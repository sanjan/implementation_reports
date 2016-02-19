<?php
require ("session.php");
require("dbcon.php"); 
include ("slash.php");


   
if(isset($_POST['updateprofile'])) //If submit is hit
{
  $npassword = $_POST['pass_word'];
   $nfullname = $_POST['full_name'];
   $nemail = $_POST['e_mail'];

$updprofile=mssql_query("UPDATE user_details SET password='$npassword',name='$nfullname' WHERE username='$loginname'");	
						
						
						
					if($updprofile)
					{
			echo ("<meta http-equiv=\"refresh\" content=\"1;url=./my_profile.php?user=$loginname\" />");
					}

}
if($_GET['user']) //If submit is hit
{
$query  = "SELECT * FROM user_details where username='$loginname'";
$result = mssql_query($query);

		while($row = mssql_fetch_row($result))
		{
		$username=$row[0];
		$fullname=$row[2];
		$password=$row[1];
		
		
		}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Implementation Reports</title>
<link href="default.css" rel="stylesheet" type="text/css" />

</head>

<body onload="setfocus()" >
<?php include("header.php"); ?>

<div id="content">
	
    	<div class="post">
        <h2 class="title">Update Particulars</h2>
        <div class="prompt">
<form action="my_profile.php" method="POST" name="profileform" id="cprofileform">
<table border="0" width="50%">
    <tr><td>User Name:</td><td><?php echo($username); ?></td></tr>
    <tr><td>Full Name:</td><td> <input type="textbox"  size="25" class="inputstyle" name="full_name" value="<?php echo($fullname); ?>" /></td></tr>
        <tr><td>Password:</td><td> <input type="textbox"  size="10" class="inputstyle" name="pass_word" value="<?php echo($password); ?>" /></td></tr>
            <tr><td>
			 <button type="submit" formmethod="post" formaction="my_profile.php" name="updateprofile" form="cprofileform"/>Update</button>
			</td></tr>
            </table>

</form>
<p></p>
</div>
   
	

		</div>
	</div>
<?php include("footer.php"); ?>
</body>
</html>