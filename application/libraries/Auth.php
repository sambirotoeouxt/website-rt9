<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth Library
 * Handle user authentication, login, logout, session management
 */
class Auth
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('User_model');
    }

    /**
     * Check if user is logged in
     */
    public function is_logged_in()
    {
        return $this->CI->session->userdata('user_id') !== FALSE;
    }

    /**
     * Get current user ID
     */
    public function user_id()
    {
        return $this->CI->session->userdata('user_id');
    }

    /**
     * Get current user data
     */
    public function user()
    {
        if (!$this->is_logged_in()) {
            return NULL;
        }
        return $this->CI->User_model->get_by_id($this->user_id());
    }

    /**
     * Get current user role
     */
    public function role()
    {
        return $this->CI->session->userdata('role');
    }

    /**
     * Check if user has specific role
     */
    public function has_role($role)
    {
        return $this->role() === $role;
    }

    /**
     * Check if user is superadmin
     */
    public function is_superadmin()
    {
        return $this->role() === 'superadmin';
    }

    /**
     * Check if user is admin
     */
    public function is_admin()
    {
        return in_array($this->role(), ['superadmin', 'admin']);
    }

    /**
     * Login user
     */
    public function login($username, $password)
    {
        $user = $this->CI->User_model->get_by_username($username);

        if (!$user) {
            return FALSE;
        }

        if (!$user->is_active) {
            return FALSE;
        }

        if (!password_verify($password, $user->password)) {
            return FALSE;
        }

        // Set session
        $this->CI->session->set_userdata(array(
            'user_id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'full_name' => $user->full_name,
            'role' => $user->role,
            'avatar' => $user->avatar
        ));

        return TRUE;
    }

    /**
     * Logout user
     */
    public function logout()
    {
        $this->CI->session->sess_destroy();
    }

    /**
     * Register new user
     */
    public function register($data)
    {
        // Hash password
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['role'] = 'user';
        $data['is_active'] = 1;

        return $this->CI->User_model->insert($data);
    }
}
