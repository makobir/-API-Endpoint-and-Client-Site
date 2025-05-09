<?php

class License_checker {
    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }

    public function check($api_key, $license_key, $domain) {
    $post_data = json_encode([
        'api_key'     => $api_key,
        'license_key' => $license_key,
        'domain'      => $domain,
    ]);

    $url = 'http://localhost/api/index.php/license/validate';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        return ['status' => 'error', 'message' => 'Connection error: ' . $error];
    }

    $result = json_decode($response, true);
    return $result ?? ['status' => 'error', 'message' => 'Invalid API response'];
}

}
