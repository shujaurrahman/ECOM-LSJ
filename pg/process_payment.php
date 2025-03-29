<?php
session_start();
require_once 'authorize.php';

class PaymentProcessor {
    private $base_url;
    private $auth;
    private $redirect_url;

    public function __construct() {
        $this->base_url = 'https://api-preprod.phonepe.com/apis/pg-sandbox';
        $this->auth = new PhonePeAuthorization();
        $this->redirect_url = 'http://localhost/Qunta%20Pixel/lsj-working/callback.php';
    }

    public function processPayment($formData) {
        try {
            // Store checkout form data in session
            $_SESSION['checkout_form_data'] = $formData;

            // Generate order ID and store order details
            $order_id = 'ORDID' . time();
            $_SESSION['pending_order'] = [
                'order_id' => $order_id,
                'amount' => $formData['amount'],
                'billing_name' => $formData['name'],
                'billing_email' => $formData['email'],
                'billing_mobile' => $formData['mobile'],
                'timestamp' => time()
            ];



            // Initialize payment
            $access_token = $this->auth->getAccessToken();
            $payload = [
                'merchantOrderId' => $order_id,
                'amount' => $formData['amount'] * 100,
                'expireAfter' => 1200,
                'paymentFlow' => [
                    'type' => 'PG_CHECKOUT',
                    'message' => 'Payment for order ' . $order_id,
                    'merchantUrls' => [
                        'redirectUrl' => $this->redirect_url
                    ]
                ]
            ];

            $endpoint = $this->base_url . '/checkout/v2/pay';
            
            $ch = curl_init($endpoint);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: O-Bearer ' . $access_token
            ]);

            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($http_code !== 200) {
                throw new Exception('Payment initiation failed. HTTP Code: ' . $http_code);
            }

            $result = json_decode($response, true);
       

            if (isset($result['redirectUrl'])) {
                return [
                    'success' => true,
                    'redirectUrl' => $result['redirectUrl']
                ];
            }
            
            throw new Exception('No redirect URL received');

        } catch (Exception $e) {

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}

// Handle incoming request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $processor = new PaymentProcessor();
    $result = $processor->processPayment($_POST);
    
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}