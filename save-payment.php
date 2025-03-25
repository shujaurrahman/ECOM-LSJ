<?php
session_start();
date_default_timezone_set('Asia/Kolkata'); // Set Indian timezone
require_once('./logics.class.php'); // Fix path to logics.class.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    
    $adminObj = new logics();
    

    $data = [
        'order_id' => filter_var($_POST['order_id'], FILTER_SANITIZE_STRING),
        'payment_id' => filter_var($_POST['payment_id'], FILTER_SANITIZE_STRING),
        'payment_signature' => filter_var($_POST['signature'], FILTER_SANITIZE_STRING),
        'amount' => filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
        'status' => 'success',
        'created_at' => date('Y-m-d H:i:s') 
    ];

    
    $result = $adminObj->savePaymentDetails($data);
    


    
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}