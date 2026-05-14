<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->table = 'users';
    }

    /**
     * Get user by ID
     */
    public function get($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row_array();
    }

    /**
     * Get user by username
     */
    public function get_by_username($username)
    {
        return $this->db->where('username', $username)->get($this->table)->row_array();
    }

    /**
     * Get user by email
     */
    public function get_by_email($email)
    {
        return $this->db->where('email', $email)->get($this->table)->row_array();
    }

    /**
     * Get all users
     */
    public function get_all($limit = NULL, $offset = NULL)
    {
        $query = $this->db->order_by('created_at', 'DESC');
        if ($limit) {
            $query = $query->limit($limit, $offset);
        }
        return $query->get($this->table)->result_array();
    }

    /**
     * Get total users
     */
    public function count_all()
    {
        return $this->db->count_all($this->table);
    }

    /**
     * Insert user
     */
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    /**
     * Update user
     */
    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    /**
     * Delete user
     */
    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }

    /**
     * Activate user
     */
    public function activate($id)
    {
        return $this->update($id, array('is_active' => 1));
    }

    /**
     * Deactivate user
     */
    public function deactivate($id)
    {
        return $this->update($id, array('is_active' => 0));
    }
}
