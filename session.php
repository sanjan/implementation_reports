<?php
session_start();

if($_SESSION['valid_user']!=true){
if (($_SERVER['REQUEST_URI'] != 'login.php') && ($_SERVER['REQUEST_URI'] != $_SESSION['oldURL'])) {
    $_SESSION['oldURL']     = $_SERVER['REQUEST_URI'];    
}	
header('Location:login.php');
die();
}
else{
$user=$_SESSION['user'];
$access=$_SESSION['access'];
$loginname=$_SESSION['login'];
}

?>