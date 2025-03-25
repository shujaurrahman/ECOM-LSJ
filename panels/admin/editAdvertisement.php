<?php 
session_start();
if(!empty($_GET['id'])){

  if(!empty($_SESSION['role']) ){
    $title="advertisement";
  require_once('header.php');

  if(!empty($_POST['category_name']) && isset($_FILES['featured_image']) &&  !empty($_POST['description'])  &&  !empty($_POST['url'])  &&  !empty($_POST['location'])  ){
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
  
          $featured_imageStore = "advertisements/" . $featured_imageName;
  
          // Move uploaded featured_image photo to desired directory
          move_uploaded_file($featured_imageTempLocal, $featured_imageStore);
  
          // Store featured_image photo name
          $featured_imagePhoto = $featured_imageName;
        }

      }else{
        $featured_imagePhoto = $_POST['existing_photo'];
      }

      

      $verification = $adminObj->UpdateAdvertisement($_POST['category_name'],$featured_imagePhoto,$_POST['description'],$_POST['url'],$_POST['location'],$_POST['id']);
      
      if(!empty($verification['status']) && $verification['status']==1){
          echo '<script src="../js/sweetalert.js"></script>';
          echo '<script>';
          echo 'Swal.fire({
                  icon: "success",
                  title: "Advertisements Successfully Updated!",
                  showConfirmButton: true,
              }).then(function() {
                  window.location.href = "getAdvertisements";
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
                  window.location.href = "getAdvertisements";
              });';
          echo '</script>';
      }
  }

  require_once('./logics.class.php');

  $obj = new logics();
  $editCategory = $obj->getAdvertisements();

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
                  <h5 class="card-title text-primary">Update Advertisement</h5>
                  <a href="./getAdvertisements" class="btn btn-sm btn-primary">View Added Advertisements</a>
                  
                </div>
              </div>
            
            </div>
          </div>
        </div>
      </div>

      <form action="./editAdvertisement?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" class="row">
        
        <div class="col-lg-12 mb-4 order-0">
          <div class="card">
            <div class="card-body">
              <?php
              for($i=0;$i<$editCategory['count'];$i++){
                if($editCategory['id'][$i] == $_GET['id']){
                  ?>
                  <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" id="">

                  <input type="hidden" name="existing_photo" value="<?php echo $editCategory['image'][$i] ?>" id="">

                  <label for="category_name">Advertisement Name <sup class="text-danger">*</sup></label>
                  <input type="text" name="category_name" value="<?php echo $editCategory['name'][$i] ?>" placeholder="Enter Advertisement Name"  class="form-control mb-3" required  id="category_name">

                  <label for="image">Advertisement Reference Image</label>
                  <input type="file" name="featured_image" placeholder="Enter Category Name"  class="form-control mb-3"  id="image">
                  
                  <img src="./advertisements/<?php echo $editCategory['image'][$i] ?>" width="100px" alt="">
                  <br><br>

                  <label for="description">Advertisement Short Description<sup class="text-danger">*</sup></label>
                  <input type="text" name="description" placeholder="Ex. Save upto 20%"  class="form-control mb-3"  id="image" value="<?php echo $editCategory['description'][$i] ?>">

                  <label for="url">Advertisement URL<sup class="text-danger">*</sup></label>
                  <input type="text" name="url" placeholder="url"  class="form-control mb-3"  id="image" value="<?php echo $editCategory['url'][$i] ?>">

                  <label for="url">Select Advertisement Location<sup class="text-danger">*</sup></label>
                  <select name="location" id="location" class="form-control" required>
                    <option value="">-Select Location-</option>
                    <option value="1" <?php echo $editCategory['location'][$i] ==1 ? "selected" : "" ?>>Top1</option>
                    <option value="2" <?php echo $editCategory['location'][$i] ==2 ? "selected" : "" ?>>Top2</option>
                    <option value="3" <?php echo $editCategory['location'][$i] ==3 ? "selected" : "" ?>>Middle1</option>
                    <option value="4" <?php echo $editCategory['location'][$i] ==4 ? "selected" : "" ?>>Middle2</option>
                  </select>


                  <?php

                }
              }

              ?>
 
                <br>
              <input type="submit" name="submit" value="Update Advertisement" class="btn btn-primary" id="">
              <a href="getAdvertisements" class="btn btn-danger">Cancel</a>

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
  header('location:getAdvertisements');
}
?>





            