<?php

class PhonePeAuthorization {
    private $client_id;
    private $client_secret;
    private $client_version;
    private $base_url;
    private $token_file;

    public function __construct() {
        // UAT credentials
        $this->client_id = 'LAKSHMISRINIUAT_25032115';
        $this->client_secret = 'YmRlZjkzNmMtYzRmNi00MGNiLTgwMzgtODVhNDQzNjAzYjYw';
        $this->client_version = 1;
        $this->base_url = 'https://api-preprod.phonepe.com/apis/pg-sandbox';
        $this->token_file = __DIR__ . '/token_data.json';
    }

    public function getAccessToken() {
        // Check if we have a valid cached token
        $cached_token = $this->getCachedToken();
        if ($cached_token) {
            return $cached_token['access_token'];
        }

        // Get new token if no cached token or expired
        return $this->fetchNewToken();
    }

    private function getCachedToken() {
        if (!file_exists($this->token_file)) {
            return null;
        }

        $token_data = json_decode(file_get_contents($this->token_file), true);
        
        // Check if token is expired (with 5 minutes buffer)
        if (isset($token_data['expires_at']) && $token_data['expires_at'] > (time() + 300)) {
            return $token_data;
        }

        return null;
    }

    private function fetchNewToken() {
        $endpoint = $this->base_url . '/v1/oauth/token';
        
        $data = array(
            'client_id' => $this->client_id,
            'client_version' => $this->client_version,
            'client_secret' => $this->client_secret,
            'grant_type' => 'client_credentials'
        );

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded'
        ));

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code !== 200) {
            throw new Exception('Failed to get authorization token. HTTP Code: ' . $http_code);
        }

        $token_data = json_decode($response, true);
        
        // Save token data to file
        file_put_contents($this->token_file, $response);

        return $token_data['access_token'];
    }
}