<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth Controller
 * Handle login, logout, register
 */
class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper(array('form', 'url', 'security'));
    }

    /**
     * Login page
     */
    public function login()
    {
        if ($this->auth->is_logged_in()) {
            redirect('admin');
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

            if ($this->form_validation->run() === FALSE) {
                $data['title'] = 'Login';
                $data['errors'] = validation_errors();
                $this->load->view('auth/login', $data);
            } else {
                $username = $this->input->post('username');
                $password = $this->input->post('password');

                if ($this->auth->login($username, $password)) {
                    $this->session->set_flashdata('success', 'Selamat datang ' . $this->auth->user()->full_name);
                    redirect('admin');
                } else {
                    $this->session->set_flashdata('error', 'Username atau password salah');
                    redirect('auth/login');
                }
            }
        } else {
            $data['title'] = 'Login';
            $data['settings'] = $this->db->get('pengaturan')->row();
            $this->load->view('auth/login', $data);
        }
    }

    /**
     * Register page
     */
    public function register()
    {
        if ($this->auth->is_logged_in()) {
            redirect('admin');
        }

        // Check if registration enabled
        $settings = $this->db->get('pengaturan')->row();
        if (!$settings->enable_registrasi) {
            show_404();
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('full_name', 'Nama Lengkap', 'required|min_length[5]');
            $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|is_unique[users.username]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'required|matches[password]');

            if ($this->form_validation->run() === FALSE) {
                $data['title'] = 'Registrasi';
                $data['errors'] = validation_errors();
                $data['settings'] = $settings;
                $this->load->view('auth/register', $data);
            } else {
                $reg_data = array(
                    'full_name' => $this->input->post('full_name'),
                    'username' => $this->input->post('username'),
                    'email' => $this->input->post('email'),
                    'password' => $this->input->post('password')
                );

                if ($this->auth->register($reg_data)) {
                    $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login.');
                    redirect('auth/login');
                } else {
                    $this->session->set_flashdata('error', 'Registrasi gagal. Silakan coba lagi.');
                    redirect('auth/register');
                }
            }
        } else {
            $data['title'] = 'Registrasi';
            $data['settings'] = $settings;
            $this->load->view('auth/register', $data);
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        $this->auth->logout();
        $this->session->set_flashdata('success', 'Anda berhasil logout');
        redirect('home');
    }
}
