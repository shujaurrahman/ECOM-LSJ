<?php 
session_start();
if(!empty($_SESSION['role']) ){
  $title="coupon";
require_once('header.php');

if(!empty($_POST['coupon']) &&  !empty($_POST['discount']) &&  !empty($_POST['type']) &&  !empty($_POST['expiry'])  ){
    require_once('./logics.class.php');
    $adminObj = new logics();

    $verification = $adminObj->AddCoupon($_POST['coupon'],$_POST['discount'],$_POST['type'],$_POST['expiry']);
    if(!empty($verification['status']) && $verification['status']==1){
        echo '<script src="../js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "success",
                title: "Coupon Successfully Added!",
                showConfirmButton: true,
            }).then(function() {
                window.location.href = "addCoupon";
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
                window.location.href = "addCoupon";
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
                <h5 class="card-title text-primary">Add Coupon</h5>
                <a href="./getCoupons" class="btn btn-sm btn-primary">View All Coupons</a>
                
              </div>
            </div>
          
          </div>
        </div>
      </div>
    </div>

    <form action="./addCoupon.php" method="post" enctype="multipart/form-data" class="row">
      
      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="card-body">
              <label for="category_name">Coupon Name<sup class="text-danger">*</sup></label>
              <input type="text" name="coupon" placeholder="e.g., lsj100"  class="form-control mb-3" required  id="category_name">

              <label for="image">Enter Discount<sup class="text-danger">*</sup></label>
              <input type="text" name="discount" placeholder="e.g., 20"  class="form-control mb-3" required  id="category_name">

              <label for="image">Discount Type<sup class="text-danger">*</sup></label>
              <select name="type" id="" class="form-select mb-3" required>
                <option value="percentage">percentage</option>
                <option value="flat">flat</option>
              </select>

              <label for="image">Coupon Expiry<sup class="text-danger">*</sup></label>
              <input type="datetime-local" name="expiry" placeholder="e.g., 20"  class="form-control mb-3" required  id="category_name">



              <br>
              <input type="submit" name="submit" value="Add Coupon" class="btn btn-primary" id="">
              

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





            