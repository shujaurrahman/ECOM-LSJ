<?php
session_start();
// error_reporting(0);
// ini_set('display_errors', 0);
// error_reporting(E_ALL);
if (!empty($_SESSION['role'])) {
    $title = "orders";
    require_once('header.php');
    require_once('./logics.class.php');
    $getUsers = new logics();
    $verification = $getUsers->getOrders();

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
                            <h5 class="card-title text-primary">View All Orders</h5>
                            <!-- <a href="./addCategory" class="btn btn-sm btn-primary">Add new Category</a> -->
                            
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
                                                <td>Order ID</td>
                                                <td>User Details</td>
                                                <td>Total Products</td>
                                                <td>Total Price</td>
                                                <td>Created At</td>
                                                <td>Details</td>
                                                <td>Status</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        for ($i = 0; $i < $verification['count']; $i++) {
                                            ?>
                                            <tr>
                                                <td><?php echo $verification['id'][$i]; ?></td>
                                                <td>
                                                    <span><?php echo $verification['user_name'][$i]; ?></span><br>
                                                    <span><?php echo $verification['user_mobile'][$i]; ?></span><br>
                                                    <span><?php echo $verification['user_email'][$i]; ?></span><br>
                                                </td>
                                                <td><?php echo $verification['total_products'][$i]; ?> Products</td>
                                                
                                                <td><?php echo $verification['grandtotal'][$i]; ?></td>
                                                <td><?php echo $verification['created_at'][$i]; ?></td>
                                                <td>
                                                    <a href="order-details?id=<?php echo $verification['id'][$i]; ?>" class="btn btn-sm btn-outline-secondary">
                                                        <i class="bx bx-show-alt"></i>
                                                    </a>
                                                </td>

                                                <td>
                                                    <form action="update-order-status.php" method="post" class="order-status-form">
                                                        <input type="hidden" name="order_id" value="<?php echo $verification['id'][$i]; ?>">
                                                        <select name="order_status" class="form-select order-status-select" data-order-id="<?php echo $verification['id'][$i]; ?>">
                                                            <option value="confirmed" <?php echo ($verification['order_status'][$i] == 'confirmed' || empty($verification['order_status'][$i])) ? 'selected' : ''; ?>>Confirmed</option>
                                                            <option value="approved" <?php echo ($verification['order_status'][$i] == 'approved') ? 'selected' : ''; ?>>Approved</option>
                                                            <option value="processing" <?php echo ($verification['order_status'][$i] == 'processing') ? 'selected' : ''; ?>>Processing</option>
                                                            <option value="packed" <?php echo ($verification['order_status'][$i] == 'packed') ? 'selected' : ''; ?>>Packed</option>
                                                            <option value="dispatched" <?php echo ($verification['order_status'][$i] == 'dispatched') ? 'selected' : ''; ?>>Dispatched</option>
                                                            <option value="in_transit" <?php echo ($verification['order_status'][$i] == 'in_transit') ? 'selected' : ''; ?>>In Transit</option>
                                                            <option value="out_for_delivery" <?php echo ($verification['order_status'][$i] == 'out_for_delivery') ? 'selected' : ''; ?>>Out for Delivery</option>
                                                            <option value="delivered" <?php echo ($verification['order_status'][$i] == 'delivered') ? 'selected' : ''; ?>>Delivered</option>
                                                            <option value="cancelled" <?php echo ($verification['order_status'][$i] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                                            <option value="returned" <?php echo ($verification['order_status'][$i] == 'returned') ? 'selected' : ''; ?>>Returned</option>
                                                        </select>
                                                        <div class="status-indicator mt-2"></div>
                                                    </form>
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
    } else {
        echo "Data not fetched";
    }

    require_once('footer.php');
} else {
    header('location:login.php');
}
?>
<script>
    $(document).ready(function() {
        const table = $('#example').DataTable();

        function attachEventListeners() {
            const selects = document.querySelectorAll('.order-status-select');

            selects.forEach(select => {
                select.dataset.originalValue = select.value;

                select.addEventListener('change', function(e) {
                    const form = this.closest('form');
                    const orderId = this.dataset.orderId;
                    const statusIndicator = form.querySelector('.status-indicator');

                    statusIndicator.innerHTML = '<span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span> Updating...';

                    const formData = new FormData(form);

                    fetch('update-order-status.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            statusIndicator.innerHTML = '<span class="text-success"><i class="bx bx-check"></i> Updated</span>';
                            this.dataset.originalValue = this.value;
                            setTimeout(() => {
                                statusIndicator.innerHTML = '';
                            }, 3000);
                        } else {
                            statusIndicator.innerHTML = '<span class="text-danger"><i class="bx bx-error"></i> Failed to update: ' + data.message + '</span>';
                            this.value = this.dataset.originalValue;
                            console.error('Error:', data);
                            setTimeout(() => {
                                statusIndicator.innerHTML = '';
                            }, 3000);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        statusIndicator.innerHTML = '<span class="text-danger"><i class="bx bx-error"></i> Error</span>';
                        this.value = this.dataset.originalValue;
                        setTimeout(() => {
                            statusIndicator.innerHTML = '';
                        }, 3000);
                    });
                });
            });
        }

        // Attach event listeners initially
        attachEventListeners();

        // Re-attach event listeners after each table draw
        table.on('draw', function() {
            attachEventListeners();
        });
    });
</script>