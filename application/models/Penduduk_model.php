<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Penduduk Model
 */
class Penduduk_model extends CI_Model {
    
    private $table = 'penduduk';
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get all penduduk
     */
    public function get_all($limit = NULL, $offset = 0) {
        $this->db->order_by('nama', 'ASC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get($this->table)->result_array();
    }
    
    /**
     * Get penduduk by ID
     */
    public function get($id) {
        return $this->db->get_where($this->table, array('id' => $id))->row_array();
    }
    
    /**
     * Get penduduk by RT/RW
     */
    public function get_by_rt_rw($rt, $rw) {
        $this->db->where('rt', $rt);
        $this->db->where('rw', $rw);
        $this->db->order_by('nama', 'ASC');
        
        return $this->db->get($this->table)->result_array();
    }
    
    /**
     * Count total penduduk
     */
    public function count_all() {
        return $this->db->count_all($this->table);
    }
    
    /**
     * Count by RT/RW
     */
    public function count_by_rt_rw($rt, $rw) {
        return $this->db->get_where($this->table, array('rt' => $rt, 'rw' => $rw))->num_rows();
    }
    
    /**
     * Insert penduduk
     */
    public function insert($data) {
        return $this->db->insert($this->table, $data) ? $this->db->insert_id() : FALSE;
    }
    
    /**
     * Update penduduk
     */
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    
    /**
     * Delete penduduk
     */
    public function delete($id) {
        return $this->db->delete($this->table, array('id' => $id));
    }
    
    /**
     * Search penduduk
     */
    public function search($keyword, $limit = NULL, $offset = 0) {
        $this->db->like('nik', $keyword);
        $this->db->or_like('nama', $keyword);
        $this->db->or_like('no_hp', $keyword);
        $this->db->order_by('nama', 'ASC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get($this->table)->result_array();
    }
    
    /**
     * Get unik RT values
     */
    public function get_unique_rt() {
        $this->db->distinct();
        $this->db->select('rt');
        $this->db->where('rt !=', NULL);
        $this->db->order_by('rt', 'ASC');
        return $this->db->get($this->table)->result_array();
    }
}
