<?php
session_start();
if (!empty($_SESSION['role'])) {
    $title = "customizations";
    require_once('header.php');
    require_once('./logics.class.php');

    $getUsers = new logics();
    $verification = $getUsers->getCustomizations();

    if (!empty($verification['status']) && $verification['status'] == 1) {
        ?>

        <!--  Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-lg-12 mb-4 order-0">
                    <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-12">
                        <div class="card-body d-flex justify-content-between">
                            <h5 class="card-title text-primary">Customization Requests</h5>
                            <!-- <a href="./addCoupon" class="btn btn-sm btn-primary">Add new Coupon</a> -->
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
                                                <td>User Details</td>
                                                <td>Image</td>
                                                <td>Reference Product</td>
                                                <td>Created At</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        for ($i = 0; $i < $verification['count']; $i++) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i + 1; ?></td>
                                                <td>
                                                    <?php echo $verification['user_name'][$i]; ?> <br><?php echo $verification['user_email'][$i]; ?> <br><?php echo $verification['user_mobile'][$i]; ?></td>
                                                <td>
                                                    <img src="./customizations/<?php echo $verification['image'][$i]; ?>" alt=""> <br> 
                                                    <a href="./customizations/<?php echo $verification['image'][$i]; ?>" target="_blank" class="btn btn-sm btn-primary">View Full Image</a>
                                                </td>
                                                
                                                <td><a href="../../product-view?slug=<?php echo $verification['product_slug'][$i]; ?>" target="_blank"><?php echo $verification['product_slug'][$i]; ?></a></td>
                                                <td><?php echo $verification['created_at'][$i]; ?></td>
                                                
                                                
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
    } else {
        echo "Data not fetched";
    }

    require_once('footer.php');
} else {
    header('location:login.php');
}
?>
<script>
    new DataTable('#example');
</script>