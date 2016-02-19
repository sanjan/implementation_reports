<?php
echo("
<div id=\"header\">
	<div id=\"logo\">
		<h1><a href=\"index.php\">Implementation Reports</a></h1>
		<h2><a href=\"index.php\">SAP Mobile Services - Enterprise Service</a></h2>
		<br/>
	</div>");
	
if($_SESSION['valid_user']==true){
$u=explode(" ",$user); 
echo ("<div id=\"menu\">
		<ul>
			<li class=\"first\"><a href=\"index.php\" accesskey=\"1\" title=\"\">Home</a></li>
			<li><a href=\"search.php\" accesskey=\"2\" title=\"\">Search</a></li>");
if($access>1){
echo ("<li ><a href=\"new_report.php\" accesskey=\"3\" title=\"\">Post New</a></li>");

}			
	
if($access==3){
echo ("<li ><a href=\"view_all.php\" accesskey=\"5\" title=\"\">View All</a></li>");

}			
echo ("<li ><a href=\"my_profile.php?user=$loginname\" accesskey=\"6\" title=\"\">My Profile</a></li>");

		echo	("<li ><a href=\"logout.php\" accesskey=\"7\" title=\"\">Sign Out</a></li>							
		</ul>
	</div>");
}	
echo("</div>");
?>
