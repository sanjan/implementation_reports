<?php
session_start();
if($_SESSION['valid_user']==true){
session_destroy();
}
header('Location:login.php');
die();
?>
