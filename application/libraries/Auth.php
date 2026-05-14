<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth Library - Custom Authentication Library
 * 
 * Menangani login, logout, session, dan role management
 */
class Auth {
    
    private $CI;
    
    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->model('user_model');
    }
    
    /**
     * Login user
     * 
     * @param string $username
     * @param string $password
     * @return boolean
     */
    public function login($username, $password) {
        $user = $this->CI->user_model->get_by_username($username);
        
        if ($user && password_verify($password, $user['password'])) {
            // Set session
            $session_data = array(
                'user_id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'full_name' => $user['full_name'],
                'role' => $user['role'],
                'avatar' => $user['avatar'],
                'is_logged_in' => TRUE
            );
            
            $this->CI->session->set_userdata($session_data);
            return TRUE;
        }
        
        return FALSE;
    }
    
    /**
     * Register user baru
     * 
     * @param array $data
     * @return boolean|int
     */
    public function register($data) {
        // Hash password
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['role'] = 'user'; // Default role
        $data['is_active'] = 1;
        
        return $this->CI->user_model->insert($data);
    }
    
    /**
     * Logout user
     */
    public function logout() {
        $this->CI->session->sess_destroy();
    }
    
    /**
     * Check if user logged in
     * 
     * @return boolean
     */
    public function is_logged_in() {
        return (bool) $this->CI->session->userdata('is_logged_in');
    }
    
    /**
     * Get user ID from session
     * 
     * @return int|null
     */
    public function get_user_id() {
        return $this->CI->session->userdata('user_id');
    }
    
    /**
     * Get user role from session
     * 
     * @return string|null
     */
    public function get_role() {
        return $this->CI->session->userdata('role');
    }
    
    /**
     * Get user info from session
     * 
     * @return array|null
     */
    public function get_user() {
        if ($this->is_logged_in()) {
            return array(
                'id' => $this->CI->session->userdata('user_id'),
                'username' => $this->CI->session->userdata('username'),
                'email' => $this->CI->session->userdata('email'),
                'full_name' => $this->CI->session->userdata('full_name'),
                'role' => $this->CI->session->userdata('role'),
                'avatar' => $this->CI->session->userdata('avatar')
            );
        }
        return NULL;
    }
    
    /**
     * Check if user is admin
     * 
     * @return boolean
     */
    public function is_admin() {
        return $this->get_role() === 'admin' || $this->is_superadmin();
    }
    
    /**
     * Check if user is superadmin
     * 
     * @return boolean
     */
    public function is_superadmin() {
        return $this->get_role() === 'superadmin';
    }
    
    /**
     * Update user profile
     * 
     * @param int $user_id
     * @param array $data
     * @return boolean
     */
    public function update_profile($user_id, $data) {
        $user = $this->CI->user_model->get($user_id);
        
        if (!$user) {
            return FALSE;
        }
        
        // If password is provided, hash it
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        } else {
            unset($data['password']);
        }
        
        return $this->CI->user_model->update($user_id, $data);
    }
    
    /**
     * Change password
     * 
     * @param int $user_id
     * @param string $old_password
     * @param string $new_password
     * @return boolean
     */
    public function change_password($user_id, $old_password, $new_password) {
        $user = $this->CI->user_model->get($user_id);
        
        if (!$user || !password_verify($old_password, $user['password'])) {
            return FALSE;
        }
        
        $data = array(
            'password' => password_hash($new_password, PASSWORD_BCRYPT)
        );
        
        return $this->CI->user_model->update($user_id, $data);
    }
    
    /**
     * Require login
     * Redirect ke login jika belum login
     */
    public function require_login() {
        if (!$this->is_logged_in()) {
            redirect('auth/login');
        }
    }
    
    /**
     * Require admin
     * Redirect ke home jika bukan admin
     */
    public function require_admin() {
        $this->require_login();
        
        if (!$this->is_admin()) {
            show_404();
        }
    }
    
    /**
     * Require superadmin
     * Redirect ke home jika bukan superadmin
     */
    public function require_superadmin() {
        $this->require_login();
        
        if (!$this->is_superadmin()) {
            show_404();
        }
    }
}
