<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model
 * Model untuk mengelola data user
 */
class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'users';
    }

    /**
     * Get all users
     */
    public function get_all()
    {
        $this->db->order_by('id', 'DESC');
        return $this->db->get($this->table)->result_array();
    }

    /**
     * Get user by ID
     */
    public function get_by_id($id)
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
     * Insert user
     */
    public function insert($data)
    {
        // Hash password
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        return $this->db->insert($this->table, $data);
    }

    /**
     * Update user
     */
    public function update($id, $data)
    {
        // Hash password if provided
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        } else {
            unset($data['password']);
        }
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
     * Verify password
     */
    public function verify_password($password, $hash)
    {
        return password_verify($password, $hash);
    }

    /**
     * Check if username exists
     */
    public function username_exists($username, $exclude_id = null)
    {
        $this->db->where('username', $username);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->get($this->table)->num_rows() > 0;
    }

    /**
     * Check if email exists
     */
    public function email_exists($email, $exclude_id = null)
    {
        $this->db->where('email', $email);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->get($this->table)->num_rows() > 0;
    }

    /**
     * Get user count
     */
    public function get_count()
    {
        return $this->db->get($this->table)->num_rows();
    }

    /**
     * Get active users
     */
    public function get_active()
    {
        $this->db->where('is_active', 1);
        $this->db->order_by('full_name', 'ASC');
        return $this->db->get($this->table)->result_array();
    }
}
