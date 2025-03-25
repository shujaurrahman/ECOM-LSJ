<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(!empty($_GET['id'])){

  if(!empty($_SESSION['role']) ){
    require_once('header.php');

    if(isset($_POST['submit'])){
      require_once('./logics.class.php');
      $adminObj = new logics();

      // Get form data
      $id = $_POST['id'];
      $name = $_POST['name'];
      $designation = $_POST['designation'];
      $review = $_POST['review'];
      $rating = $_POST['rating'];

      // Handle image upload
      $image = '';
      if(!empty($_FILES['image']['name'])) {
        $imageName = $_FILES['image']['name'];
        $imageTempLocal = $_FILES['image']['tmp_name'];
        
        // Generate unique name
        $timestamp = date("YmdHis");
        $extension = pathinfo($imageName, PATHINFO_EXTENSION);
        $imageName = pathinfo($imageName, PATHINFO_FILENAME) . '_' . $timestamp . '.' . $extension;
        
        // Set upload path
        $imageStore = "testimonial/" . $imageName;
        
        // Move uploaded file
        if(move_uploaded_file($imageTempLocal, "../../testimonial/" . $imageStore)) {
          $image = $imageStore;
        }
      } else {
        // Keep existing image
        $image = $_POST['current_image'];
      }

      $verification = $adminObj->UpdateTestimonial($id, $name, $designation, $review, $rating, $image);
      
      if(!empty($verification['status']) && $verification['status']==1){
          echo '<script src="../js/sweetalert.js"></script>';
          echo '<script>';
          echo 'Swal.fire({
                  icon: "success",
                  title: "Testimonial Successfully Updated!",
                  showConfirmButton: true,
              }).then(function() {
                  window.location.href = "addreviews";
              });';
          echo '</script>';
      } else {
          echo '<script src="../js/sweetalert.js"></script>';
          echo '<script>';
          echo 'Swal.fire({
                  icon: "error",
                  title: "Data not Submitted!",
                  text: "Please try again"
              }).then(function() {
                  window.location.href = "addreviews";
              });';
          echo '</script>';
      }
    }

    require_once('./logics.class.php');
    $obj = new logics();
    $testimonial = $obj->getTestimonialById($_GET['id']);

    if (!empty($testimonial['status']) && $testimonial['status'] == 1) {
    ?>
    <!--  Content -->
      <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
          <div class="col-lg-12 mb-4 order-0">
            <div class="card">
              <div class="d-flex align-items-end row">
                <div class="col-sm-12">
                  <div class="card-body d-flex justify-content-between">
                    <h5 class="card-title text-primary">Update Testimonial</h5>
                    <a href="./addreviews" class="btn btn-sm btn-primary">View All Testimonials</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <form action="./edit-testimonial.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" class="row">
          
          <div class="col-lg-12 mb-4 order-0">
            <div class="card">
              <div class="card-body">
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                <input type="hidden" name="current_image" value="<?php echo $testimonial['image'] ?>">

                <div class="mb-3">
                  <label for="name" class="form-label">Customer Name<sup class="text-danger">*</sup></label>
                  <input type="text" name="name" placeholder="Enter customer name" value="<?php echo $testimonial['name'] ?>"  class="form-control" required id="name">
                </div>

                <div class="mb-3">
                  <label for="designation" class="form-label">Designation<sup class="text-danger">*</sup></label>
                  <input type="text" name="designation" placeholder="Enter designation" value="<?php echo $testimonial['designation'] ?>"  class="form-control" required id="designation">
                </div>

                <div class="mb-3">
                  <label for="review" class="form-label">Review<sup class="text-danger">*</sup></label>
                  <textarea name="review" id="review" class="form-control" rows="4" placeholder="Enter customer review" required><?php echo $testimonial['review'] ?></textarea>
                </div>

                <div class="mb-3">
                  <label for="rating" class="form-label">Rating<sup class="text-danger">*</sup></label>
                  <select name="rating" id="rating" class="form-select" required>
                    <option value="">Select Rating</option>
                    <option value="1" <?php echo $testimonial['rating'] == 1 ? 'selected' : '' ?>>1 Star</option>
                    <option value="2" <?php echo $testimonial['rating'] == 2 ? 'selected' : '' ?>>2 Stars</option>
                    <option value="3" <?php echo $testimonial['rating'] == 3 ? 'selected' : '' ?>>3 Stars</option>
                    <option value="4" <?php echo $testimonial['rating'] == 4 ? 'selected' : '' ?>>4 Stars</option>
                    <option value="5" <?php echo $testimonial['rating'] == 5 ? 'selected' : '' ?>>5 Stars</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="image" class="form-label">Customer Image</label>
                  <input type="file" name="image" class="form-control" id="image" accept="image/*">
                  <div class="text-danger small mt-1">
                    <i class="bx bx-error-circle"></i>
                    Maximum image size allowed is 2MB. Image dimensions must be 100px × 400px.
                  </div>
                  
                  <?php if (!empty($testimonial['image'])): ?>
                  <div class="mt-2">
                    <p class="mb-1">Current Image:</p>
                    <img src="../../testimonial/<?php echo $testimonial['image']; ?>" alt="Current Image" class="img-thumbnail" style="max-width: 150px;">
                  </div>
                  <?php endif; ?>
                </div>
  
                <div class="mt-3">
                  <input type="submit" name="submit" value="Update Testimonial" class="btn btn-primary">
                  <a href="addreviews" class="btn btn-danger">Cancel</a>
                </div>
              </div>
            </div>
          </div>

        </form>
      </div>
    <!-- / Content -->

    <?php 
    } else {
      echo "<div class='container-xxl flex-grow-1 container-p-y'>
              <div class='alert alert-danger'>Testimonial data not found</div>
              <a href='addreviews' class='btn btn-primary'>Back to Testimonials</a>
            </div>";
    }
    
    require_once('footer.php');
    } else {
      header('location:login.php');
    }
} else {
  header('location:addreviews');
}
?>

