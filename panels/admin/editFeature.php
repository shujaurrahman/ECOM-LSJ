<?php 
session_start();
if(!empty($_GET['id'])){

  if(!empty($_SESSION['role']) ){
    $title="feature";
  require_once('header.php');

  if(!empty($_POST['name']) && isset($_FILES['featured_image'])  ){
      require_once('./logics.class.php');
      $adminObj = new logics();

      if(!empty($_FILES['featured_image']['name'])){
        if (!empty($_FILES['featured_image']['name'])) {
          $featured_imageName = $_FILES['featured_image']['name'];
          $featured_imageTempLocal = $_FILES['featured_image']['tmp_name'];
          
          // Append current date and time to the featured_image name to make it unique
          $timestamp = date("YmdHis");
          $extension = pathinfo($featured_imageName, PATHINFO_EXTENSION);
          $featured_imageName = pathinfo($featured_imageName, PATHINFO_FILENAME) . '_' . $timestamp . '.' . $extension;
  
          $featured_imageStore = "feature/" . $featured_imageName;
  
          // Move uploaded featured_image photo to desired directory
          move_uploaded_file($featured_imageTempLocal, $featured_imageStore);
  
          // Store featured_image photo name
          $featured_imagePhoto = $featured_imageName;
        }

      }else{
        $featured_imagePhoto = $_POST['existing_photo'];
      }

      

      $verification = $adminObj->UpdateFeature($_POST['name'],$featured_imagePhoto,$_POST['id']);
      
      if(!empty($verification['status']) && $verification['status']==1){
          echo '<script src="../js/sweetalert.js"></script>';
          echo '<script>';
          echo 'Swal.fire({
                  icon: "success",
                  title: "Feature Successfully Updated!",
                  showConfirmButton: true,
              }).then(function() {
                  window.location.href = "getFeatures";
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
                  window.location.href = "getFeatures";
              });';
          echo '</script>';
      }
  }

  require_once('./logics.class.php');

  $obj = new logics();
  $editCategory = $obj->getFeatures();

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
                  <h5 class="card-title text-primary">Add New Feature</h5>
                  <a href="./getFeatures" class="btn btn-sm btn-primary">View Added Features</a>
                  
                </div>
              </div>
            
            </div>
          </div>
        </div>
      </div>

      <form action="./editFeature?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" class="row">
        
        <div class="col-lg-12 mb-4 order-0">
          <div class="card">
            <div class="card-body">
              <?php
              for($i=0;$i<$editCategory['count'];$i++){
                if($editCategory['id'][$i] == $_GET['id']){
                  ?>
                  <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" id="">
                  <input type="hidden" name="existing_photo" value="<?php echo $editCategory['image'][$i] ?>" id="">

                  

                  <label for="name">Feature Name <sup class="text-danger">*</sup></label>
                  <input type="text" name="name" value="<?php echo $editCategory['name'][$i] ?>" placeholder="Enter Attribute Name"  class="form-control mb-3" required  id="name">
                  <label for="featured_image">Featured Icon <sup class="text-danger">*</sup></label>
                  <input type="file" name="featured_image"  placeholder="Enter Attribute Name"   class="form-control mb-3"  id="featured_image">
                  <img src="./feature/<?php echo $editCategory['image'][$i] ?>"  width="100px" alt="">
                  <br>

                
                  <?php

                }
              }

              ?>
 
                <br>
              <input type="submit" name="submit" value="Update Feature" class="btn btn-primary" id="">
              <a href="getFeatures" class="btn btn-danger">Cancel</a>

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





            