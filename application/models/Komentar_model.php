<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Komentar Model
 */
class Komentar_model extends CI_Model {
    
    private $table = 'komentar';
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get all komentar
     */
    public function get_all($limit = NULL, $offset = 0) {
        $this->db->select('komentar.*, artikel.judul as artikel_judul, users.full_name');
        $this->db->join('artikel', 'artikel.id = komentar.artikel_id', 'left');
        $this->db->join('users', 'users.id = komentar.user_id', 'left');
        $this->db->order_by('komentar.created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get($this->table)->result_array();
    }
    
    /**
     * Get komentar by ID
     */
    public function get($id) {
        $this->db->select('komentar.*, artikel.judul as artikel_judul');
        $this->db->join('artikel', 'artikel.id = komentar.artikel_id', 'left');
        return $this->db->get_where($this->table, array('komentar.id' => $id))->row_array();
    }
    
    /**
     * Get komentar by artikel
     */
    public function get_by_artikel($artikel_id, $status = 'approved') {
        $this->db->where('artikel_id', $artikel_id);
        if ($status) {
            $this->db->where('status', $status);
        }
        $this->db->order_by('created_at', 'DESC');
        
        return $this->db->get($this->table)->result_array();
    }
    
    /**
     * Count komentar by artikel
     */
    public function count_by_artikel($artikel_id) {
        return $this->db->get_where($this->table, array('artikel_id' => $artikel_id, 'status' => 'approved'))->num_rows();
    }
    
    /**
     * Count pending komentar
     */
    public function count_pending() {
        return $this->db->get_where($this->table, array('status' => 'pending'))->num_rows();
    }
    
    /**
     * Insert komentar
     */
    public function insert($data) {
        return $this->db->insert($this->table, $data) ? $this->db->insert_id() : FALSE;
    }
    
    /**
     * Update komentar
     */
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    
    /**
     * Delete komentar
     */
    public function delete($id) {
        return $this->db->delete($this->table, array('id' => $id));
    }
    
    /**
     * Approve komentar
     */
    public function approve($id, $user_id) {
        $data = array(
            'status' => 'approved',
            'approved_by' => $user_id
        );
        return $this->update($id, $data);
    }
    
    /**
     * Reject komentar
     */
    public function reject($id) {
        return $this->update($id, array('status' => 'rejected'));
    }
}
