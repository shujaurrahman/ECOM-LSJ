<?php
session_start();
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once('./logics.class.php');
require_once('./pg/authorize.php');



try {
    if (!isset($_SESSION['pending_order']) || !isset($_SESSION['checkout_form_data'])) {
        throw new Exception('Invalid session data');
    }

    $pending_order = $_SESSION['pending_order'];
    $form_data = $_SESSION['checkout_form_data'];
    
    // Check payment status
    $paymentStatus = checkPaymentStatus($pending_order['order_id']);
    
    if ($paymentStatus['state'] !== 'COMPLETED') {
        throw new Exception("Payment not completed. State: {$paymentStatus['state']}");
    }

    // Get values directly from form data
    $subtotal = str_replace(',', '', $form_data['subtotal']); // Remove commas
    $gst = str_replace(',', '', $form_data['gst']); 
    $total = str_replace(',', '', $form_data['total']);
    $total_products = $form_data['total_products'];

    // Prepare order data with all required fields
    $orderData = [
        'order_id' => $pending_order['order_id'],
        'razorpay_order_id' => $paymentStatus['orderId'] ?? '', // PhonePe order ID
        'user_id' => $_SESSION['user_id'],
        'billing_fullname' => $form_data['name'],
        'billing_email' => $form_data['email'],
        'billing_mobile' => $form_data['mobile'],
        'billing_address1' => $form_data['address1'],
        'billing_address2' => $form_data['address2'],
        'billing_city' => $form_data['city'],
        'billing_state' => $form_data['state'],
        'billing_pincode' => $form_data['pincode'],
        'shipping_fullname' => $form_data['shipping_name'] ?? $form_data['name'],
        'shipping_email' => $form_data['shipping_email'] ?? $form_data['email'],
        'shipping_mobile' => $form_data['shipping_mobile'] ?? $form_data['mobile'],
        'shipping_address1' => $form_data['shipping_address1'] ?? $form_data['address1'],
        'shipping_address2' => $form_data['shipping_address2'] ?? $form_data['address2'],
        'shipping_city' => $form_data['shipping_city'] ?? $form_data['city'],
        'shipping_state' => $form_data['shipping_state'] ?? $form_data['state'],
        'shipping_pincode' => $form_data['shipping_pincode'] ?? $form_data['pincode'],
        'payment_mode' => 'phonepe',
        'payment_amount' => $total,
        'payment_reference' => $paymentStatus['paymentDetails'][0]['transactionId'],
        'payment_id' => $paymentStatus['paymentDetails'][0]['transactionId'],
        'payment_date' => date('Y-m-d H:i:s'),
        'order_status' => 'confirmed',
        'payment_status' => 'paid',
        'total_products' => $total_products,
        'subtotal' => $subtotal,
        'gst' => $gst,
        'total' => $total,
        'grandtotal' => $total,
        'payment_proof' => '',
        'approval' => 'pending',
        'remarks' => '',
        'status' => 1
    ];

    // Also handle coupon if applied
    if (!empty($form_data['coupon_hidden'])) {
        $orderData['coupon_code'] = $form_data['coupon_hidden'];
        $orderData['discount'] = $form_data['discount_hidden'];
        $orderData['discount_type'] = $form_data['couponType_hidden'];
    }

    $adminObj = new logics();
    $result = $adminObj->PlaceOrder($orderData);

    if ($result['status'] == 1) {
        // Clear session data
        unset($_SESSION['pending_order']);
        unset($_SESSION['checkout_form_data']);
        
        $paymentId = $paymentStatus['paymentDetails'][0]['transactionId'] ?? 'N/A';
        header('Location: payment-success.php?order_id=' . $result['order_id'] . '&amount=' . $pending_order['amount'] . '&payment_id=' . $paymentId);
        exit;
    } else {
        throw new Exception($result['error'] ?? 'Failed to save order');
    }
} catch (Exception $e) {
    $paymentId = $paymentStatus['paymentDetails'][0]['transactionId'] ?? 'N/A';
    header('Location: payment-failed.php?reason=' . urlencode($e->getMessage()) . '&order_id=' . $pending_order['order_id'] . '&payment_id=' . $paymentId);
    exit;
}

function checkPaymentStatus($orderId) {
    $auth = new PhonePeAuthorization();
    $accessToken = $auth->getAccessToken();
    $url = "https://api-preprod.phonepe.com/apis/pg-sandbox/checkout/v2/order/{$orderId}/status";

    $headers = [
        "Content-Type: application/json",
        "Authorization: O-Bearer {$accessToken}"
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        throw new Exception("Failed to check payment status. HTTP Code: {$httpCode}");
    }

    return json_decode($response, true);
}