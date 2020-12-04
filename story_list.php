<?php include('includes/header.php');?>
<?php include('includes/menu.php');?>

<?php 
    include('includes/function.php');
	include('language/language.php');  
	if(isset($_POST['story_search'])) {
		 
		$story_qry="SELECT * FROM tbl_story_detail WHERE tbl_story_detail.story_title like '%".addslashes($_POST['story_title'])."%' ORDER BY tbl_story_detail.story_id DESC"; 
							 
		$story_result=mysqli_query($con,$story_qry);
		 
	} else {
	 
		$tableName="tbl_story_detail";		
		$targetpage = "story_list"; 	
		$limit = 15; 
							
		$query = "SELECT COUNT(*) as num FROM $tableName";
		$total_pages = mysqli_fetch_array(mysqli_query($query));
		$total_pages = $total_pages['num'];
							
		$stages = 3;
		$page=0;
		if(isset($_GET['page'])){
			$page = mysqli_escape_string($_GET['page']);
		}
		if($page){
			$start = ($page - 1) * $limit; 
		} else {
			$start = 0;	
		}	
												
		$story_qry="SELECT * FROM tbl_story_detail LEFT JOIN tbl_category ON tbl_story_detail.category_id= tbl_category.cid ORDER BY tbl_story_detail.story_id DESC LIMIT $start, $limit"; 
							 
		$story_result=mysqli_query($con,$story_qry);
							
	}

	if(isset($_GET['story_id'])) {
		 
		$img_res=mysqli_query($con,'SELECT * FROM tbl_story_detail WHERE story_id=\''.$_GET['story_id'].'\'');
		$img_row=mysqli_fetch_assoc($img_res);
			
		if($img_row['story_image']!="") {
			unlink('images/thumb/'.$img_row['story_image']);
			unlink('images/'.$img_row['story_image']);
		}	 
		 
		Delete('tbl_story_detail','story_id='.$_GET['story_id'].'');
		
		$_SESSION['msg']="7";
		header( "Location:story_list");
		exit;
	}
?>
<div class="content">
    <div class="header">
        <h1 class="page-title">Story List</h1>
    </div>
        <ul class="breadcrumb">
           <li><a href="dashboard">Home</a> <span class="divider">/</span></li>
           <li class="active">Story List</li>
       	</ul>

        <div class="container-fluid">
        	<div class="row-fluid">
                <div class="btn-toolbar">
                	<button class="btn btn-primary" onclick="window.location.href='add_story?add'"><i class="icon-plus"></i>Add New Story
                	</button>
                	<div class="btn-group">
                		<div class="search-well">
                			<form class="form-inline" action="" method="post">
                				<input class="input-xlarge" placeholder="Search Story..." name="story_title" id="appendedInputButton" type="text" required>
                				<button class="btn" type="submit" name="story_search"><i class="icon-search"></i> Go
                				</button>
                			</form>
            			</div>
  					</div>
				</div>
				<div class="well">
					<p style="color:#990000; font-size:14px;" align="center">
						<?php if(isset($_SESSION['msg'])){?>
							
					<div class="alert alert-info">
       					 <button type="button" class="close" data-dismiss="alert">×</button>
        				 <?php echo $admin_lang[$_SESSION['msg']] ; ?>
   					 </div>
                            
                            <?php unset($_SESSION['msg']);		
							
					}?>
                    
</p>

    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Story Title</th>
          <th>Story Category</th>
          <th>Story Image</th>
           
          <th style="width: 26px;"></th>
        </tr>
      </thead>
      <tbody>
        <?php 
					$i=1;
					while($story_row=mysqli_fetch_array($story_result))
					{
				?>
        
        <tr>
          <td><?php echo $i;?></td>
          <td><?php echo $story_row['story_title'];?></td>
          <td><?php echo $story_row['category_name'];?></td>  
          <td><img src="images/thumb/<?php echo $story_row['story_image'];?>" /></td>   
          <td>
              <a href="add_story?story_id=<?php echo $story_row['story_id'];?>"><i class="icon-pencil"></i></a>
              <a href="story_list?story_id=<?php echo $story_row['story_id'];?>" onclick="return confirm('Are you sure you want to delete this story?');" ><i class="icon-remove"></i></a>
          </td>
        </tr>
       <?php $i++;}?>   
      </tbody>
    </table>
  		 
