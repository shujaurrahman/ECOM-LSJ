<?php 
session_start();
if(!empty($_SESSION['role']) ){
  $title="attribute";
require_once('header.php');

if(!empty($_POST['name'])  ){
    require_once('./logics.class.php');
    $adminObj = new logics();


    $verification = $adminObj->AddAttribute($_POST['name']);
    if(!empty($verification['status']) && $verification['status']==1){
        echo '<script src="../js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "success",
                title: "Attribute Successfully Added!",
                showConfirmButton: true,
            }).then(function() {
                window.location.href = "addAttribute";
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
                window.location.href = "addAttribute";
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
                <h5 class="card-title text-primary">Add Attribute</h5>
                <a href="./getAttributes" class="btn btn-sm btn-primary">View All Attributes</a>
                
              </div>
            </div>
          
          </div>
        </div>
      </div>
    </div>

    <form action="./addAttribute.php" method="post" enctype="multipart/form-data" class="row">
      
      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="card-body">
              <label for="name">Attribute Name<sup class="text-danger">*</sup></label>
              <input type="text" name="name" placeholder="Enter Attribute Name"  class="form-control mb-3" required  id="name">

              <br>
              <input type="submit" name="submit" value="Add Attribute" class="btn btn-primary" id="">
              

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





            