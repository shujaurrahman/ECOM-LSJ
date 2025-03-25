<?php 
session_start();
if(!empty($_SESSION['role']) ){
  $title="ornament";
require_once('header.php');

if(!empty($_POST['name']) && !empty($_POST['price'])  ){
    require_once('./logics.class.php');
    $adminObj = new logics();


    $verification = $adminObj->AddOrnament($_POST['name'],$_POST['price']);
    if(!empty($verification['status']) && $verification['status']==1){
        echo '<script src="../js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "success",
                title: "Ornament Successfully Added!",
                showConfirmButton: true,
            }).then(function() {
                window.location.href = "addOrnament";
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
                window.location.href = "addOrnament";
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
                <h5 class="card-title text-primary">Add Ornament</h5>
                <a href="./getOrnaments" class="btn btn-sm btn-primary">View All Ornaments</a>
                
              </div>
            </div>
          
          </div>
        </div>
      </div>
    </div>

    <form action="./addOrnament.php" method="post" enctype="multipart/form-data" class="row">
      
      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="card-body">
              <label for="name">Ornament Name<sup class="text-danger">*</sup></label>
              <input type="text" name="name" placeholder="e.g., Gold (22K)"  class="form-control mb-3" required  id="name">
              <label for="price">Product Price (Per Gram)<sup class="text-danger">*</sup></label>
              <input type="number" name="price" placeholder="Enter Price (For 1 Gram)"  class="form-control mb-3" required  id="price" step="0.01" />

              <br>
              <input type="submit" name="submit" value="Add Ornament" class="btn btn-primary" id="">
            
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





            