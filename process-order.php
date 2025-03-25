<?php
session_start();
header('Content-Type: application/json');

// Enable error reporting
// ini_set('display_errors', 1);
// ini_set('log_errors', 1);
// error_reporting(E_ALL);

if(isset($_POST['submit'])) {
    try {
        error_log("Processing order with POST data: " . print_r($_POST, true));
        
        require_once('./logics.class.php');
        $adminObj = new logics();

        // Validate required fields
        $requiredFields = ['razorpay_payment_id', 'razorpay_order_id', 'razorpay_signature'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Missing required field: $field");
            }
        }

        $orderData = array(
            'order_id' => $_POST['razorpay_order_id'],
            'razorpay_order_id' => $_POST['razorpay_order_id'],
            'user_id' => $_SESSION['user_id'],
            // Match exact form field names
            'billing_fullname' => $_POST['name'],
            'billing_email' => $_POST['email'],
            'billing_mobile' => $_POST['mobile'],
            'billing_address1' => $_POST['address1'],
            'billing_address2' => $_POST['address2'],
            'billing_city' => $_POST['city'],
            'billing_state' => $_POST['state'],
            'billing_pincode' => $_POST['pincode'],
            // Use shipping details, fallback to billing if empty
            'shipping_fullname' => !empty($_POST['shipping_name']) ? $_POST['shipping_name'] : $_POST['name'],
            'shipping_email' => !empty($_POST['shipping_email']) ? $_POST['shipping_email'] : $_POST['email'],
            'shipping_mobile' => !empty($_POST['shipping_mobile']) ? $_POST['shipping_mobile'] : $_POST['mobile'],
            'shipping_address1' => !empty($_POST['shipping_address1']) ? $_POST['shipping_address1'] : $_POST['address1'],
            'shipping_address2' => !empty($_POST['shipping_address2']) ? $_POST['shipping_address2'] : $_POST['address2'],
            'shipping_city' => !empty($_POST['shipping_city']) ? $_POST['shipping_city'] : $_POST['city'],
            'shipping_state' => !empty($_POST['shipping_state']) ? $_POST['shipping_state'] : $_POST['state'],
            'shipping_pincode' => !empty($_POST['shipping_pincode']) ? $_POST['shipping_pincode'] : $_POST['pincode'],
            // Order details
            'total_products' => $_POST['total_products'],
            'subtotal' => $_POST['subtotal'],
            'gst' => $_POST['gst'],
            'total' => $_POST['total'],
            'grandtotal' => !empty($_POST['grandTotal_hidden']) ? $_POST['grandTotal_hidden'] : $_POST['total'],
            // Coupon details
            'coupon' => $_POST['coupon_hidden'] ?? '',
            'discount' => $_POST['discount_hidden'] ?? '',
            'coupon_type' => $_POST['couponType_hidden'] ?? '',
            // Payment details
            'payment_mode' => 'razorpay',
            'payment_amount' => $_POST['payment_amount'],
            'payment_reference' => $_POST['razorpay_signature'],
            'payment_proof' => '',
            'approval' => 'pending',
            'remarks' => '',
            'status' => 1,
            'payment_id' => $_POST['razorpay_payment_id'],
            'payment_date' => date('Y-m-d H:i:s'),
            'order_status' => 'confirmed',
            'payment_status' => 'paid'
        );

        // Add debugging
        error_log("Form field names received: " . print_r(array_keys($_POST), true));
        error_log("Billing details being used: " . print_r([
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'mobile' => $_POST['mobile']
        ], true));

        error_log("Order data prepared: " . print_r($orderData, true));

        $result = $adminObj->PlaceOrder($orderData);
        error_log("PlaceOrder result: " . print_r($result, true));

        if($result['status'] == 1) {
            echo json_encode([
                'status' => 1,
                'order_id' => $result['order_id'],
                'amount' => $orderData['payment_amount']
            ]);
        } else {
            throw new Exception($result['error'] ?? 'Failed to save order');
        }
    } catch (Exception $e) {
        error_log("Order Processing Error: " . $e->getMessage());
        error_log("Stack trace: " . $e->getTraceAsString());
        echo json_encode([
            'status' => 0,
            'message' => $e->getMessage()
        ]);
    }
    exit;
}