

<!DOCTYPE html>
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

<body onload="setfocus()" >
<?php include("header.php"); ?>

<div id="content">
	
    	<div class="post">
        <h2 class="title">Request access</h2>
        <div class="prompt">

<table border="0" width="50%">
    <tr><td>First Name:</td><td> <input type="text"  id="fname" size="30" class="inputstyle" name="first_name" value="" placeholder="Enter your first name" required /></td></tr>
    <tr><td>Last Name:</td><td> <input type="text"  id="lname" size="30" class="inputstyle" name="last_name" value="" placeholder="Enter your last name" required /></td></tr>    
    <tr><td>Email:</td><td> <input type="email" id="emailtextbox" size="30" class="inputstyle" name="email" value="" placeholder="Enter a valid email address" required /></td></tr>
            <tr><td></td><td>
			 <button  name="createprofile" id="createprofile" />Send Request</button>
			</td></tr>
            </table>


<p></p>
</div>
   
	

		</div>
	</div>

	<script>
document.getElementById("createprofile").onclick = function(){
	
	var email=document.getElementById("emailtextbox").value;
	var fname=document.getElementById("fname").value;
	var lname=document.getElementById("lname").value;
	$.ajax({  
    type: "POST",  
    url: "approval_request.php",  
    data: { 'email':email, 'fname': fname, 'lname': lname },      
    success: function(data){ 
if (data=="userexist")  {
	 swal({title: "Error",text: "A user with the email address provided already exist!",type: "error"});
    }
else{ // can create a user
	
	 swal({title: "Success",text: "your credentials will be emailed once the request is approved" + data,type: "success"},function(){ window.location.href='index.php';});
}	
	},
	error: function(XMLHttpRequest, textStatus, errorThrown) { 
        swal(errorThrown, "error");
    }
	
	});

	
	
};
</script>
	
<?php include("footer.php"); ?>
</body>
</html>