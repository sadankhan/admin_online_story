<?php error_reporting(0);
include('db_connection.php');

#Admin Login
function adminUser($username, $password) {
     
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "story_db";

try {
  $conn = new PDO("mysqli:host=$servername;dbname=$dbname", $db_username, $db_password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT id, username FROM admin where username = '".$username."' AND password = '".$password."'";
  $stmt = $conn->prepare($sql);
  $stmt->execute();

  // set the resulting array to associative
  $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
  foreach($stmt->fetchAll() as $k=>$v) {
    $_SESSION['ADMIN_USERNAME'] = $v['username'];
    $_SESSION['ADMIN_ID'] = $v['id'];
   

  }
}
catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
$conn = null;

return 5;   
}


# Insert Data 
function Insert($table, $data){

    $fields = array_keys( $data );  
    $values = array_map( "mysqli_real_escape_string", array_values( $data ) );
    mysqli_query($con, "INSERT INTO $table(".implode(",",$fields).") VALUES ('".implode("','", $values )."');") or die( mysqli_error() );

}



// Update Data, Where clause is left optional
function Update($table_name, $form_data, $where_clause='')
{
    // check for optional where clause
    $whereSQL = '';
    if(!empty($where_clause))
    {
        // check to see if the 'where' keyword exists
        if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
        {
            // not found, add key word
            $whereSQL = " WHERE ".$where_clause;
        } else
        {
            $whereSQL = " ".trim($where_clause);
        }
    }
    // start the actual SQL statement
    $sql = "UPDATE ".$table_name." SET ";

    // loop and build the column /
    $sets = array();
    foreach($form_data as $column => $value)
    {
         $sets[] = "`".$column."` = '".$value."'";
    }
    $sql .= implode(', ', $sets);

    // append the where statement
    $sql .= $whereSQL;
 		 
    // run and return the query result
    return mysqli_query($con, $sql);
}



//Delete Data, the where clause is left optional incase the user wants to delete every row!
function Delete($table_name, $where_clause='')
{
    // check for optional where clause
    $whereSQL = '';
    if(!empty($where_clause))
    {
        // check to see if the 'where' keyword exists
        if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
        {
            // not found, add keyword
            $whereSQL = " WHERE ".$where_clause;
        } else
        {
            $whereSQL = " ".trim($where_clause);
        }
    }
    // build the query
    $sql = "DELETE FROM ".$table_name.$whereSQL;
	 
    // run and return the query result resource
    return mysqli_query($con, $sql);
}

//Select Data, Function(table,column_name,identifier)
function Single($table,$tcol,$tid) 
{
     
    /*Query and link identifier were in the wrong order*/
    return mysqli_query($con, "SELECT * FROM ".$table." WHERE ".$tcol."=".$tid."");
}
 

//Get date
function Viavi_Datetime() {
    $tz_object = new DateTimeZone('Asia/Kolkata');
    //date_default_timezone_set('Brazil/East'); 
    $datetime = new DateTime();
    $datetime->setTimezone($tz_object);     
return $datetime->format('Y\-m\-d\ h:i:s');
}
 
 
//F
function Viavi_email()
{
	$headers = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Mail it
   if(@mail($to, $subject, $message, $headers)){
   	
		$mail_send="OK";
       	return $mail_send;		 
   }

   else
   {
         $mail_send= "Fail";
		 return $mail_send;
	}
		
}


function breadcrumbs(){
  $path = $_SERVER["PHP_SELF"];
	$parts = explode('/',$path);
	if (count($parts) < 2)
	{
	echo("home");
	}
	else
	{
	echo ("<a href=\"/\">home</a> &raquo; ");
	for ($i = 1; $i < count($parts); $i++)
    	{
    	if (!strstr($parts[$i],"."))
        	{
        	echo("<li><a href=\"");
        	for ($j = 0; $j <= $i; $j++) {echo $parts[$j]."/";};
        	echo("\">". str_replace('-', ' ', $parts[$i])."</a><span class='divider'>/</span></li>");
        	}
    	else
        	{
       	 	$str = $parts[$i];
        	$pos = strrpos($str,".");
        	$parts[$i] = substr($str, 0, $pos);
        	echo str_replace('-', ' ', $parts[$i]);
        	};
    	};
	};  
}
 
?>