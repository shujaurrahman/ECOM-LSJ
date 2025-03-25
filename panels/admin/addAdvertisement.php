<?php 
session_start();
if(!empty($_SESSION['role']) ){
  $title="advertisement";
require_once('header.php');

if(!empty($_POST['category_name']) && !empty($_FILES['featured_image']) &&  !empty($_POST['description']) &&  !empty($_POST['url'])  &&  !empty($_POST['location'])  ){
    require_once('./logics.class.php');
    $adminObj = new logics();

    if (!empty($_FILES['featured_image']['name'])) {
      $featured_imageName = $_FILES['featured_image']['name'];
      $featured_imageTempLocal = $_FILES['featured_image']['tmp_name'];
      
      // Append current date and time to the featured_image name to make it unique
      $timestamp = date("YmdHis");
      $extension = pathinfo($featured_imageName, PATHINFO_EXTENSION);
      $featured_imageName = pathinfo($featured_imageName, PATHINFO_FILENAME) . '_' . $timestamp . '.' . $extension;

      $featured_imageStore = "advertisements/" . $featured_imageName;

      // Move uploaded featured_image photo to desired directory
      move_uploaded_file($featured_imageTempLocal, $featured_imageStore);

      // Store featured_image photo name
      $featured_imagePhoto = $featured_imageName;
    }

    $verification = $adminObj->AddAdvertisement($_POST['category_name'],$featured_imagePhoto,$_POST['description'],$_POST['url'],$_POST['location']);
    if(!empty($verification['status']) && $verification['status']==1){
        echo '<script src="../js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "success",
                title: "Advertisement Successfully Added!",
                showConfirmButton: true,
            }).then(function() {
                window.location.href = "addAdvertisement";
            });';
        echo '</script>';
    }else{
        echo '<script src="../js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "error",
                title: "Data not Submitted!",5
                text: "Please try again"
            }).then(function() {
                window.location.href = "addAdvertisement";
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
                <h5 class="card-title text-primary">Add Advertisements</h5>
                <a href="./getAdvertisements" class="btn btn-sm btn-primary">View All Advertisements</a>
                
              </div>
            </div>
          
          </div>
        </div>
      </div>
    </div>

    <form action="./addAdvertisement.php" method="post" enctype="multipart/form-data" class="row">
      
      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="card-body">
              <label for="category_name">Advertisement Name<sup class="text-danger">*</sup></label>
              <input type="text" name="category_name" placeholder="Enter Advertisement Name"  class="form-control mb-3" required  id="category_name">

              <label for="image">Advertisement Reference Image<sup class="text-danger">*</sup></label>
              <input type="file" name="featured_image" placeholder="Enter Category Name"  class="form-control mb-3" required  id="image">

              <label for="description">Advertisement Short Description<sup class="text-danger">*</sup></label>
              <textarea name="description" class="form-control" rows="5" required placeholder="ex. Save Upto 10% .." id="description"></textarea>

              <label for="url">Advertisement URL<sup class="text-danger">*</sup></label>
              <input type="text" name="url" placeholder="url"  class="form-control mb-3"  id="image">

              <label for="url">Select Advertisement Location<sup class="text-danger">*</sup></label>
              <select name="location" id="location" class="form-control" required>
                <option value="">-Select Location-</option>
                <option value="1">Top1</option>
                <option value="2">Top2</option>
                <option value="3">Middle1</option>
                <option value="4">Middle2</option>
              </select>

              <br>
              <input type="submit" name="submit" value="Add Advertisement" class="btn btn-primary" id="">
              

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





            