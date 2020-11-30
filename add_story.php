<?php include('includes/header.php');?>
    

<?php include('includes/menu.php');?>

<?php 
    include('includes/function.php');
	include('language/language.php'); 
 	require_once("thumbnail_images.class.php");
	
	$qry="select * from tbl_category";
	$res=mysql_query($qry);
	 
	if(isset($_POST['submit']) and isset($_GET['add']))
	{
			$story_image=rand(0,99999)."_".$_FILES['story_image']['name'];
			$pic1=$_FILES['story_image']['tmp_name'];
		
			$tpath1='images/'.$story_image;
				
				 copy($pic1,$tpath1);
				 
			$thumbpath='images/thumb/'.$story_image;
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
			'category_id' => $_POST['category_id'],
			'story_title'  =>  $_POST['story_title'],
			'story_image'  =>  $story_image,
			'story_description'  =>  addslashes($_POST['story_description'])					 	 
			);

			$qry = Insert('tbl_story_detail',$data);

		
			$_SESSION['msg']="5";
			header("location:story_list");	 
			exit;
		
	}
	
	if(isset($_GET['story_id']))
	{
			 
			$story_qry="SELECT * FROM tbl_story_detail where story_id='".$_GET['story_id']."'";
			$story_result=mysql_query($story_qry);
			$story_row=mysql_fetch_assoc($story_result);
		
	}
	if(isset($_POST['submit']) and isset($_POST['story_id']))
	{
		if($_FILES['story_image']['name']!="")
		{
		
		$img_res=mysql_query('SELECT * FROM tbl_story_detail WHERE story_id=\''.$_POST['story_id'].'\'');
		$img_row=mysql_fetch_assoc($img_res);
			
			if($img_row['story_image']!="")
			{
				unlink('images/thumb/'.$img_row['story_image']);
				unlink('images/'.$img_row['story_image']); 
			}	 
		 
			
			$story_image=rand(0,99999)."_".$_FILES['story_image']['name'];
			$pic1=$_FILES['story_image']['tmp_name'];
		
			$tpath1='images/'.$story_image;
				
				 copy($pic1,$tpath1);
				 
					$thumbpath='images/thumb/'.$story_image;
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
			'category_id' => $_POST['category_id'],
			'story_title'  =>  $_POST['story_title'],
			'story_image'  =>  $story_image,
			'story_description'  =>  addslashes($_POST['story_description'])
			);
		 $story_edit=Update('tbl_story_detail', $data, "WHERE story_id = '".$_POST['story_id']."'");	

		}else
		
		{
				$data = array(
				'category_id' => $_POST['category_id'],
			'story_title'  =>  $_POST['story_title'],
			'story_description'  => addslashes($_POST['story_description'])
			);
		$story_edit=Update('tbl_story_detail', $data, "WHERE story_id = '".$_POST['story_id']."'");
		}
			
			if ($story_edit > 0){
				
				$_SESSION['msg']="6";
				header( "Location:story_list");
				exit;
			} 	
	}
?>
<?php /*?><script src="js/jquery.min.js"></script>

<script type="text/javascript" src="js/jquery.validate.min.js"></script>

<script type="text/javascript">
(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            form validation rules
            $("#addeditstory").validate({
                rules: {
                    
										story_title: "required",
										
								<?php 		if(!isset($_GET['radio_id']))
										radio_image: "required"
								?>
								story_description: "required"
                   
                messages: {
                                        story_title: "Please Add Story Title",
										story_image: "Please enter Story Image",
											story_description: "Please Add Story Description"
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    }

    when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        JQUERY4U.UTIL.setupFormValidation();
    });

})(jQuery, window, document);
</script>
<?php */?>
<script src="js/add_story.js"></script>
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
            
            <h1 class="page-title"><?php if(isset($_GET['story_id'])){?>Edit story<?php }else {?>Add story<?php }?></h1>
        </div>
        
            <ul class="breadcrumb">
            <li><a href="dashboard">Home</a> <span class="divider">/</span></li>
            <li class="active"><?php if(isset($_GET['story_id'])){?>Edit story<?php }else {?>Add story<?php }?></li>
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
    <form action="" name="addeditstory" id="addeditstory" method="post" class="jNice" enctype="multipart/form-data"  onsubmit="<?php if(isset($_GET['story_id'])){?>return editValidation(this)<?php } else { ?> return checkValidation(this)
     <?php } ?>">
					 
					<input  type="hidden" name="story_id" value="<?php echo $_GET['story_id'];?>" />
                    <label>Select Category:</label>
								
								 
									<select name="category_id" id="category_id" style="width:280px; height:25px;">
			
										<option value="">--Select Category--</option>
										 <?php while($cat_row=mysql_fetch_array($res)){?>
          <option value="<?php echo $cat_row['cid'];?>" <?php if($cat_row['cid']==$story_row['category_id']){?>selected<?php }?>><?php echo $cat_row['category_name'];?></option>
          <?php }?>
									</select>
        
				<label>Story title</label>
        <input type="text" name="story_title" id="story_title" value="<?php if(isset($_GET['story_id']))
		{echo $story_row['story_title'];}?>" class="input-xlarge">
        
    <label>Story Image</label>
        	<?php if(isset($_GET['story_id'])){?>
          <img src="images/thumb/<?php echo $story_row['story_image'];?>">
       <?php }?>        	
  <input type="file" name="story_image" id="story_image" value="<?php echo $story_row['story_image'];?>" class="input-xlarge" >
            
             <label>Story Description</label>
        <textarea name="story_description" id="story_description" class="input-xlarge"><?php if(isset($_GET['story_id'])){echo $story_row['story_description'];}?></textarea>
            
         <div>
          
            <button class="btn btn-primary" type="submit" name="submit"><?php if(isset($_GET['story_id'])){?>Edit Story <?php }else {?>Add Story<?php }?></button>
             
            
        </div>
        </form>
      </div>
       
  </div>

</div>
     </div>
      
   

<?php include('includes/footer.php');?>                  