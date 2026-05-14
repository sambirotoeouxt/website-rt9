<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pengaturan_model
 * Model untuk mengelola pengaturan website
 */
class Pengaturan_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'pengaturan';
    }

    /**
     * Get all pengaturan
     */
    public function get_all()
    {
        return $this->db->get($this->table)->row_array();
    }

    /**
     * Get by key
     */
    public function get($key)
    {
        $result = $this->db->get($this->table)->row_array();
        return isset($result[$key]) ? $result[$key] : null;
    }

    /**
     * Update pengaturan
     */
    public function update($data)
    {
        $id = 1; // Assuming single row
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    /**
     * Get pengaturan kominfo
     */
    public function get_kontak_info()
    {
        $result = $this->db->get($this->table)->row_array();
        return array(
            'email' => $result['email'] ?? '',
            'no_telepon' => $result['no_telepon'] ?? '',
            'alamat' => $result['alamat'] ?? '',
        );
    }
}
