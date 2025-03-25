<?php 
session_start();
if(!empty($_SESSION['role']) ){
  $title="category";
require_once('header.php');

if(!empty($_POST['category_name']) && !empty($_FILES['featured_image']) &&  !empty($_POST['description'])  ){
    require_once('./logics.class.php');
    $adminObj = new logics();

    if (!empty($_FILES['featured_image']['name'])) {
      $featured_imageName = $_FILES['featured_image']['name'];
      $featured_imageTempLocal = $_FILES['featured_image']['tmp_name'];
      
      // Append current date and time to the featured_image name to make it unique
      $timestamp = date("YmdHis");
      $extension = pathinfo($featured_imageName, PATHINFO_EXTENSION);
      $featured_imageName = pathinfo($featured_imageName, PATHINFO_FILENAME) . '_' . $timestamp . '.' . $extension;

      $featured_imageStore = "category/" . $featured_imageName;

      // Move uploaded featured_image photo to desired directory
      move_uploaded_file($featured_imageTempLocal, $featured_imageStore);

      // Store featured_image photo name
      $featured_imagePhoto = $featured_imageName;
    }

    $verification = $adminObj->AddCategory($_POST['category_name'],$featured_imagePhoto,$_POST['description']);
    if(!empty($verification['status']) && $verification['status']==1){
        echo '<script src="../js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "success",
                title: "Category Successfully Added!",
                showConfirmButton: true,
            }).then(function() {
                window.location.href = "addCategory";
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
                window.location.href = "addCategory";
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
                <h5 class="card-title text-primary">Add Category</h5>
                <a href="./getCategories" class="btn btn-sm btn-primary">View All Categories</a>
                
              </div>
            </div>
          
          </div>
        </div>
      </div>
    </div>

    <form action="./addCategory.php" method="post" enctype="multipart/form-data" class="row">
      
      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="card-body">
              <label for="category_name">Category Name<sup class="text-danger">*</sup></label>
              <input type="text" name="category_name" placeholder="Enter Category Name"  class="form-control mb-3" required  id="category_name">

              <label for="image">Category Reference Image<sup class="text-danger">*</sup></label>
              <input type="file" name="featured_image" placeholder="Enter Category Name"  class="form-control mb-3" required  id="image">

              <label for="description">Category Short Description<sup class="text-danger">*</sup></label>
              <textarea name="description" class="form-control" rows="5" required placeholder="Category Description .." id="description"></textarea>

              <br>
              <input type="submit" name="submit" value="Add Category" class="btn btn-primary" id="">
              

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





            