<?php
include('includes/db_connection.php');
include('includes/function.php'); 

$username= trim($_POST['username']);
$password= trim($_POST['password']);

 
$authUser = adminUser($username,$password);
echo $authUser;	
if (isset($_SESSION['ADMIN_USERNAME'])){
	
    header( "Location:dashboard");
	exit;
}
else
{
	$_SESSION['msg']="1";
	header( "Location:index");
	exit;
}
 
?> 