<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Authentication Library
 * 
 * Handles user authentication, login, logout, and session management
 */
class Auth {

    private $CI;
    private $logged_in = FALSE;
    private $user_data = NULL;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('User_model');
        $this->CI->load->library('session');
        
        // Check if user is logged in
        if ($this->CI->session->userdata('user_id')) {
            $this->logged_in = TRUE;
            $this->user_data = $this->CI->session->userdata();
        }
    }

    /**
     * Login user
     * @param string $username
     * @param string $password
     * @return boolean
     */
    public function login($username, $password)
    {
        $user = $this->CI->User_model->get_by_username($username);
        
        if ($user && password_verify($password, $user['password'])) {
            if (!$user['is_active']) {
                $this->CI->session->set_flashdata('error', 'Akun Anda tidak aktif. Hubungi administrator.');
                return FALSE;
            }
            
            // Set session
            $session_data = array(
                'user_id'    => $user['id'],
                'username'   => $user['username'],
                'email'      => $user['email'],
                'full_name'  => $user['full_name'],
                'role'       => $user['role'],
                'avatar'     => $user['avatar'],
                'logged_in'  => TRUE
            );
            $this->CI->session->set_userdata($session_data);
            $this->logged_in = TRUE;
            $this->user_data = $session_data;
            
            return TRUE;
        }
        
        return FALSE;
    }

    /**
     * Register user
     * @param array $data
     * @return boolean|string
     */
    public function register($data)
    {
        // Validate
        if (empty($data['username']) || empty($data['password']) || empty($data['email']) || empty($data['full_name'])) {
            return 'Semua field harus diisi';
        }
        
        // Check if username exists
        if ($this->CI->User_model->get_by_username($data['username'])) {
            return 'Username sudah digunakan';
        }
        
        // Check if email exists
        if ($this->CI->User_model->get_by_email($data['email'])) {
            return 'Email sudah digunakan';
        }
        
        // Insert user
        $insert_data = array(
            'username'   => $data['username'],
            'email'      => $data['email'],
            'password'   => password_hash($data['password'], PASSWORD_BCRYPT),
            'full_name'  => $data['full_name'],
            'role'       => 'user',
            'is_active'  => 1
        );
        
        if ($this->CI->User_model->insert($insert_data)) {
            return TRUE;
        }
        
        return 'Gagal mendaftar. Coba lagi.';
    }

    /**
     * Logout user
     */
    public function logout()
    {
        $this->CI->session->sess_destroy();
        $this->logged_in = FALSE;
        $this->user_data = NULL;
    }

    /**
     * Check if user is logged in
     * @return boolean
     */
    public function is_logged_in()
    {
        return $this->logged_in;
    }

    /**
     * Get current user data
     * @return array|NULL
     */
    public function get_user()
    {
        return $this->user_data;
    }

    /**
     * Check if user has permission
     * @param string $role
     * @return boolean
     */
    public function has_role($role)
    {
        if (!$this->logged_in) {
            return FALSE;
        }
        
        if (is_array($role)) {
            return in_array($this->user_data['role'], $role);
        }
        
        return $this->user_data['role'] === $role;
    }

    /**
     * Check if user is admin
     * @return boolean
     */
    public function is_admin()
    {
        return $this->has_role(array('superadmin', 'admin'));
    }

    /**
     * Check if user is superadmin
     * @return boolean
     */
    public function is_superadmin()
    {
        return $this->has_role('superadmin');
    }

    /**
     * Get user ID
     * @return integer|NULL
     */
    public function get_user_id()
    {
        return $this->logged_in ? $this->user_data['user_id'] : NULL;
    }

    /**
     * Get user role
     * @return string|NULL
     */
    public function get_role()
    {
        return $this->logged_in ? $this->user_data['role'] : NULL;
    }
}
