<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Galeri Model
 */
class Galeri_model extends CI_Model {
    
    private $table = 'galeri';
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get all galeri
     */
    public function get_all($limit = NULL, $offset = 0) {
        $this->db->select('galeri.*, users.full_name as uploader_name');
        $this->db->join('users', 'users.id = galeri.uploaded_by', 'left');
        $this->db->order_by('galeri.created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get($this->table)->result_array();
    }
    
    /**
     * Get galeri by ID
     */
    public function get($id) {
        $this->db->select('galeri.*, users.full_name as uploader_name');
        $this->db->join('users', 'users.id = galeri.uploaded_by', 'left');
        return $this->db->get_where($this->table, array('galeri.id' => $id))->row_array();
    }
    
    /**
     * Get galeri by kategori
     */
    public function get_by_kategori($kategori, $limit = NULL, $offset = 0) {
        $this->db->where('kategori', $kategori);
        $this->db->order_by('created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get($this->table)->result_array();
    }
    
    /**
     * Count total galeri
     */
    public function count_all() {
        return $this->db->count_all($this->table);
    }
    
    /**
     * Count by kategori
     */
    public function count_by_kategori($kategori) {
        return $this->db->get_where($this->table, array('kategori' => $kategori))->num_rows();
    }
    
    /**
     * Insert galeri
     */
    public function insert($data) {
        return $this->db->insert($this->table, $data) ? $this->db->insert_id() : FALSE;
    }
    
    /**
     * Update galeri
     */
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    
    /**
     * Delete galeri
     */
    public function delete($id) {
        return $this->db->delete($this->table, array('id' => $id));
    }
    
    /**
     * Get unik kategori
     */
    public function get_unique_kategori() {
        $this->db->distinct();
        $this->db->select('kategori');
        $this->db->where('kategori !=', NULL);
        $this->db->order_by('kategori', 'ASC');
        return $this->db->get($this->table)->result_array();
    }
}
