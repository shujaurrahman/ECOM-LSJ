<?php 
session_start();
if(!empty($_SESSION['role']) ){
  $title="Partner";
require_once('header.php');
require_once('./logics.class.php');

$adminObj = new logics();
// $partners = $adminObj->getPartners();

// echo $partners['count'];

if(!empty($_POST['partner_name']) && !empty($_FILES['partner_image']) ){
    if (!empty($_FILES['partner_image']['name'])) {
      $partner_imageName = $_FILES['partner_image']['name'];
      $partner_imageTempLocal = $_FILES['partner_image']['tmp_name'];
      
      // Append current date and time to the partner_image name to make it unique
      $timestamp = date("YmdHis");
      $extension = pathinfo($partner_imageName, PATHINFO_EXTENSION);
      $partner_imageName = pathinfo($partner_imageName, PATHINFO_FILENAME) . '_' . $timestamp . '.' . $extension;

      $partner_imageStore = "partners/" . $partner_imageName;

      // Move uploaded partner_image photo to desired directory
      move_uploaded_file($partner_imageTempLocal, $partner_imageStore);

      // Store partner_image photo name
      $partner_imagePhoto = $partner_imageName;
    }

    $verification = $adminObj->AddPartner($_POST['partner_name'], $partner_imagePhoto);
    if(!empty($verification['status']) && $verification['status']==1){
        echo '<script src="../js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "success",
                title: "Partner Successfully Added!",
                showConfirmButton: true,
            }).then(function() {
                window.location.href = "addPartners.php";
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
                window.location.href = "addPartners.php";
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
                            <h5 class="card-title text-primary">Add Partner</h5>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="./addPartners.php" method="post" enctype="multipart/form-data" class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-body">
                    <label for="partner_name">Partner Name<sup class="text-danger">*</sup></label>
                    <input type="text" name="partner_name" placeholder="Enter Partner Name" class="form-control mb-3" required id="partner_name">

                    <label for="image">Partner Image<sup class="text-danger">*</sup></label>
                    <input type="file" name="partner_image" placeholder="Enter Partner Image" class="form-control mb-3" required id="image">

                    <br>
                    <input type="submit" name="submit" value="Add Partner" class="btn btn-primary" id="">
                </div>
            </div>
        </div>
    </form>

    <!-- Display Partners -->
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-12">
                        <div class="card-body" style="overflow-x: scroll;">
                            <h5 class="card-title text-primary">View All Partners</h5>
                            <br>
                            <table id="example" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>Partner Name</td>
                                        <td>Partner Image</td>
                                        <td>Created At</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
<?php
$partners = $adminObj->getPartners();
if (!empty($partners['status']) && $partners['status'] == 1) {
    for ($i = 0; $i < $partners['count']; $i++) {
        ?>
        <tr>
            <td><?php echo $i + 1; ?></td>
            <td><?php echo htmlspecialchars($partners['name'][$i]); ?></td>
            <td>
                <img src="./partners/<?php echo htmlspecialchars($partners['image'][$i]); ?>" width="100px" alt="Partner Image">
            </td>
            <td><?php echo htmlspecialchars($partners['created_at'][$i]); ?></td>
            <td>
                <a href="manage-status?delete_record_id=<?php echo htmlspecialchars($partners['id'][$i]); ?>&delete_table_name=partners&url=addPartners" 
                   onclick="return confirm('Are you sure to Delete?')">
                    <i class="menu-icon tf-icons bx bx-trash text-danger mx-2"></i>
                </a>
            </td>
        </tr>
        <?php
    }
} else {
    echo '<tr><td colspan="5">No partners found.</td></tr>';
}
?>
</tbody>


                            </table>
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
    new DataTable('#example');
</script>