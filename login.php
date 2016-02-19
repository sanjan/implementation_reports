<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Implementation Reports</title>
<link href="default.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="jscripts/jquery.js">
    </script>
    <script type="text/javascript"
    src="jscripts/sweetalert-master/dist/sweetalert-dev.js">
    </script>
    <link type="text/css"
    href="jscripts/sweetalert-master/dist/sweetalert.css"
    rel="stylesheet" />
</head>

<body>
<?php include("header.php"); ?>
    <div id="content">
	
    	<div class="post">
        <div class="prompt">
					<h2>Please sign in:</h2>

	<table width="300" border="0" align="center" cellpadding="0" cellspacing="1">
    <tr>
    <form name="formlogin" method="post" action="logincheck.php" id="cformlogin">
    <td>
    <table width="100%" border="0" cellpadding="3" cellspacing="1">
    <tr>
    </tr>
    <tr>
    <td width="78">Username</td>
    <td width="6">:</td>
    <td width="294"><input name="userid" type="text" id="userid"></td>
    </tr>
    <tr>
    <td>Password</td>
    <td>:</td>
    <td ><input name="password" type="password" id="password"></td>
    </tr>
    <tr>
    <td></td>
    <td></td>
    <td><button type="submit" formmethod="post" formaction="logincheck.php" name="Submit" form="cformlogin"/>Sign In</button></td>
    </tr>
	<tr>
    <td></td>
    <td></td>
    <td>Don't have a login? <a href="request_access.php">Request Access</a></td>
	
    </tr>
		<tr>
    <td></td>
    <td></td>
    
	<td><a href="request_credentials.php">Forgot password?</a></td>
    </tr>
	
	
    </table>
    </td>
    </form>
    </tr>
    </table>
    <p><br/><b>Note:</b> disable “Display intranet sites in Compatibility View” if you are using Internet Explorer<br/><br/>
	If you have difficulties signing in, please contact: <a href="mailto:suhwei.lee@sap.com">suhwei.lee@sap.com</a></p> 
            </div>
		</div>
	</div>
		
	
   
<? include("footer.php");?>

</div>

</body>
</html>