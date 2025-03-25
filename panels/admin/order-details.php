<?php
session_start();


if (!empty($_SESSION['role'])) {
    $title = "Order Details";
    require_once('header.php');
    require_once('./logics.class.php');

    $getUsers = new logics();
    $orderDetails = $getUsers->getOrderDetails($_GET['id']);

    if (!empty($orderDetails['status']) && $orderDetails['status'] == 1) {
?>
    <style>
        .invoice-box {
            background: #fff;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 40px;
            border-radius: 12px;
            margin: 20px;
        }
        .logo-section img {
            max-height: 60px;
        }
        .invoice-header {
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .invoice-id {
            font-size: 24px;
            color: #3a3a3a;
            margin-bottom: 5px;
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-badge.paid { background: #d4edda; color: #155724; }
        .status-badge.pending { background: #fff3cd; color: #856404; }
        .status-badge.confirmed { background: #cce5ff; color: #004085; }
        .info-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            height: 100%;
        }
        .info-box h5 {
            color: #6c757d;
            font-size: 14px;
            text-transform: uppercase;
            margin-bottom: 15px;
        }
        .product-row img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
        }
        .product-name {
            font-weight: 600;
            color: #2c2c2c;
            text-decoration: none;
        }
        .product-name:hover { color: #0056b3; }
        .total-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
        }
        .amount-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .grand-total {
            border-top: 2px solid #dee2e6;
            padding-top: 15px;
            margin-top: 15px;
            font-size: 18px;
            font-weight: 600;
        }
        @media print {
            body * { visibility: hidden; }
            .invoice-box, .invoice-box * { visibility: visible; }
            .invoice-box { position: absolute; left: 0; top: 0; }
            .no-print { display: none; }
        }
        .invoice-header {
    border-bottom: 2px solid #eee;
    padding-bottom: 14px;
    margin-bottom: 28px;
    padding-right: 10px;
}
    </style>

    <div class="container-fluid py-4">
        <div class="invoice-box">
            <!-- Print Button -->
            <button onclick="window.print()" class="btn btn-primary float-end no-print">
                <i class="bx bx-printer"></i> Print Invoice
            </button>
            <!-- Add this button near the print invoice button -->
            <!-- <a href="create_shipment.php?id=<?php echo $orderDetails['order']['id']; ?>" class="btn btn-success float-end no-print me-2">
                <i class="bx bx-package"></i> Create Shipment
            </a> -->

            <!-- Invoice Header -->
            <div class="invoice-header d-flex justify-content-between align-items-start">
                <div>
                    <div class="invoice-id">Invoice #<?php echo $orderDetails['order']['id']; ?></div>
                    <div class="text-muted">Date: <?php echo $orderDetails['order']['formatted_date']; ?></div>
                </div>
                <div class="text-end">
                    <span class="status-badge <?php echo strtolower($orderDetails['order']['payment_status']); ?>">
                        <?php echo ucfirst($orderDetails['order']['payment_status']); ?>
                    </span>
                    <span class="status-badge <?php echo strtolower($orderDetails['order']['order_status']); ?> ms-2">
                        <?php echo ucfirst($orderDetails['order']['order_status']); ?>
                    </span>
                </div>
            </div>

            <!-- Customer & Order Info -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="info-box">
                        <h5>Billing Information</h5>
                        <strong><?php echo $orderDetails['order']['billing_fullname']; ?></strong><br>
                        <?php echo $orderDetails['order']['billing_address1']; ?><br>
                        <?php if(!empty($orderDetails['order']['billing_address2'])) echo $orderDetails['order']['billing_address2'] . '<br>'; ?>
                        <?php echo $orderDetails['order']['billing_city']; ?>, 
                        <?php echo $orderDetails['order']['billing_state']; ?> - <?php echo $orderDetails['order']['billing_pincode']; ?><br>
                        <strong>Phone:</strong> <?php echo $orderDetails['order']['billing_mobile']; ?><br>
                        <strong>Email:</strong> <?php echo $orderDetails['order']['billing_email']; ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <?php if(!empty($orderDetails['order']['shipping_fullname'])): ?>
                    <div class="info-box">
                        <h5>Shipping Information</h5>
                        <strong><?php echo $orderDetails['order']['shipping_fullname']; ?></strong><br>
                        <?php echo $orderDetails['order']['shipping_address1']; ?><br>
                        <?php if(!empty($orderDetails['order']['shipping_address2'])) echo $orderDetails['order']['shipping_address2'] . '<br>'; ?>
                        <?php echo $orderDetails['order']['shipping_city']; ?>, 
                        <?php echo $orderDetails['order']['shipping_state']; ?> - <?php echo $orderDetails['order']['shipping_pincode']; ?><br>
                        <strong>Phone:</strong> <?php echo $orderDetails['order']['shipping_mobile']; ?><br>
                        <strong>Email:</strong> <?php echo $orderDetails['order']['shipping_email']; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <h5>Payment Information</h5>
                        <strong>Payment Method:</strong> <?php echo ucfirst($orderDetails['order']['payment_mode']); ?><br>
                        <strong>Transaction ID:</strong> <?php echo $orderDetails['order']['payment_id']; ?><br>
                        <strong>Payment Date:</strong> <?php echo date('d M Y H:i', strtotime($orderDetails['order']['payment_date'])); ?>
                    </div>
                </div>
   
            </div>

            <!-- Order Items -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <!-- <th>Discount </th> -->
                            <th class="text-end">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderDetails['products'] as $index => $product): ?>
                        <tr class="product-row">
                            <td><?php echo $index + 1; ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="./product/<?php echo $product['product_image']; ?>" class="me-3" alt="">
                                    <div>
                                        <a href="../../product-view?slug=<?php echo $product['product_slug']; ?>" 
                                           class="product-name"><?php echo $product['product_name']; ?></a>
                                        <small class="text-muted d-block"><?php echo $product['product_type']; ?></small>
                                    </div>
                                </div>
                            </td>
                            <!-- <td><?php echo $product['discount_percentage']; ?></td> -->
                            <td class="text-end">₹<?php echo number_format($product['product_price'], 2); ?></td>
                            <td class="text-center"><?php echo $product['quantity']; ?></td>

                            <td class="text-end">₹<?php echo number_format($product['product_price'] * $product['quantity'], 2); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Totals -->
            <div class="row justify-content-end">
                <div class="col-md-5">
                    <div class="total-section">
                        <div class="amount-row">
                            <span>Subtotal:</span>
                            <strong>₹<?php echo number_format($orderDetails['order']['subtotal'], 2); ?></strong>
                        </div>
                        <div class="amount-row">
                            <span>GST (18%):</span>
                            <strong>₹<?php echo number_format($orderDetails['order']['gst'], 2); ?></strong>
                        </div>
                        <?php if(!empty($orderDetails['order']['discount'])): ?>
                        <div class="amount-row text-success">
                            <span>Discount:</span>
                            <strong>-₹<?php echo number_format($orderDetails['order']['discount'], 2); ?></strong>
                        </div>
                        <?php endif; ?>
                        <div class="amount-row grand-total">
                            <span>Grand Total:</span>
                            <strong>₹<?php echo number_format($orderDetails['order']['grandtotal'], 2); ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
    } else {
        echo '<div class="alert alert-danger m-5">Order not found</div>';
    }
    require_once('footer.php');
} else {
    header('location:login.php');
}
?>