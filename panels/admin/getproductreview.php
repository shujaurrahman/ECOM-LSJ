<?php
session_start();

// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// 

if (!empty($_SESSION['role'])) {
    $title = "product-reviews";
    require_once('header.php');
    require_once('./logics.class.php');

    $getUsers = new logics();  
    $verification = $getUsers->getProductReviews();
    
    // New method to get product reviews
    ?>
    <!--  Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-12">
                            <div class="card-body d-flex justify-content-between">
                                <h5 class="card-title text-primary">View All Product Reviews</h5>
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
                                <table id="example" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>User Name</th>
                                            <th>Product Name</th>
                                            <th>Rating</th>
                                            <th>Review</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if (!empty($verification['status']) && $verification['status'] == 1) {
                                        for ($i = 0; $i < $verification['count']; $i++) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i + 1; ?></td>
                                                <td><?php echo htmlspecialchars($verification['user_name'][$i] ?? ''); ?></td>
                                                <td><?php echo htmlspecialchars($verification['product_name'][$i] ?? ''); ?></td>
                                                <td>
                                                    <?php 
                                                    $rating = intval($verification['rating'][$i] ?? 0);
                                                    for($j = 0; $j < $rating; $j++) {
                                                        echo '<i class="bx bxs-star text-warning"></i>';
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($verification['review'][$i] ?? ''); ?></td>
                                                <td>
                                                    <?php 
                                                    $reviewStatus = intval($verification['statusval'][$i]); // Changed from status to statusval
                                                    ?>
                                                    <span class="badge bg-<?php echo ($reviewStatus == 2) ? 'danger' : 'success'; ?>">
                                                        <?php echo ($reviewStatus == 2) ? 'Inactive' : 'Active'; ?>
                                                    </span>
                                                </td>
                                                <td><?php echo date('d M Y', strtotime($verification['created_at'][$i])); ?></td>
                                                <td>
                                                    <a href="manage-status.php?update_record_id=<?php echo $verification['id'][$i]; ?>&update_table_name=ratings&statusval=<?php echo ($reviewStatus == 1) ? '2' : '1'; ?>&url=getproductreview" 
                                                       onclick="return confirm('Are you sure to <?php echo ($reviewStatus == 1) ? 'deactivate' : 'activate'; ?> this review?')">
                                                        <i class="menu-icon tf-icons bx bx-<?php echo ($reviewStatus == 2) ? 'plus-circle text-success' : 'minus-circle text-warning'; ?> mx-2"></i>
                                                    </a>
                                                    <a href="manage-status.php?delete_record_id=<?php echo $verification['id'][$i]; ?>&delete_table_name=ratings&url=getproductreview.php" 
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
                                            <td colspan="8" class="text-center">No reviews found</td>
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
$(document).ready(function() {
    $('#example').DataTable({
        order: [[6, 'desc']], // Sort by Created At column
        columnDefs: [
            { orderable: false, targets: [3, 7] } // Disable sorting for Rating and Action columns
        ],
        language: {
            emptyTable: "No reviews found"
        },
        pageLength: 10,
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
    });
});

</script>