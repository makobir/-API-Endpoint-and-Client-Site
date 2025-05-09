<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class License extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('License_model');
        header('Content-Type: application/json');
    }

    public function validate() {
        $raw_input = json_decode(trim(file_get_contents('php://input')), true);
        $api_key     = $raw_input['api_key'] ?? null;
        $license_key = $raw_input['license_key'] ?? null;
        $domain      = $raw_input['domain'] ?? null;
        
        $status = $this->License_model->validate_license($api_key, $license_key, $domain);

        switch ($status) {
            case 'valid':
                echo json_encode(['status' => 'success', 'message' => 'License is valid']);
                break;
            case 'expired':
                echo json_encode(['status' => 'error', 'message' => 'Your license has expired.']);
                break;
            case 'invalid':
            default:
                echo json_encode(['status' => 'error', 'message' => 'License key is invalid.']);
                break;
        }
    }

}
