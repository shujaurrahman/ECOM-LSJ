<?php 
session_start();
if(!empty($_SESSION['role']) ){
  $title="feature";
require_once('header.php');

if(!empty($_POST['name']) && !empty($_FILES['featured_image'])  ){
    require_once('./logics.class.php');
    $adminObj = new logics();

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


    $verification = $adminObj->AddFeature($_POST['name'],$featured_imagePhoto);
    if(!empty($verification['status']) && $verification['status']==1){
        echo '<script src="../js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "success",
                title: "Feature Successfully Added!",
                showConfirmButton: true,
            }).then(function() {
                window.location.href = "addFeature";
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
                window.location.href = "addFeature";
            });';
        echo '</script>';
    }
}
 ?>
<!--  Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="d-flex align-items-end row">
            <div class="col-sm-12">
              <div class="card-body d-flex justify-content-between">
                <h5 class="card-title text-primary">Add Feature</h5>
                <a href="./getFeatures" class="btn btn-sm btn-primary">View All Features</a>
                
              </div>
            </div>
          
          </div>
        </div>
      </div>
    </div>

    <form action="./addFeature.php" method="post" enctype="multipart/form-data" class="row">
      
      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="card-body">
              <label for="name">Feature Name<sup class="text-danger">*</sup></label>
              <input type="text" name="name" placeholder="e.g., Free Cancellation"  class="form-control mb-3" required  id="name">
              <label for="featured_image">Feature Icon<sup class="text-danger">*</sup></label>
              <input type="file" name="featured_image" placeholder="Enter Price (For 1 Gram)"  class="form-control mb-3" required  id="featured_image"  />

              <br>
              <input type="submit" name="submit" value="Add Feature" class="btn btn-primary" id="">
            
          </div>
        </div>
      </div>

    </form>
      
    
  </div>
  
<!-- / Content -->

<?php 
require_once('footer.php');
}else{
  header('location:login.php');
}
?>





            