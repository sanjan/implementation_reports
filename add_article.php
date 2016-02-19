<?php
require ("session.php");

require("dbcon.php"); 

include("slash.php");

if($access==1):

	header("Location:access_denied.php");	

else:

foreach($_POST as $k=>$v) {
$_SESSION['post'][$k]=$v;
}


$result = mssql_query("SELECT * FROM kb_categories");
	$today=date("d-m-y"); 
	
if($_POST['addalert']) //If submit is hit
{
   
   $_SESSION['post']['alertname'] = $_POST['aname'];
   $_SESSION['post']['alertdesc'] = $_POST['adesc'];
   $_SESSION['post']['alertcat'] = $_POST['acat'];
   $_SESSION['post']['alertsample'] = $_POST['asample'];
   $_SESSION['post']['alertsolution'] = $_POST['solution'];
   $_SESSION['post']['author'] = $_POST['user'];
  
   
	if (empty($_SESSION['post']['alertname']))
	{
		$alerter="Article title cannot be blank!";
		
	} 
	else
	{
		$rescheck=mssql_query("SELECT title from kb_articles where title='". $_SESSION['post']['alertname'] . "'");
			$returned_rows = mssql_num_rows ($rescheck);
            if ($returned_rows == 0)
			{
				echo ("<meta http-equiv=\"refresh\" content=\"1;url=./select_hosts_new.php\" />");
			}
			else
			{
				$alerter="An article with the given title already exists! Change the title and try again.";
				echo ("<meta http-equiv=\"refresh\" content=\"1;url=./add_article.php\" />");
			}
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Knowledge 365 - Post new article</title>
<link href="default.css" rel="stylesheet" type="text/css" />
<!-- TinyMCE -->
<script type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
	// General options
	mode : "textareas",
	theme : "advanced",
	plugins : "table",

	// Theme options
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,pastetext,|,search,replace,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,|,tablecontrols",
	theme_advanced_buttons3 : "",
	theme_advanced_buttons4 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : false	
});
</script>
<!-- /TinyMCE -->

</head>

<body>

<?php include("header.php"); ?>

<div id="content">
		<div class="post">
			<h2 class="title">Post new article</h2>
			<div class="entry">
			<form method="post" action="add_article.php" name="addform">
					<p>
					 <label class="labelstyle">Title:</label><br />
<input type="textbox"  size="140"class="inputstyle" name="aname" value=<? echo($_SESSION['post']['alertname']); ?> >
<br/>
<?php 
if (!empty($alerter)){
echo("<script language=\"Javascript\">alert (\"$alerter\")</script>"); }?>       
</p>

<p><label class="labelstyle" for="comments">Description:</label><br />
<textarea id="comments" class="inputstyle"rows="5" cols="100" name="adesc" value=<? echo($_SESSION['post']['alertdesc']); ?> > </textarea>
</p>

<p><label class="labelstyle" for="category">Category:</label><br />
<select name="acat" class="inputstyle"id="category" value=<? echo($_SESSION['post']['alertcat']); ?> >
<?php
//for each row we get from mysql, echo a form input
while ($row = mssql_fetch_row($result)) {
echo ("<option value=\"$row[0]\">$row[1]</option>\n");
}
?> 
</select></p>

<p><label class="labelstyle" for="comments">Sample Alert:</label><br />
<textarea id="comments" rows="5" class="inputstyle"cols="100" name="asample"  value=<?php echo($_SESSION['post']['alertsample']); ?> > </textarea>
</p>

<p><label class="labelstyle" for="comments">Solution:</label><br />
<textarea id="comments" name="solution" rows="15" cols="87" value= <? echo($_SESSION['post']['alertsolution']); ?> > </textarea>
</p>


<input type="submit" name="addalert" id="x" value="Next" class="formbutton" />
<input type="reset" name="clearform" id="x" value="Clear Form" class="formbutton" />
<input type ="hidden" value="<? echo $user; ?>" name="user" />
					
				</form>
               
			</div>
		
		</div>
	</div>
<? include("footer.php");?>
</body>
</html>

<?
endif;
?>
