<?php include("includes/db_connection.php");
header('content-type:text/html;charset=utf-8');

if(isset($_GET['cat_id']))
	{
		
		$cat_id=$_GET['cat_id'];		
	
			$query="SELECT * FROM tbl_story_detail
  where category_id='".$cat_id."' ORDER BY tbl_story_detail.story_id DESC";
		
	}
	else
	{
 
	$query="SELECT cid,category_name,category_image FROM tbl_category ORDER BY tbl_category.cid DESC";
	}
	
	$resouter = mysql_query($query);
     
    $set = array();
     
    $total_records = mysql_num_rows($resouter);
    if($total_records >= 1){
     
      while ($link = mysql_fetch_array($resouter, MYSQL_ASSOC)){
	   
        $set['Online Story App'][] = $link;
      }
    }
     
     echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE));
	 	 
	 
?>