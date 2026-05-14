<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pengaturan Model
 */
class Pengaturan_model extends CI_Model {
    
    private $table = 'pengaturan';
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get all pengaturan
     */
    public function get_all() {
        $result = $this->db->get($this->table)->result_array();
        return count($result) > 0 ? $result[0] : array();
    }
    
    /**
     * Get specific pengaturan value
     */
    public function get($key) {
        $data = $this->get_all();
        return isset($data[$key]) ? $data[$key] : NULL;
    }
    
    /**
     * Update pengaturan
     */
    public function update($data) {
        // Get first record
        $result = $this->db->get($this->table)->row_array();
        
        if ($result) {
            $this->db->where('id', $result['id']);
            return $this->db->update($this->table, $data);
        } else {
            return $this->db->insert($this->table, $data);
        }
    }
}