<script>
// Add image validation for dimensions
document.addEventListener('DOMContentLoaded', function() {
  const imageInput = document.querySelector('input[name="image"]');
  if (imageInput) {
    imageInput.addEventListener('change', function() {
      validateImageUpload(this);
    });
  }
});

function validateImageUpload(fileInput) {
  if (fileInput.files && fileInput.files[0]) {
    const maxSize = 2 * 1024 * 1024; // 2MB
    const file = fileInput.files[0];
    
    // Check file size
    if (file.size > maxSize) {
      showImageError(fileInput, "Image size exceeds 2MB. Please choose a smaller file.");
      fileInput.value = '';
      return;
    }
    
    // Check dimensions
    const img = new Image();
    img.onerror = function() {
      showImageError(fileInput, "Invalid image file.");
      fileInput.value = '';
    };
    
    const reader = new FileReader();
    reader.onload = function(e) {
      img.src = e.target.result;
    };
    reader.readAsDataURL(file);
  }
}

function showImageError(fileInput, message) {
  const alertDiv = document.createElement('div');
  alertDiv.className = 'alert alert-danger alert-dismissible fade show mt-2';
  alertDiv.id = 'imageError';
  alertDiv.innerHTML = `
    <div class="d-flex align-items-center">
        <i class="bx bx-error-circle me-2"></i>
        <strong>Error:</strong>&nbsp;${message}
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  `;
  
  // Remove existing error if any
  const existingError = document.getElementById('imageError');
  if (existingError) {
    existingError.remove();
  }
  
  // Add new error
  fileInput.parentNode.appendChild(alertDiv);
  
  // Auto-dismiss after 5 seconds
  setTimeout(() => {
    if (document.getElementById('imageError')) {
      document.getElementById('imageError').remove();
    }
  }, 5000);
}
</script>