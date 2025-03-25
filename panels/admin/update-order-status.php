<?php
session_start();
header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 0);

if (empty($_SESSION['role'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['order_id']) || empty($_POST['order_status'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request parameters']);
    exit;
}

require_once('./logics.class.php');
$adminObj = new logics();

$order_id = $_POST['order_id'];
$order_status = $_POST['order_status'];

$valid_statuses = [
    'confirmed', 'approved', 'processing', 'packed',
    'dispatched', 'in_transit', 'out_for_delivery', 'delivered',
    'cancelled', 'returned'
];

if (!in_array($order_status, $valid_statuses)) {
    echo json_encode(['success' => false, 'message' => 'Invalid status value']);
    exit;
}

error_log("Attempting to update Order ID: $order_id to status: $order_status");

$result = $adminObj->updateOrderStatus($order_id, $order_status);

error_log("Update result: " . print_r($result, true));

if ($result['status'] == 1) {
    echo json_encode(['success' => true, 'message' => 'Order status updated successfully']);
} else {
    echo json_encode([
        'success' => false,
        'message' => isset($result['error']) ? $result['error'] : 'Failed to update order status'
    ]);
}
?>
