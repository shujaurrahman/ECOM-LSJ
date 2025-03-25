<?php 
session_start();
if(!empty($_SESSION['username'])){
  $title="profile";
  require_once('header.php');

  require_once('./logics.class.php');
  $getProfile = new logics();
  $verification = $getProfile->getProfile($_SESSION['id']);
  if(!empty($verification['status']) && $verification['status']==1){
    
  } else {
    echo "data not Fetched";
  }

  if (
    !empty($_POST['name']) && 
    !empty($_POST['children']) && 
    !empty($_POST['father']) && 
    !empty($_POST['mother']) && 
    !empty($_POST['email']) && 
    !empty($_POST['mobile']) && 
    !empty($_POST['profession']) && 
    !empty($_POST['origin']) && 
    !empty($_POST['city']) && 
    !empty($_POST['state']) && 
    !empty($_POST['country']) && 
    !empty($_POST['interest']) && 
    !empty($_POST['special'])
  ) {
    $photos = $verification['photos']; // Existing photos

    if (!empty($_FILES['photos']['name'][0])) {
      // Process each uploaded photo
      $uploaded_images = array();
      foreach ($_FILES['photos']['tmp_name'] as $key => $tmp_name) {
        $image_name = $_FILES['photos']['name'][$key];
        $image_temp_local = $_FILES['photos']['tmp_name'][$key];
        $image_store = "../../DBimages/" . $image_name;

        // Move uploaded image to desired directory
        move_uploaded_file($image_temp_local, $image_store);

        // Store image name in array
        $uploaded_images[] = $image_name;
      }

      // Convert array of image names to comma-separated string
      $photos = implode(',', $uploaded_images);
    }

    require_once('logics.class.php');
    $contactObj = new logics();
    $verification = $contactObj->updateProfile(
        $_POST['name'],
        $_POST['spouse'] ?? '',
        $_POST['childrenNames'] ?? '',
        $_POST['father'],
        $_POST['mother'],
        $_POST['email'],
        $_POST['mobile'],
        $_POST['profession'],
        $_POST['origin'],
        $_POST['city'],
        $_POST['state'],
        $_POST['country'],
        $_POST['interest'],
        $_POST['special'],
        $photos,
        'Insta',
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
              <h5 class="card-title text-primary">Edit Your Profile</h5>
              <form action="./profile.php" method="post" enctype="multipart/form-data" class=" p-3">
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="name" class="form-label">Enter Your Name <sup class="text-danger">*</sup></label>
                    <input type="text" class="form-control" value="<?php echo $verification['name']; ?>" id="name" name="name" placeholder="Full Name" required>
                  </div>
                  <div class="col-md-6">
                    <label for="spouse" class="form-label">Enter Your Spouse Name</label>
                    <input type="text" class="form-control" id="spouse" value="<?php echo $verification['spouse']; ?>" name="spouse" placeholder="Your Spouse Name (Optional)">
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label class="form-label">Do you have Children?<sup class="text-danger">*</sup></label>
                    <div class="d-flex">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="children" id="childrenYes" value="yes" <?php if(!empty($verification['children'])){ echo 'checked'; }; ?>>
                        <label class="form-check-label" for="childrenYes">
                          Yes
                        </label>
                      </div>
                      <div class="form-check mx-3">
                        <input class="form-check-input" type="radio" name="children" id="childrenNo" value="no" <?php if(empty($verification['children'])){ echo 'checked'; }; ?> />
                        <label class="form-check-label" for="childrenNo">
                          No
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6" id="childrenNamesDiv">
                    <label for="childrenNames" class="form-label">Enter Children Names</label>
                    <input type="text" class="form-control" id="childrenNames" name="childrenNames" value="<?php echo $verification['children']; ?>" placeholder="Children Names (comma separated)">
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="father" class="form-label">Father Name <sup class="text-danger">*</sup></label>
                    <input type="text" class="form-control" value="<?php echo $verification['father']; ?>" id="father" name="father" placeholder="Enter Father Name" required>
                  </div>
                  <div class="col-md-6">
                    <label for="mother" class="form-label">Mother Name <sup class="text-danger">*</sup></label>
                    <input type="text" class="form-control" value="<?php echo $verification['mother']; ?>" id="mother" name="mother" placeholder="Enter Mother Name" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="email" class="form-label">Email Address <sup class="text-danger">*</sup></label>
                    <input type="email" class="form-control" value="<?php echo $verification['email']; ?>" id="email" name="email" placeholder="Enter Email Address" required>
                  </div>
                  <div class="col-md-6">
                    <label for="mobile" class="form-label">Mobile Number <sup class="text-danger">*</sup></label>
                    <input type="text" class="form-control" value="<?php echo $verification['mobile']; ?>" id="mobile" name="mobile" placeholder="Enter Mobile Number" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="profession" class="form-label">Current Profession <sup class="text-danger">*</sup></label>
                    <input type="text" class="form-control" value="<?php echo $verification['profession']; ?>" id="profession" name="profession" placeholder="Enter Your Current Profession" required>
                  </div>
                  <div class="col-md-6">
                    <label for="origin" class="form-label">Origin From <sup class="text-danger">*</sup></label>
                    <input type="text" class="form-control" value="<?php echo $verification['origin']; ?>" id="origin" name="origin" placeholder="Origin" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="country" class="form-label">Select Country <sup class="text-danger">*</sup></label>
                    <select name="country" id="country" class="form-select" required>
                      <option value="">-select-</option>
                      <option value="India" <?php if($verification['country'] == 'India') echo 'selected'; ?>>India</option>
                      <option value="USA" <?php if($verification['country'] == 'USA') echo 'selected'; ?>>USA</option>
                      <option value="Africa" <?php if($verification['country'] == 'Africa') echo 'selected'; ?>>Africa</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="state" class="form-label">Select State <sup class="text-danger">*</sup></label>
                    <select name="state" id="state" class="form-select" required>
                      <option value="">-select-</option>
                      <option value="Andhra Pradesh" <?php if($verification['state'] == 'Andhra Pradesh') echo 'selected'; ?>>Andhra Pradesh</option>
                      <option value="Telangana" <?php if($verification['state'] == 'Telangana') echo 'selected'; ?>>Telangana</option>
                      <option value="Tamil Nadu" <?php if($verification['state'] == 'Tamil Nadu') echo 'selected'; ?>>Tamil Nadu</option>
                      <option value="Karnataka" <?php if($verification['state'] == 'Karnataka') echo 'selected'; ?>>Karnataka</option>
                    </select>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="city" class="form-label">Enter City <sup class="text-danger">*</sup></label>
                    <input type="text" class="form-control" value="<?php echo $verification['city']; ?>" id="city" name="city" placeholder="Enter Current City" required>
                  </div>
                  <div class="col-md-6">
                    <label for="interest" class="form-label">Areas of Interest <sup class="text-danger">*</sup></label>
                    <input type="text" class="form-control" value="<?php echo $verification['interest']; ?>" id="interest" name="interest" placeholder="e.g., Art, Music, Photography" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-12">
                    <label for="special" class="form-label">Write Something Special About Your Family/Family of Origin <sup class="text-danger">*</sup></label>
                    <textarea class="form-control" id="special" name="special" rows="5" placeholder="Describe Something Special About Your Family or Origin" required><?php echo $verification['special']; ?></textarea>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-12">
                    <label for="photos" class="form-label">Upload 5 best Photos of Your Family</label>
                    <input type="file" class="form-control" id="photos" name="photos[]" multiple accept="image/*" onchange="validateFileCount()">
                    <div class="d-flex flex-wrap">
                      <?php
                      $photos = explode(',', $verification['photos']);
                      foreach($photos as $photo) {
                        echo '<div class="p-2"><img src="../../DBimages/'.$photo.'" alt="Photo" style="width: 100px; height: 100px; object-fit: cover;"></div>';
                      }
                      ?>
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
<script>
  function validateFileCount() {
        const photosInput = document.getElementById('photos');
        if (photosInput.files.length > 5) {
            alert('You can only upload up to 5 photos.');
            photosInput.value = '';
        }
    }
</script>
