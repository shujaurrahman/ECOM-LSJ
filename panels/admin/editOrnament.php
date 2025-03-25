<?php 
session_start();
if(!empty($_GET['id'])){

  if(!empty($_SESSION['role']) ){
    $title="ornament";
  require_once('header.php');

  if(!empty($_POST['name']) && !empty($_POST['price'])  ){
    // print_r($_POST);
    //   die();
      require_once('./logics.class.php');
      $adminObj = new logics();

      

      $verification = $adminObj->UpdateOrnament($_POST['name'],$_POST['price'],$_POST['id']);
      
      if(!empty($verification['status']) && $verification['status']==1){
          echo '<script src="../js/sweetalert.js"></script>';
          echo '<script>';
          echo 'Swal.fire({
                  icon: "success",
                  title: "Ornament Successfully Updated!",
                  showConfirmButton: true,
              }).then(function() {
                  window.location.href = "getOrnaments";
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
                  window.location.href = "getOrnaments";
              });';
          echo '</script>';
      }
  }

  require_once('./logics.class.php');

  $obj = new logics();
  $editCategory = $obj->getOrnaments();

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
                  <h5 class="card-title text-primary">Add New Ornament</h5>
                  <a href="./getOrnaments" class="btn btn-sm btn-primary">View Added Ornaments</a>
                  
                </div>
              </div>
            
            </div>
          </div>
        </div>
      </div>

      <form action="./editOrnament?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" class="row">
        
        <div class="col-lg-12 mb-4 order-0">
          <div class="card">
            <div class="card-body">
              <?php
              for($i=0;$i<$editCategory['count'];$i++){
                if($editCategory['id'][$i] == $_GET['id']){
                  ?>
                  <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" id="">

                  

                  <label for="name">Ornament Name <sup class="text-danger">*</sup></label>
                  <input type="text" name="name" value="<?php echo $editCategory['name'][$i] ?>" placeholder="Enter Attribute Name"  class="form-control mb-3" required  id="name">
                  <label for="price">Product Price (Per Gram) <sup class="text-danger">*</sup></label>
                  <input type="number" name="price" value="<?php echo $editCategory['price'][$i] ?>" placeholder="Enter Attribute Name" step="0.01"  class="form-control mb-3" required  id="price">

                
                  <?php

                }
              }

              ?>
 
                <br>
              <input type="submit" name="submit" value="Update Ornament" class="btn btn-primary" id="">
              <a href="getOrnaments" class="btn btn-danger">Cancel</a>

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





            