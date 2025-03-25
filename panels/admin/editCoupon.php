<?php 
session_start();
if(!empty($_GET['id'])){

  if(!empty($_SESSION['role']) ){
    $title="coupon";
  require_once('header.php');

  if(!empty($_POST['coupon'])  &&  !empty($_POST['discount'])  &&  !empty($_POST['type'])  &&  !empty($_POST['expiry'])  ){
    // print_r($_POST);
    //   die();
      require_once('./logics.class.php');
      $adminObj = new logics();

      

      $verification = $adminObj->UpdateCoupon($_POST['coupon'],$_POST['discount'],$_POST['type'],$_POST['expiry'],$_POST['id']);
      
      if(!empty($verification['status']) && $verification['status']==1){
          echo '<script src="../js/sweetalert.js"></script>';
          echo '<script>';
          echo 'Swal.fire({
                  icon: "success",
                  title: "Coupon Successfully Updated!",
                  showConfirmButton: true,
              }).then(function() {
                  window.location.href = "getCoupons";
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
                  window.location.href = "getCoupons";
              });';
          echo '</script>';
      }
  }

  require_once('./logics.class.php');

  $obj = new logics();
  $editCategory = $obj->getCoupons();

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
                  <h5 class="card-title text-primary">Update Coupon</h5>
                  <a href="./getCoupons" class="btn btn-sm btn-primary">View Added Coupons</a>
                  
                </div>
              </div>
            
            </div>
          </div>
        </div>
      </div>

      <form action="./editCoupon?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" class="row">
        
        <div class="col-lg-12 mb-4 order-0">
          <div class="card">
            <div class="card-body">
              <?php
              for($i=0;$i<$editCategory['count'];$i++){
                if($editCategory['id'][$i] == $_GET['id']){
                  ?>
                  <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" id="">


                  <label for="category_name">Coupon Name<sup class="text-danger">*</sup></label>
                  <input type="text" name="coupon" placeholder="e.g., lsj100" value="<?php echo $editCategory['coupon'][$i] ?>"  class="form-control mb-3" required  id="category_name">

                  <label for="image">Enter Discount<sup class="text-danger">*</sup></label>
                  <input type="text" name="discount" placeholder="e.g., 20" value="<?php echo $editCategory['discount'][$i] ?>"  class="form-control mb-3" required  id="category_name">

                  <label for="image">Discount Type<sup class="text-danger">*</sup></label>
                  <select name="type" id="" class="form-select mb-3" required>
                    <option value="percentage" <?php echo $editCategory['type'][$i] == 'percentage' ? 'selected' : '' ?> >percentage</option>
                    <option value="flat" <?php echo $editCategory['type'][$i] == 'flat' ? 'selected' : '' ?> >flat</option>
                  </select>

                  <label for="image">Coupon Expiry<sup class="text-danger">*</sup></label>
                  <input type="datetime-local" value="<?php echo $editCategory['expiry'][$i] ?>" name="expiry" placeholder="e.g., 20"  class="form-control mb-3" required  id="category_name">


                  <?php

                }
              }

              ?>
 
                <br>
              <input type="submit" name="submit" value="Update Coupon" class="btn btn-primary" id="">
              <a href="getCoupons" class="btn btn-danger">Cancel</a>

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
  header('location:getCoupons');
}
?>





            