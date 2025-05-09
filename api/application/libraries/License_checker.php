<?php
class License_checker {

    protected $CI;
    protected $server_url = 'http://localhost/api/index.php/license/validate';

    public function __construct() {
        $this->CI =& get_instance();
    }

    public function check($api_key, $license_key) {
        $domain = $_SERVER['SERVER_NAME'];

        $response = $this->curl_post($this->server_url, [
            'api_key' => $api_key,
            'license_key' => $license_key,
            'domain' => $domain
        ]);

        $result = json_decode($response, true);

        return isset($result['status']) && $result['status'] === 'success';
    }

    private function curl_post($url, $data) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
