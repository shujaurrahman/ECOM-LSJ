<?php
session_start();
require_once('./logics.class.php');

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST,GET,PUT,PATCH,DELETE');
header("Content-Type: application/json");
header("Accept: application/json");
header('Access-Control-Allow-Headers:Access-Control-Allow-Origin,Access-Control-Allow-Methods,Content-Type');

if(isset($_POST['action']) && $_POST['action'] == 'payOrder') {
    try {
        $adminObj = new logics();
        
        $razorpay_mode='test';

        $razorpay_test_key='rzp_test_MaQgXZ6lfzDN9d'; //Your Test Key
        $razorpay_test_secret_key='FhlGUBUcCD26uIJEJZUvawNO'; //Your Test Secret Key

        $razorpay_live_key= 'Your_Live_Key';
        $razorpay_live_secret_key='Your_Live_Secret_Key';

        if($razorpay_mode=='test'){
            
            $razorpay_key=$razorpay_test_key;
            
        $authAPIkey="Basic ".base64_encode($razorpay_test_key.":".$razorpay_test_secret_key);

        }else{
            
            $authAPIkey="Basic ".base64_encode($razorpay_live_key.":".$razorpay_live_secret_key);
            $razorpay_key=$razorpay_live_key;

        }

        // Remove commas from amount and convert to float
        $payAmount = floatval(str_replace(',', '', $_POST['payAmount']));
        
        // Validate amount
        if ($payAmount <= 0) {
            throw new Exception('Invalid payment amount');
        }

        // Set transaction details
        $order_id = uniqid(); 

        $billing_name=$_POST['billing_name'];
        $billing_mobile=$_POST['billing_mobile'];
        $billing_email=$_POST['billing_email'];
        $shipping_name=$_POST['shipping_name'];
        $shipping_mobile=$_POST['shipping_mobile'];
        $shipping_email=$_POST['shipping_email'];
        $paymentOption=$_POST['paymentOption'];

        $note="Payment of amount Rs. ".$payAmount;

        // Create postdata for Razorpay
        $postdata = array(
            "amount" => round($payAmount * 100), // Convert to paise
            "currency" => "INR",
            "receipt" => uniqid(),
            "notes" => array(
                "billing_name" => $_POST['billing_name'],
                "billing_email" => $_POST['billing_email'],
                "billing_mobile" => $_POST['billing_mobile']
            )
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.razorpay.com/v1/orders',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>json_encode($postdata),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: '.$authAPIkey
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $orderRes= json_decode($response);
        
        if(isset($orderRes->id)){
        
        $rpay_order_id=$orderRes->id;
        
        echo json_encode([
            'res' => 'success',
            'order_number' => $order_id,
            'razorpay_key' => $razorpay_key,
            'userData' => array(
                'amount' => number_format($payAmount, 2, '.', ''), // Format without commas
                'description' => "Pay bill of Rs. " . number_format($payAmount, 2),
                'rpay_order_id' => $orderRes->id,
                'name' => $billing_name,
                'email' => $billing_email,
                'mobile' => $billing_mobile
            )
        ]);
        exit;
        }else{
            echo json_encode(['res'=>'error','order_id'=>$order_id,'info'=>'Error with payment']); exit;
        }
    } catch (Exception $e) {
        echo json_encode(['res'=>'error', 'message'=>$e->getMessage()]); exit;
    }
}else{
    echo json_encode(['res'=>'error']); exit;
}
?>
