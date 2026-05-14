<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Artikel Model
 */
class Artikel_model extends CI_Model {
    
    private $table = 'artikel';
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get all artikel
     */
    public function get_all($limit = NULL, $offset = 0) {
        $this->db->select('artikel.*, users.full_name as author_name');
        $this->db->join('users', 'users.id = artikel.author_id', 'left');
        $this->db->order_by('artikel.created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get($this->table)->result_array();
    }
    
    /**
     * Get artikel by ID
     */
    public function get($id) {
        $this->db->select('artikel.*, users.full_name as author_name');
        $this->db->join('users', 'users.id = artikel.author_id', 'left');
        return $this->db->get_where($this->table, array('artikel.id' => $id))->row_array();
    }
    
    /**
     * Get artikel by slug
     */
    public function get_by_slug($slug) {
        $this->db->select('artikel.*, users.full_name as author_name, users.avatar');
        $this->db->join('users', 'users.id = artikel.author_id', 'left');
        return $this->db->get_where($this->table, array('slug' => $slug))->row_array();
    }
    
    /**
     * Get published artikel
     */
    public function get_published($limit = NULL, $offset = 0) {
        $this->db->select('artikel.*, users.full_name as author_name');
        $this->db->join('users', 'users.id = artikel.author_id', 'left');
        $this->db->where('status', 'published');
        $this->db->order_by('artikel.created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get($this->table)->result_array();
    }
    
    /**
     * Count published artikel
     */
    public function count_published() {
        return $this->db->get_where($this->table, array('status' => 'published'))->num_rows();
    }
    
    /**
     * Count total artikel
     */
    public function count_all() {
        return $this->db->count_all($this->table);
    }
    
    /**
     * Insert artikel
     */
    public function insert($data) {
        return $this->db->insert($this->table, $data) ? $this->db->insert_id() : FALSE;
    }
    
    /**
     * Update artikel
     */
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    
    /**
     * Delete artikel
     */
    public function delete($id) {
        return $this->db->delete($this->table, array('id' => $id));
    }
    
    /**
     * Increment views
     */
    public function increment_views($id) {
        $this->db->set('views', 'views+1', FALSE);
        $this->db->where('id', $id);
        return $this->db->update($this->table);
    }
    
    /**
     * Search artikel
     */
    public function search($keyword, $limit = NULL, $offset = 0) {
        $this->db->select('artikel.*, users.full_name as author_name');
        $this->db->join('users', 'users.id = artikel.author_id', 'left');
        $this->db->like('judul', $keyword);
        $this->db->or_like('isi', $keyword);
        $this->db->order_by('artikel.created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get($this->table)->result_array();
    }
    
    /**
     * Generate unique slug
     */
    public function generate_slug($title) {
        $slug = url_title($title, '-', TRUE);
        $count = 1;
        $original_slug = $slug;
        
        while ($this->db->get_where($this->table, array('slug' => $slug))->num_rows() > 0) {
            $slug = $original_slug . '-' . $count++;
        }
        
        return $slug;
    }
}
