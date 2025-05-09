<?php
class License_model extends CI_Model {
   public function validate_license($api_key, $license_key, $domain) {
    // Example logic — adjust according to your database and fields
    $license = $this->db->get_where('licenses', [
        'api_key'     => $api_key,
        'license_key' => $license_key,
        'domain'      => $domain,
    ])->row();

    if (!$license) {
        return 'invalid';
    }

    if (strtotime($license->expires_at) < time()) {
        return 'expired';
    }

    return 'valid';
}

    public function get_all() {
        return $this->db->get('licenses')->result();
    }

    public function insert($data) {
        return $this->db->insert('licenses', $data);
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update('licenses', $data);
    }

    public function delete($id) {
        return $this->db->delete('licenses', ['id' => $id]);
    }

    public function get($id) {
        return $this->db->get_where('licenses', ['id' => $id])->row();
    }
}
