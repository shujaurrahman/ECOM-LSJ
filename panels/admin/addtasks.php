<?php 
session_start();
if(!empty($_SESSION['role'])){
  $title="addtasks";
require_once('header.php');

if(!empty($_POST['task_date']) && !empty($_POST['domain']) &&  !empty($_POST['task_name']) && !empty($_POST['task_description']) && !empty($_POST['tasks'])  ){
    require_once('./logics.class.php');
    $adminObj = new logics();

    $verification = $adminObj->AddTasks($_POST['task_date'],$_POST['domain'],$_POST['task_name'],$_POST['task_description'],$_POST['tasks']);
    if(!empty($verification['status']) && $verification['status']==1){
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "success",
                title: "Task Successfully Submitted!",
                showConfirmButton: true,
            }).then(function() {
                window.location.href = "addtasks";
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
                window.location.href = "addtasks";
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
                <h5 class="card-title text-primary">Add Tasks for  Everyday ...!</h5>
                <a href="./addedtasks.php" class="btn btn-sm btn-primary">View Added Tasks</a>
                
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
                 <form action="./addtasks.php" method="post" enctype="multipart/form-data">

                    <input type="date" name="task_date" placeholder="Task Date"  class="form-control mb-3" required id="">
                    
                    <select name="domain" class="form-select mb-3" required id="">
                        <option value="">-Select Domain-</option>
                        <option value="web">Web Development</option>
                        <option value="java">Java Development</option>
                        <option value="android">Android Development</option>
                    </select>
                  
                    <input type="text" name="task_name" placeholder="Enter Task Name"  class="form-control mb-3" required id="">

                    <textarea name="task_description" placeholder="Task Description* " rows="8" class="form-control mb-3" id="description"></textarea>
                    <br>

                    <textarea name="tasks" placeholder="Tasks* " rows="8" class="form-control mb-3" id="tasks"></textarea>
                    <br>

                    
                    <br>
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

<!-- Include CKEditor script -->
<script src="https://cdn.ckeditor.com/4.22.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('task_description', {
        height: 300
    });
    CKEDITOR.replace('tasks', {
        height: 300
    });
</script>


            