<?php 
session_start();
require_once('./header.php');
if(isset($_GET)){
    $orderID = $_GET['oid'];
    $reason = urldecode($_GET['reason']);
    $paymentID = $_GET['paymentid'];
?>

<div class="container-fluid py-5">
    <div class="row px-xl-5 justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5">
                    <div class="text-center">
                        <div class="mb-4">
                            <i class="fas fa-times-circle text-danger" style="font-size: 4rem;"></i>
                        </div>
                        <h2 class="section-title position-relative text-uppercase mb-4">
                            <span class="bg-white px-3">Payment Failed</span>
                        </h2>
                        
                        <div class="payment-info mb-5">
                            <div class="alert alert-danger" role="alert">
                                <h4 class="alert-heading mb-3">Transaction Unsuccessful</h4>
                                <p>Unfortunately, your payment could not be processed.</p>
                            </div>
                            
                            <div class="order-details p-4 bg-light rounded">
                                <h4 class="mb-4 text-danger">Transaction Details</h4>
                                <div class="row mb-3">
                                    <div class="col-sm-6 text-muted">Order ID:</div>
                                    <div class="col-sm-6"><?php echo htmlspecialchars($orderID); ?></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6 text-muted">Payment ID:</div>
                                    <div class="col-sm-6"><?php echo htmlspecialchars($paymentID); ?></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6 text-muted">Reason:</div>
                                    <div class="col-sm-6"><?php echo htmlspecialchars($reason); ?></div>
                                </div>
                            </div>
                            
                            <div class="support-info mt-5 p-4 bg-light rounded">
                                <h4 class="mb-4 text-primary">Need Help?</h4>
                                <p class="mb-3">Our customer support team is here to assist you:</p>
                                <p class="mb-2"><i class="fas fa-envelope mr-2"></i> support@example.com</p>
                                <p><i class="fas fa-phone mr-2"></i> +91-1234567890</p>
                            </div>
                        </div>
                        
                        <div class="mt-5">
                            <a href="cart.php" class="btn btn-danger btn-lg px-5">
                                <i class="fas fa-shopping-cart mr-2"></i>Return to Cart
                            </a>
                            <a href="index.php" class="btn btn-outline-primary btn-lg px-5 ml-3">
                                <i class="fas fa-home mr-2"></i>Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-5px);
}

.btn {
    transition: all 0.3s;
}

.order-details {
    border-left: 4px solid #dc3545;
}



.section-title span {
    position: relative;
}

.section-title span:after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 50px;
    height: 2px;
    background-color: #dc3545;
}
</style>


<?php
}
require_once('./footer.php');
?>

