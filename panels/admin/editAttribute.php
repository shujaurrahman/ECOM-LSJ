<?php 
session_start();
if(!empty($_GET['id'])){

  if(!empty($_SESSION['role']) ){
    $title="attribute";
  require_once('header.php');

  if(!empty($_POST['name'])  ){
    // print_r($_POST);
    //   die();
      require_once('./logics.class.php');
      $adminObj = new logics();

      

      $verification = $adminObj->UpdateAttribute($_POST['name'],$_POST['id']);
      
      if(!empty($verification['status']) && $verification['status']==1){
          echo '<script src="../js/sweetalert.js"></script>';
          echo '<script>';
          echo 'Swal.fire({
                  icon: "success",
                  title: "Attribute Successfully Updated!",
                  showConfirmButton: true,
              }).then(function() {
                  window.location.href = "getAttributes";
              });';
          echo '</script>';
      }else{
          echo '<script src="../js/sweetalert.js"></script>';
          echo '<script>';
          echo 'Swal.fire({
                  icon: "error",
                  title: "Data not Submitted!",
                  text: "Please try again"
              }).then(function() {
                  window.location.href = "getAttributes";
              });';
          echo '</script>';
      }
  }

  require_once('./logics.class.php');

  $obj = new logics();
  $editCategory = $obj->getAttribute();

  if (!empty($editCategory['status']) && $editCategory['status'] == 1) {
  ?>
  <!--  Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="row">
        <div class="col-lg-12 mb-4 order-0">
          <div class="card">
            <div class="d-flex align-items-end row">
              <div class="col-sm-12">
                <div class="card-body d-flex justify-content-between">
                  <h5 class="card-title text-primary">Add New Attribute</h5>
                  <a href="./getAttributes" class="btn btn-sm btn-primary">View Added Attributes</a>
                  
                </div>
              </div>
            
            </div>
          </div>
        </div>
      </div>

      <form action="./editAttribute?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" class="row">
        
        <div class="col-lg-12 mb-4 order-0">
          <div class="card">
            <div class="card-body">
              <?php
              for($i=0;$i<$editCategory['count'];$i++){
                if($editCategory['id'][$i] == $_GET['id']){
                  ?>
                  <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" id="">

                  

                  <label for="name">Attribute Name <sup class="text-danger">*</sup></label>
                  <input type="text" name="name" value="<?php echo $editCategory['name'][$i] ?>" placeholder="Enter Attribute Name"  class="form-control mb-3" required  id="name">

                
                  <?php

                }
              }

              ?>
 
                <br>
              <input type="submit" name="submit" value="Update Attribute" class="btn btn-primary" id="">
              <a href="getAttributes" class="btn btn-danger">Cancel</a>

            </div>
          </div>
        </div>

      </form>
        
      
    </div>
    
  <!-- / Content -->

  <?php 
  }else{
    echo "Data Not Fetched";
  }
  
  require_once('footer.php');
  }else{
    header('location:login.php');
  }
}else{
  header('location:getCategories');
}
?>





            