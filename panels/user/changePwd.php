<?php 
session_start();
if(!empty($_SESSION['username'])){
  $title="changePwd";
require_once('header.php');

if(!empty($_POST['current_pass']) && !empty($_POST['new_password']) && !empty($_POST['reenter_password']) ){
    if($_SESSION['password'] == $_POST['current_pass']){
        if($_POST['new_password'] == $_POST['reenter_password']){
            require_once('./logics.class.php');
            $changepwdObj = new logics();
            $verification = $changepwdObj->changepwd($_SESSION['id'],$_POST['new_password']);
            if(!empty($verification['status']) && $verification['status']==1){
                $_SESSION['password']=$_POST['new_password'];
                $succ = "Password Successfully Changed";
            }else{
                $err = "Password Not changed, Please try again";
            }
            }else{
                $err = "new password and reentered password doesnot match";
            }
    }else{
        $err = "Invalid Current password";
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
              <div class="card-body">
                <h5 class="card-title text-primary">Change Password</h5>
                <?php
                if(!empty($err)){
                    echo "<div class='alert alert-danger'>$err</div>";
                }
                if(!empty($succ)){
                    echo "<div class='alert alert-success'>$succ</div>";
                }
                ?>
                <form action="changepwd.php" method="post" class="form-control">
                    <label for="Username">current password</label>
                    <input type="text" name="current_pass" placeholder="Enter current Password" class="form-control" required>
                    <label for="password">new Password</label>
                    <input type="password" name="new_password" placeholder="Create new  password" class="form-control" required>
                    <label for="password">Re-enter Password</label>
                    <input type="password" name="reenter_password" placeholder="Re-Enter new  password" class="form-control" required>
                    <br>
                    <center><input type="submit" name="Update" value="Change Password" class="btn btn-primary"></center>
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

            