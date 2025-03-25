<?php 
session_start();
if(!empty($_GET['id'])){

  if(!empty($_SESSION['role']) ){
    $title="subcategory";
  require_once('header.php');

  if( !empty($_POST['category_id']) && !empty($_POST['subcategory_name']) && isset($_FILES['featured_image']) &&  !empty($_POST['description'])  ){
    // print_r($_POST);
    //   die();
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
  
          $featured_imageStore = "subcategory/" . $featured_imageName;
  
          // Move uploaded featured_image photo to desired directory
          move_uploaded_file($featured_imageTempLocal, $featured_imageStore);
  
          // Store featured_image photo name
          $featured_imagePhoto = $featured_imageName;
        }

      }else{
        $featured_imagePhoto = $_POST['existing_photo'];
      }

      

      $verification = $adminObj->UpdateSubCategory($_POST['category_id'],$_POST['subcategory_name'],$featured_imagePhoto,$_POST['description'],$_POST['id']);
      
      if(!empty($verification['status']) && $verification['status']==1){
          echo '<script src="../js/sweetalert.js"></script>';
          echo '<script>';
          echo 'Swal.fire({
                  icon: "success",
                  title: "Sub Category Successfully Updated!",
                  showConfirmButton: true,
              }).then(function() {
                  window.location.href = "getSubCategories";
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
                  window.location.href = "getSubCategories1";
              });';
          echo '</script>';
      }
  }

  require_once('./logics.class.php');

  $obj = new logics();
  $editSubCategory = $obj->getSubCategories();

  $allCategory = $obj->getCategories();

  if (!empty($editSubCategory['status']) && $editSubCategory['status'] == 1) {
  ?>
  <!--  Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="row">
        <div class="col-lg-12 mb-4 order-0">
          <div class="card">
            <div class="d-flex align-items-end row">
              <div class="col-sm-12">
                <div class="card-body d-flex justify-content-between">
                  <h5 class="card-title text-primary">Add New Sub Category</h5>
                  <a href="./getSubCategories" class="btn btn-sm btn-primary">View Added Sub Categories</a>
                </div>
              </div>
            
            </div>
          </div>
        </div>
      </div>

      <form action="./editSubCategory?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" class="row">
        
        <div class="col-lg-12 mb-4 order-0">
          <div class="card">
            <div class="card-body">
              <?php
              for($i=0;$i<$editSubCategory['count'];$i++){
                if($editSubCategory['id'][$i] == $_GET['id']){
                  ?>
                  <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" id="">

                  <input type="hidden" name="existing_photo" value="<?php echo $editSubCategory['image'][$i] ?>" id="">

                  <label for="category_id">Select Category<sup class="text-danger">*</sup></label>
                  <select name="category_id" id="category_id" class="form-control">
                    <option value="">-Category-</option>
                    <?php
                    for($j=0;$j<$allCategory['count'];$j++){
                      ?>
                      <option value="<?php echo $allCategory['id'][$j] ?>" <?php if($allCategory['id'][$j] == $editSubCategory['category_id'][$i]){ echo "selected"; } ?>><?php echo $allCategory['name'][$j] ?></option>
                      <?php
                    }
                    ?>
                  </select>

                  <label for="category_name">Sub Category Name <sup class="text-danger">*</sup></label>
                  <input type="text" name="subcategory_name" value="<?php echo $editSubCategory['name'][$i] ?>" placeholder="Enter Category Name"  class="form-control mb-3" required  id="category_name">

                  <label for="image">Sub Category Reference Image</label>
                  <input type="file" name="featured_image" placeholder="Enter Category Name"  class="form-control mb-3"  id="image">
                  
                  <img src="./subcategory/<?php echo $editSubCategory['image'][$i] ?>" width="100px" alt="">
                  <br><br>

                  <label for="description">Sub Category Short Description<sup class="text-danger">*</sup></label>
                  <textarea name="description" class="form-control" rows="5" required placeholder="Category Description .." id="description"><?php echo $editSubCategory['description'][$i] ?></textarea>


                  <?php

                }
              }

              ?>
 
                <br>
              <input type="submit" name="submit" value="Update Category" class="btn btn-primary" id="">
              <a href="getSubCategories" class="btn btn-danger">Cancel</a>

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
  header('location:getSubCategories');
}
?>





            