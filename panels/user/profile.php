<?php 
session_start();
if(!empty($_SESSION['username'])){
  $title="profile";
  require_once('header.php');
  require_once('./logics.class.php');
  
  $getProfile = new logics();
  $verification = $getProfile->getProfile($_SESSION['id']);
  
  if(!empty($verification['status']) && $verification['status'] == 1){
    $_SESSION['profile']=$verification['profile'];
  } else {
    echo "data not Fetched";
  }

  if (!empty($_POST['mobile']) && !empty($_POST['college']) && !empty($_POST['dept']) && !empty($_POST['yop']) && !empty($_POST['address'])) {
    $profilePhoto = $verification['profile']; // Existing profile photo

    if (!empty($_FILES['profile']['name'])) {
      $profileName = $_FILES['profile']['name'];
      $profileTempLocal = $_FILES['profile']['tmp_name'];
      
      // Append current date and time to the profile name to make it unique
      $timestamp = date("YmdHis");
      $extension = pathinfo($profileName, PATHINFO_EXTENSION);
      $profileName = pathinfo($profileName, PATHINFO_FILENAME) . '_' . $timestamp . '.' . $extension;

      $profileStore = "DBimages/" . $profileName;

      // Move uploaded profile photo to desired directory
      move_uploaded_file($profileTempLocal, $profileStore);

      // Store profile photo name
      $profilePhoto = $profileName;
    }

    $contactObj = new logics();
    $verification = $contactObj->updateProfile(
        $_POST['mobile'],
        $_POST['college'],
        $_POST['dept'],
        $_POST['yop'],
        $_POST['address'],
        $profilePhoto,
        $_SESSION['id']
    );

    if (!empty($verification['status']) && $verification['status'] == 1) {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "success",
                title: "Your Profile Successfully Updated!",
                showConfirmButton: true,
            }).then(function() {
                window.location.href = "profile";
            });';
        echo '</script>';
    } else {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "error",
                title: "Data not Updated!",
                text: "Please try again"
            }).then(function() {
                window.location.href = "profile";
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
            <div class="card-body">
              <h5 class="card-title text-primary">Update Your Profile</h5>
              <form action="./profile.php" method="post" enctype="multipart/form-data" class="p-3">
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="mobile" class="form-label">Student ID <sup class="text-danger">*</sup></label>
                    <input type="text" class="form-control" value="<?php echo $_SESSION['stud_id']; ?>" readonly id="mobile" name="name" placeholder="Enter Mobile Number" required>
                  </div>
                  <div class="col-md-6">
                    <label for="college" class="form-label">Student Name <sup class="text-danger">*</sup></label>
                    <input type="text" class="form-control" value="<?php echo $_SESSION['username']; ?>" id="college" readonly name="email" placeholder="Enter College Name" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="mobile" class="form-label">Email <sup class="text-danger">*</sup></label>
                    <input type="text" class="form-control" value="<?php echo $_SESSION['email']; ?>" readonly id="mobile" name="name" placeholder="Enter Mobile Number" required>
                  </div>
                  <div class="col-md-6">
                    <label for="college" class="form-label">Selected Domain <sup class="text-danger">*</sup></label>
                    <input type="text" class="form-control" value="<?php echo $_SESSION['domain']; ?>" id="college" readonly name="email" placeholder="Enter College Name" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="mobile" class="form-label">Mobile Number <sup class="text-danger">*</sup></label>
                    <input type="text" class="form-control" value="<?php echo $verification['mobile']; ?>" id="mobile" name="mobile" placeholder="Enter Mobile Number" required>
                  </div>
                  <div class="col-md-6">
                    <label for="college" class="form-label">College <sup class="text-danger">*</sup></label>
                    <input type="text" class="form-control" value="<?php echo $verification['college']; ?>" id="college" name="college" placeholder="Enter College Name" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="dept" class="form-label">Department <sup class="text-danger">*</sup></label>
                    <input type="text" class="form-control" value="<?php echo $verification['dept']; ?>" id="dept" name="dept" placeholder="Enter Department" required>
                  </div>
                  <div class="col-md-6">
                    <label for="yop" class="form-label">Year of Passing <sup class="text-danger">*</sup></label>
                    <input type="text" class="form-control" value="<?php echo $verification['yop']; ?>" id="yop" name="yop" placeholder="Enter Year of Passing" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-12">
                    <label for="address" class="form-label">Address <sup class="text-danger">*</sup></label>
                    <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter Your Address" required><?php echo $verification['address']; ?></textarea>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-12">
                    <label for="profile" class="form-label">Upload Profile Photo</label>
                    <input type="file" class="form-control" id="profile" name="profile" accept="image/*">
                    <div class="mt-3">
                      <?php if(!empty($verification['profile'])): ?>
                        <img src="DBimages/<?php echo $verification['profile']; ?>" alt="Profile Photo" style="width: 100px; height: 100px; object-fit: cover;">
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
                <div class="row mb-3 text-center">
                  <div class="col-md-12">
                    <button type="submit" class="btn btn-primary" role="button">Update your Profile</button>
                  </div>
                </div>
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
