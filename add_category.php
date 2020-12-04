<?php include('includes/header.php');?>
    
<?php include('includes/db_connection.php');?>
<?php include('includes/menu.php');?>

<?php 
    include('includes/function.php');
	include('language/language.php'); 
 	require_once("thumbnail_images.class.php");
	 
	if(isset($_POST['submit']) and isset($_GET['add']))
	{
			$category_image=rand(0,99999)."_".$_FILES['category_image']['name'];
			$pic1=$_FILES['category_image']['tmp_name'];
		
			$tpath1='images/'.$category_image;
				
				 copy($pic1,$tpath1);
				 
			$thumbpath='images/thumb/'.$category_image;
						$obj_img = new thumbnail_images();
						$obj_img->PathImgOld = $tpath1;
						$obj_img->PathImgNew =$thumbpath;
						$obj_img->NewWidth = 100;
						$obj_img->NewHeight = 100;
						if (!$obj_img->create_thumbnail_images()) 
						  {
							echo $_SESSION['msg']="Thumbnail not created... please upload image again";
						    exit;
						  }	 
	 
			$data = array(
			'category_name'  =>  $_POST['category_name'],
			'category_image'  =>  $category_image
			);

			$qry = Insert('tbl_category',$data);

		
			$_SESSION['msg']="8";
			header("location:categories");	 
			exit;
		
	}
	
	if(isset($_GET['category_id']))
	{
			 
			$category_qry="SELECT * FROM tbl_category where cid='".$_GET['category_id']."'";
			$category_result=mysqli_query($con, $category_qry);
			$category_row=mysqli_fetch_assoc($category_result);
		
	}
	
	if(isset($_POST['submit']) and isset($_POST['category_id']))
	{
		if($_FILES['category_image']['name']!=""){
		
			$img_res=mysqli_query('SELECT * FROM tbl_category WHERE cid=\''.$_POST['category_id'].'\'');
		$img_row=mysqli_fetch_assoc($img_res);
			
			if($img_row['category_image']!="")
			{
				unlink('images/thumb/'.$img_row['category_image']);
				unlink('images/'.$img_row['category_image']); 
			}
		
	
			$category_image=rand(0,99999)."_".$_FILES['category_image']['name'];
			$pic1=$_FILES['category_image']['tmp_name'];
		
			$tpath1='images/'.$category_image;
				
				 copy($pic1,$tpath1);
				 
					$thumbpath='images/thumb/'.$category_image;
						$obj_img = new thumbnail_images();
						$obj_img->PathImgOld = $tpath1;
						$obj_img->PathImgNew =$thumbpath;
						$obj_img->NewWidth = 100;
						$obj_img->NewHeight = 100;
						if (!$obj_img->create_thumbnail_images()) 
						  {
							echo $_SESSION['msg']="Thumbnail not created... please upload image again";
						    exit;
						  }	 		 
	 
			$data = array(
			'category_name'  =>  $_POST['category_name'],
			'category_image'  =>  $category_image
			);
		$category_edit=Update('tbl_category', $data, "WHERE cid = '".$_POST['category_id']."'");	
		
		}else
		{
				
				$data = array(
			'category_name'  =>  $_POST['category_name']
			);
		
		 $category_edit=Update('tbl_category', $data, "WHERE cid = '".$_POST['category_id']."'");
		}
			if ($category_edit > 0){
				
				$_SESSION['msg']="9";
				header( "Location:categories");
				exit;
			} 	
		
	 
	}
	
	
?>
<?php /*?>
<script src="js/jquery.min.js"></script>

<script type="text/javascript" src="js/jquery.validate.min.js"></script>

<script type="text/javascript">
(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#addeditcategory").validate({
                rules: {
                    
										category_name: "required",
								<?php 		if(!isset($_GET['category_id']))
										category_image: "required"
								?>
                   
                messages: {
                                        category_name: "Please Add category name",
										category_image: "Please enter category image" 
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    }

    //when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        JQUERY4U.UTIL.setupFormValidation();
    });

})(jQuery, window, document);
</script>
<?php */?>
<script src="js/add_category.js"></script>
<style>

#addeditradio label.error {
    color: #FB3A3A;
    display: inline-block;
    margin: 4px 0 5px 20px;
    padding: 0;
    text-align: left;
    width: 220px;
}
</style>

<div class="content">
        
        <div class="header">
            
            <h1 class="page-title"><?php if(isset($_GET['category_id'])){?>Edit Category<?php }else {?>Add Category<?php }?></h1>
        </div>
        
            <ul class="breadcrumb">
            <li><a href="dashboard">Home</a> <span class="divider">/</span></li>
            <li class="active"><?php if(isset($_GET['category_id'])){?>Edit Category<?php }else {?>Add Category<?php }?></li>
       	 </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
 
<div class="well">
<p style="color:#990000; font-size:14px;" align="center">
					<?php if(isset($_SESSION['msg'])){ 
						?>
							
					<div class="alert alert-info">
       					 <button type="button" class="close" data-dismiss="alert">×</button>
        				 <?php echo $admin_lang[$_SESSION['msg']] ; ?>
   					 </div>
                            
                            <?php unset($_SESSION['msg']);		
							
					}?>
                    
</p>
     
    <div id="myTabContent" class="tab-content">
    
      <div class="tab-pane active in" id="home">
    <form action="" name="addeditcategory" id="addeditcategory" method="post" class="jNice" enctype="multipart/form-data"
     onsubmit="<?php if(isset($_GET['category_id'])){?>return editValidation(this)<?php } else { ?> return checkValidation(this)
     <?php } ?>">
					 
				<input type="hidden" name="category_id" value="<?php echo $_GET['category_id'];?>" />	
        
				<label>Category Name</label>
        <input type="text" name="category_name" id="category_name" value="<?php if(isset($_GET['category_id'])){echo $category_row['category_name'];}?>" class="input-xlarge">
        
    <label>Category Image</label>
        	<?php if(isset($_GET['category_id'])){?>
          <img src="images/thumb/<?php echo $category_row['category_image'];?>">
       <?php }?>        	
        	<input type="file" name="category_image" id="category_image" value="<?php echo $category_row['category_image'];?>" class="input-xlarge" >
            
         <div>
          
            <button class="btn btn-primary" type="submit" name="submit"><?php if(isset($_GET['category_id'])){?>Edit Category
             <?php }else {?>Add Category<?php }?></button>
             
            
        </div>
        </form>
      </div>
       
  </div>

</div>
     </div>
      
   

<?php include('includes/footer.php');?>                  