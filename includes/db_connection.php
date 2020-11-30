<?php ob_start();
 #Session Start
 session_start();

 # Selects the database

 
 if($_SERVER['HTTP_HOST']=="localhost"){
 
	 DEFINE ('DB_USER', 'root');
	 DEFINE ('DB_PASSWORD', '');
	 DEFINE ('DB_HOST', 'localhost');
	 DEFINE ('DB_NAME', 'story_db');
 
 }else
 {
	 DEFINE ('DB_USER', 'USERNAME');
	 DEFINE ('DB_PASSWORD', 'PASSWORD');
	 DEFINE ('DB_HOST', 'localhost');
	 DEFINE ('DB_NAME', 'DATABASENAME'); 
 }

 $mysqli = @mysql_connect (DB_HOST, DB_USER, DB_PASSWORD) OR die ('Could not connect to MySQL');
 mysql_query("SET CHARACTER SET utf8");
 mysql_query("SET NAMES 'utf8'");
@mysql_select_db (DB_NAME) OR die ('Could not select the database');
 
 
 
?>