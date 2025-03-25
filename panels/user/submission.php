<?php 
session_start();
if(!empty($_SESSION['username'])){
  $title="submission";
require_once('header.php');

if(!empty($_POST['user_id']) && !empty($_POST['task']) && !empty($_POST['url']) && !empty($_POST['doubts']) ){
    require_once('./logics.class.php');
    $adminObj = new logics();
    $verification = $adminObj->SubmitTask($_POST['user_id'],$_POST['task'],$_POST['url'],$_POST['doubts']);
    if(!empty($verification['status']) && $verification['status']==1){
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "success",
                title: "Task Successfully Submitted!",
                showConfirmButton: true,
            }).then(function() {
                window.location.href = "submission";
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
                window.location.href = "submission";
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
            <div class="col-sm-7">
              <div class="card-body">
                <h5 class="card-title text-primary">Submit Your Task On time ...!</h5>
                
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
                 <form action="./submission.php" method="post">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['id'] ?>" id="">
                    <input type="text" name="date" value="<?php echo date("d-m-Y").' ('.date("l").')' ?>"  class="form-control mb-3" required readonly id="">
                    <input type="text" name="task" placeholder="Enter Task Name*" class="form-control mb-3" required id="">
                    <input type="url" name="url" placeholder="Paste LinkedIn Task Submission Link*" class="form-control mb-3" required id="">
                    <textarea name="doubts" placeholder="Describe Your Doubts.. (Optional)" rows="8" class="form-control mb-3" id=""></textarea>
                    <input type="submit" name="submit" value="Submit Task" class="btn btn-primary" id="">
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

            