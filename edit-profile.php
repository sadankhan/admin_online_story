
<?php include('includes/header.php');?>
 

<?php include('includes/menu.php');?>

<?php 
    include('includes/function.php');
	include('language/language.php'); 
 
	
	$result= Single('admin','id',$_SESSION['ADMIN_ID']);
	$row=mysqli_fetch_assoc($result);
	
	if(isset($_POST['submit']))
	{
		 	
				
			if($_POST['password'])
			{
				$data = array(
					'password'  =>  $_POST['password']    
				);	
				
			}
			else
			{
				 
				$data = array(
					'username'  =>  $_POST['username'],
					'email'     =>  $_POST['email']    
				);
			}
			
			$admin_pro=Update('admin', $data, "WHERE id = '1'");
			 
			if ($admin_pro > 0){
				
				$_SESSION['msg']="2";
				header( "Location:edit-profile");
				exit;
			} 	
	}
	
	 
?>
<div class="content">
        
        <div class="header">
            
            <h1 class="page-title">Edit Profile</h1>
        </div>
        
            <ul class="breadcrumb">
            <li><a href="dashboard">Home</a> <span class="divider">/</span></li>
            <li class="active">Edit Profile</li>
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
    <ul class="nav nav-tabs">
      <li class="active"><a href="#home" data-toggle="tab">Profile</a></li>
      <li><a href="#profile" data-toggle="tab">Password</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
    
      <div class="tab-pane active in" id="home">
    <form id="tab" method="post" action="" name="admin_profile">
        <label>Username</label>
        <input type="text" name="username" value="<?php echo $row['username'];?>" class="input-xlarge">         
        <label>Email</label>
        <input type="text" name="email" value="<?php echo $row['email'];?>" class="input-xlarge">
         
         <div>
            <button class="btn btn-primary" type="submit" name="submit">Update</button>
        </div>
        </form>
      </div>
      <div class="tab-pane fade" id="profile">
    <form id="tab2" action="" method="post">
        <label>New Password</label>
        <input type="password" name="password" value="" class="input-xlarge">
        <div>
            <button class="btn btn-primary" type="submit" name="submit">Update</button>
        </div>
    </form>
      </div>
  </div>

</div>
     </div>
       
   

<?php include('includes/footer.php');?>                  