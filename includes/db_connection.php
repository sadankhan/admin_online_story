

<?php
ob_start();
if(session_start() === NULL){
session_start();
}

$servername = "localhost";
$db_username = "root";
$db_password = "";

	 $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "story_db";
    $con=mysqli_connect($servername,$db_username,$db_password, $db_name);

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}
	 ?>
	

