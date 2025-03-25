<?php 
session_start();
if(!empty($_SESSION['role'])){
  $title="students";
require_once('header.php');

if(!empty($_POST['student_id']) && !empty($_POST['name']) &&  !empty($_POST['email']) && !empty($_POST['domain'])  ){
    require_once('./logics.class.php');
    $adminObj = new logics();

    $verification = $adminObj->AddStudents($_POST['student_id'],$_POST['name'],$_POST['email'],$_POST['domain']);
    if(!empty($verification['status']) && $verification['status']==1){
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "success",
                title: "Student Successfully Submitted!",
                showConfirmButton: true,
            }).then(function() {
                window.location.href = "addstudents";
            });';
        echo '</script>';
    }else{
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "error",
                title: "Data not Submitted!",
                text: "Please try again"
            }).then(function() {
                window.location.href = "addstudents";
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
                <h5 class="card-title text-primary">Add Students ...!</h5>
                <a href="./addedstudents.php" class="btn btn-sm btn-primary">View Added Students</a>
                
              </div>
            </div>
          
          </div>
        </div>
      </div>
      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="d-flex align-items-end row">
            <div class="col-sm-12">
              <div class="card-body">
                <!-- <h5 class="card-title text-primary">Instructions to Use the Portal</h5> -->
                 <form action="./addstudents.php" method="post" enctype="multipart/form-data">

                    <input type="text" name="student_id" placeholder="e.g., PTE07W24001"  class="form-control mb-3" required id="">

                    <input type="text" name="name" placeholder="Enter Student Name"  class="form-control mb-3" required id="">
                    <input type="email" name="email" placeholder="Student Mail Address"  class="form-control mb-3" required id="">

                    
                    <select name="domain" class="form-select mb-3" required id="">
                        <option value="">-Select Domain-</option>
                        <option value="web">Web Development</option>
                        <option value="java">Java Development</option>
                        <option value="android">Android Development</option>
                    </select>
                

                    
                    <br>
                    <input type="submit" name="submit" value="Add Student" class="btn btn-primary" id="">
                 </form>
                

                
              </div>
            </div>
          
          </div>
        </div>
      </div>
      
    </div>
  </div>
  
<!-- / Content -->

<?php 
require_once('footer.php');
}else{
  header('location:login.php');
}
?>



            