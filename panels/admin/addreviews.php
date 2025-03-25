<?php
session_start();
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if (!empty($_SESSION['role'])) {
    $title = "reviews";
    require_once('header.php');
    require_once('./logics.class.php');

    $getUsers = new logics();  
    $verification = $getUsers->getTestimonials();
    ?>
    <!--  Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-12">
                            <div class="card-body d-flex justify-content-between">
                                <h5 class="card-title text-primary">View All Testimonials</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-12">
                            <div class="card-body" style="overflow-x: scroll;">
                                <br>
                                <table id="example" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td>ID</td>
                                            <td>Name</td>
                                            <td>Subject</td>
                                            <td>Message</td>
                                            <td>Rating</td>
                                            <td>Image</td>
                                            <td>Created At</td>
                                            <td>Status</td>
                                            <td>Action</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if (!empty($verification['status']) && $verification['status'] == 1) {
                                        for ($i = 0; $i < $verification['count']; $i++) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i + 1; ?></td>
                                                <td><?php echo htmlspecialchars($verification['name'][$i]); ?></td>
                                                <td><?php echo htmlspecialchars($verification['subject'][$i]); ?></td>
                                                <td><?php echo htmlspecialchars(substr($verification['message'][$i], 0, 100)) . '...'; ?></td>
                                                <td>
                                                    <?php 
                                                    for($j = 0; $j < $verification['rating'][$i]; $j++) {
                                                        echo '<i class="bx bxs-star text-warning"></i>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php if(!empty($verification['image'][$i])) { ?>
                                                        <img src="../../testimonial/<?php echo htmlspecialchars($verification['image'][$i]); ?>" 
                                                             width="50px" alt="testimonial image">
                                                    <?php } else { ?>
                                                        <span class="text-muted">No image</span>
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo date('d M Y', strtotime($verification['created_at'][$i])); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php echo ($verification['statusval'][$i] == 1) ? 'success' : 'danger'; ?>">
                                                        <?php echo ($verification['statusval'][$i] == 1) ? 'Active' : 'Inactive'; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="edit-testimonial.php?id=<?php echo $verification['id'][$i]; ?>" title="Edit Testimonial">
                                                        <i class="menu-icon tf-icons bx bx-edit text-primary mx-2"></i>
                                                    </a>
                                                    <a href="manage-status?update_record_id=<?php echo $verification['id'][$i]; ?>&update_table_name=testimonials&statusval=<?php echo ($verification['statusval'][$i] == 1) ? '2' : '1'; ?>&url=addreviews" 
                                                       onclick="return confirm('Are you sure to <?php echo ($verification['statusval'][$i] == 1) ? 'deactivate' : 'activate'; ?> this testimonial?')">
                                                        <i class="menu-icon tf-icons bx bx-<?php echo ($verification['statusval'][$i] == 1) ? 'minus-circle text-warning' : 'plus-circle text-success'; ?> mx-2"></i>
                                                    </a>
                                                    <a href="manage-status?delete_record_id=<?php echo $verification['id'][$i]; ?>&delete_table_name=testimonials&url=addreviews" 
                                                       onclick="return confirm('Are you sure to Delete?')">
                                                        <i class="menu-icon tf-icons bx bx-trash text-danger mx-2"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="9" class="text-center">
                                                <p class="text-muted my-3">No testimonials found</p>
                                            </td>
                                        </tr>
                                        <?php
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
} else {
    header('location:login.php');
}
?>
<script>
    new DataTable('#example', {
        language: {
            emptyTable: "No testimonials found"
        }
    });
</script>