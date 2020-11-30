<?php include('includes/header.php');?>
    

<?php include('includes/menu.php');?>
  <?php 
						
						$qry_story="SELECT COUNT(*) as num FROM tbl_story_detail";
						$total_story= mysql_fetch_array(mysql_query($qry_story));
						$total_story = $total_story['num'];
						
						$qry_cat="SELECT COUNT(*) as num FROM tbl_category";
						$total_cat= mysql_fetch_array(mysql_query($qry_cat));
						$total_cat = $total_cat['num'];
						
						
					
					?>	

    <div class="content">
        
        <div class="header">
             

            <h1 class="page-title">Dashboard</h1>
        </div>
        
        <ul class="breadcrumb">
            <li><a href="dashboard">Home</a> <span class="divider">/</span></li>
            <li class="active">Dashboard</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    

<div class="row-fluid">
 
    <div class="block">
        <a href="#page-stats" class="block-heading" data-toggle="collapse">Latest Stats</a>
        <div id="page-stats" class="block-body collapse in">

            <div class="stat-widget-container">
                <div class="stat-widget">
                    <div class="stat-button">
                        <p class="title"><?php echo $total_story;?></p>
                        <p class="detail">Total Stories</p>
                    </div>
                </div>
                
                <div class="stat-widget">
                    <div class="stat-button">
                        <p class="title"><?php echo $total_cat;?></p>
                        <p class="detail">Total Categories</p>
                    </div>
                </div>

    
            </div>
        </div>
    </div>
</div>

                 
           
  <?php include('includes/footer.php');?>                  