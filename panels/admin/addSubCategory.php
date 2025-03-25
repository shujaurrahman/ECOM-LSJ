<?php 
session_start();
if(!empty($_SESSION['role']) ){
  $title="subcategory";
require_once('header.php');

require_once('./logics.class.php');
    $Obj = new logics();

    $category = $Obj->getCategories();



if(!empty($_POST['category_id']) && !empty($_POST['subcategory_name']) && !empty($_FILES['featured_image']) &&  !empty($_POST['description'])  ){
    require_once('./logics.class.php');
    $adminObj = new logics();

    if (!empty($_FILES['featured_image']['name'])) {
      $featured_imageName = $_FILES['featured_image']['name'];
      $featured_imageTempLocal = $_FILES['featured_image']['tmp_name'];
      
      // Append current date and time to the featured_image name to make it unique
      $timestamp = date("YmdHis");
      $extension = pathinfo($featured_imageName, PATHINFO_EXTENSION);
      $featured_imageName = pathinfo($featured_imageName, PATHINFO_FILENAME) . '_' . $timestamp . '.' . $extension;

      $featured_imageStore = "subcategory/" . $featured_imageName;

      // Move uploaded featured_image photo to desired directory
      move_uploaded_file($featured_imageTempLocal, $featured_imageStore);

      // Store featured_image photo name
      $featured_imagePhoto = $featured_imageName;
    }

    $verification = $adminObj->AddSubCategory($_POST['category_id'],$_POST['subcategory_name'],$featured_imagePhoto,$_POST['description']);
    if(!empty($verification['status']) && $verification['status']==1){
        echo '<script src="../js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "success",
                title: "Sub-Category Successfully Added!",
                showConfirmButton: true,
            }).then(function() {
                window.location.href = "addSubCategory";
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
                window.location.href = "addSubCategory";
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
                <h5 class="card-title text-primary">Add Sub-Category</h5>
                <a href="./getSubCategories" class="btn btn-sm btn-primary">View All Sub-Categories</a>
                
              </div>
            </div>
          
          </div>
        </div>
      </div>
    </div>

    <form action="./addSubCategory" method="post" enctype="multipart/form-data" class="row">
      
      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="card-body">
              <label for="category_id">Select Category<sup class="text-danger">*</sup></label>
              <select name="category_id" id="category_id" class="form-control">
                <option value="">-Category-</option>
                <?php
                for($i=0;$i<$category['count'];$i++){
                  ?>
                  <option value="<?php echo $category['id'][$i] ?>"><?php echo $category['name'][$i] ?></option>
                  <?php
                }

                ?>
              </select>


              <label for="subcategory_name">Sub Category Name<sup class="text-danger">*</sup></label>
              <input type="text" name="subcategory_name" placeholder="Enter Sub Category Name"  class="form-control mb-3" required  id="subcategory_name">

              <label for="image">Sub Category Reference Image<sup class="text-danger">*</sup></label>
              <input type="file" name="featured_image" placeholder="Enter Category Name"  class="form-control mb-3" required  id="image">

              <label for="description">Sub Category Short Description<sup class="text-danger">*</sup></label>
              <textarea name="description" class="form-control" rows="5" required placeholder="Sub Category Description .." id="description"></textarea>

              <br>
              <input type="submit" name="submit" value="Add Sub Category" class="btn btn-primary" id="">
              

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





            