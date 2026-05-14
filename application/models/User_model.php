<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User Model
 */
class User_model extends CI_Model {
    
    private $table = 'users';
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get all users
     */
    public function get_all($limit = NULL, $offset = 0) {
        $this->db->order_by('created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get($this->table)->result_array();
    }
    
    /**
     * Get user by ID
     */
    public function get($id) {
        return $this->db->get_where($this->table, array('id' => $id))->row_array();
    }
    
    /**
     * Get user by username
     */
    public function get_by_username($username) {
        return $this->db->get_where($this->table, array('username' => $username))->row_array();
    }
    
    /**
     * Get user by email
     */
    public function get_by_email($email) {
        return $this->db->get_where($this->table, array('email' => $email))->row_array();
    }
    
    /**
     * Insert user
     */
    public function insert($data) {
        return $this->db->insert($this->table, $data) ? $this->db->insert_id() : FALSE;
    }
    
    /**
     * Update user
     */
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    
    /**
     * Delete user
     */
    public function delete($id) {
        return $this->db->delete($this->table, array('id' => $id));
    }
    
    /**
     * Count total users
     */
    public function count_all() {
        return $this->db->count_all($this->table);
    }
    
    /**
     * Search users
     */
    public function search($keyword, $limit = NULL, $offset = 0) {
        $this->db->like('username', $keyword);
        $this->db->or_like('email', $keyword);
        $this->db->or_like('full_name', $keyword);
        $this->db->order_by('created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get($this->table)->result_array();
    }
    
    /**
     * Check if username exists
     */
    public function username_exists($username) {
        return $this->db->get_where($this->table, array('username' => $username))->num_rows() > 0;
    }
    
    /**
     * Check if email exists
     */
    public function email_exists($email) {
        return $this->db->get_where($this->table, array('email' => $email))->num_rows() > 0;
    }
}