</div>
<?php
								// Initial page num setup
	if ($page == 0){$page = 1;}
	$prev = $page - 1;	
	$next = $page + 1;							
	$lastpage = ceil($total_pages/$limit);		
	$LastPagem1 = $lastpage - 1;					
	
	
	$paginate = '';
	if($lastpage > 1)
	{	
	 
	
		$paginate .= "<div class='pagination'><ul>";
		// Previous
		if ($page > 1){
			$paginate.= "<li><a href='$targetpage?page=$prev'>Prev</a></li>";
		}else{
			$paginate.= "<li><a href='#'>Prev</a></li>";	}
			

		
		// Pages	
		if ($lastpage < 7 + ($stages * 2))	// Not enough pages to breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page){
					$paginate.= "<li><a href='$targetpage?page=$counter'>$counter</a></li>";
				}else{
					$paginate.= "<li><a href='$targetpage?page=$counter'>$counter</a></li>";}					
			}
		}
		elseif($lastpage > 5 + ($stages * 2))	// Enough pages to hide a few?
		{
			// Beginning only hide later pages
			if($page < 1 + ($stages * 2))		
			{
				for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
				{
					if ($counter == $page){
						$paginate.= "<li><a href='$targetpage?page=$counter'>$counter</a></li>";
					}else{
						$paginate.= "<li><a href='$targetpage?page=$counter'>$counter</a></li>";}					
				}
				$paginate.= "<li><a href='#'>...</a></li>";
				$paginate.= "<li><a href='$targetpage?page=$LastPagem1'>$LastPagem1</a></li>";
				$paginate.= "<li><a href='$targetpage?page=$lastpage'>$lastpage</a></li>";		
			}
			// Middle hide some front and some back
			elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))
			{
				$paginate.= "<li><a href='$targetpage?page=1'>1</a></li>";
				$paginate.= "<li><a href='$targetpage?page=2'>2</a></li>";
				$paginate.= "<li><a href='#'>...</a></li>";
				for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)
				{
					if ($counter == $page){
						$paginate.= "<li><a href='$targetpage?page=$counter'>$counter</a></li>";
					}else{
						$paginate.= "<li><a href='$targetpage?page=$counter'>$counter</a></li>";}					
				}
				$paginate.= "<li><a href='#'>...</a></li>";
				$paginate.= "<li><a href='$targetpage?page=$LastPagem1'>$LastPagem1</a></li>";
				$paginate.= "<li><a href='$targetpage?page=$lastpage'>$lastpage</a></li>";		
			}
			// End only hide early pages
			else
			{
				$paginate.= "<li><a href='$targetpage?page=1'>1</a></li>";
				$paginate.= "<li><a href='$targetpage?page=2'>2</a></li>";
				$paginate.= "<li><a href='#'>...</a></li>";
				for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page){
						$paginate.= "<li><a href='$targetpage?page=$counter'>$counter</a></li>";
					}else{
						$paginate.= "<li><a href='$targetpage?page=$counter'>$counter</a></li>";}					
				}
			}
		}
					
				// Next
		if ($page < $counter - 1){ 
			$paginate.= "<li><a href='$targetpage?page=$next'>next</a></li>";
		}else{
			$paginate.= "<li><a href='#'>next</a></li>";
			}
			
		$paginate.= "</ul></div>";		
	
	
}
  
 // pagination
 echo $paginate;
?>	


<?php include('includes/footer.php');?>                  