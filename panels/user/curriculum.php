<?php 
session_start();
if(!empty($_SESSION['username'])){
  $title="curriculum";
require_once('header.php');
 ?>
<!--  Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="d-flex align-items-end row">
            <div class="col-sm-7">
              <div class="card-body">
                <h5 class="card-title text-primary">Access Your Current Level's Curriculum</h5>
                
              </div>
            </div>
          
          </div>
        </div>
      </div>
      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="d-flex align-items-end row">
            <div class="col-sm-12">
              <div class="card-body">
                <!-- <h5 class="card-title text-primary">Instructions to Use the Portal</h5> -->
                 <?php
                 if($_SESSION['domain']=='java'){
                    ?>
                    <embed src="../../pdf/PTE_Level-2(Java).pdf#toolbar=0" width="100%" height="600px" type="application/pdf" >
                    <?php
                 }elseif($_SESSION['domain']=='web'){
                    ?>
                    <embed src="../../pdf/PTE_Level-2(web).pdf#toolbar=0" width="100%" height="600px" type="application/pdf" >
                    <?php
                 }elseif($_SESSION['domain']=='android'){
                    ?>
                    <embed src="../../pdf/PTE_Level-2(Java).pdf#toolbar=0" width="100%" height="600px" type="application/pdf" >
                    <?php
                 }else{
                    echo "You are not assigned to any Course";
                 }

                 ?>
                

                
              </div>
            </div>
          
          </div>
        </div>
      </div>
      
    </div>
  </div>
  
<!-- / Content -->

<?php 
require_once('footer.php');
}else{
  header('location:login.php');
}
?>

            