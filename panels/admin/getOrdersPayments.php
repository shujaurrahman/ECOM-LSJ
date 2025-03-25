<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!empty($_SESSION['role'])) {
    $title = "Payments";
    require_once('header.php');
    require_once('./logics.class.php');

    

    $getPayments = new logics();
    $verification = $getPayments->getPayments();

    // Change this line from checking 'status' to checking 'result'
    if (!empty($verification['result']) && $verification['result'] == 1) {
        ?>

        <!--  Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-lg-12 mb-4 order-0">
                    <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-12">
                        <div class="card-body d-flex justify-content-between">
                            <h5 class="card-title text-primary">View All Payments</h5>
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
                                                <th>Order ID</th>
                                                <th>Customer</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (!empty($verification['result']) && $verification['result'] == 1) { ?>
                                            <?php if ($verification['count'] > 0) { ?>
                                                <?php for ($i = 0; $i < $verification['count']; $i++) { ?>
                                                    <tr>
                                                        <td><?php echo $verification['order_id'][$i]; ?></td>
                                                        <td>
                                                            <strong><?php echo $verification['billing_fullname'][$i]; ?></strong><br>
                                                            <small><?php echo $verification['billing_email'][$i]; ?></small>
                                                        </td>
                                                        <td>
                                                            <strong>₹<?php echo number_format((float)str_replace(',', '', $verification['grandtotal'][$i]), 2); ?></strong><br>
                                                            <small class="text-muted"><?php echo $verification['total_products'][$i]; ?> items</small>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-<?php 
                                                                echo ($verification['payment_status'][$i] == 'paid') ? 'success' : 
                                                                    (($verification['payment_status'][$i] == 'pending') ? 'warning' : 'danger'); ?>">
                                                                <?php echo ucfirst($verification['payment_status'][$i]); ?>
                                                            </span>
                                                            <br>
                                                            <small><?php echo date('d M Y', strtotime($verification['created_at'][$i])); ?></small>
                                                        </td>
                                                        <td>
                                                            <button 
                                                                class="btn btn-sm btn-primary" 
                                                                onclick="generateInvoice('<?php echo $verification['id'][$i]; ?>')"
                                                                title="Download Invoice">
                                                                <i class="bx bx-download"></i> Invoice
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
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
        echo "No payment data found";
    }

    require_once('footer.php');
} else {
    header('location:login.php');
}
?>
<script>
    new DataTable('#example');
    
    function generateInvoice(orderId) {
        window.location.href = '../../order-details.php?id=' + orderId;
    }
</script>