<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper('url');
        
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        // Check if user is superadmin
        if ($this->session->userdata('role') !== 'superadmin') {
            show_error('Anda tidak memiliki akses ke halaman ini', 403);
        }
    }

    public function index()
    {
        $data['title'] = 'Manajemen User';
        $data['users'] = $this->User_model->get_all();
        
        $this->load->view('admin/templates/admin_header', $data);
        $this->load->view('admin/templates/admin_sidebar');
        $this->load->view('admin/user/index', $data);
        $this->load->view('admin/templates/admin_footer');
    }

    public function tambah()
    {
        $data['title'] = 'Tambah User Baru';
        
        if ($this->input->post('submit')) {
            // Validate username and email
            if ($this->User_model->check_username_exists($this->input->post('username'))) {
                $this->session->set_flashdata('error', 'Username sudah digunakan');
                redirect('user/tambah');
            }
            
            if ($this->User_model->check_email_exists($this->input->post('email'))) {
                $this->session->set_flashdata('error', 'Email sudah terdaftar');
                redirect('user/tambah');
            }

            $insert_data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'full_name' => $this->input->post('full_name'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address'),
                'role' => $this->input->post('role'),
                'is_active' => 1
            );

            if ($this->User_model->insert($insert_data)) {
                $this->session->set_flashdata('success', 'User berhasil ditambahkan');
                redirect('user');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan user');
                redirect('user/tambah');
            }
        }

        $this->load->view('admin/templates/admin_header', $data);
        $this->load->view('admin/templates/admin_sidebar');
        $this->load->view('admin/user/form_tambah', $data);
        $this->load->view('admin/templates/admin_footer');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit User';
        $data['user'] = $this->User_model->get_by_id($id);

        if (empty($data['user'])) {
            show_404();
        }

        if ($this->input->post('submit')) {
            $update_data = array(
                'email' => $this->input->post('email'),
                'full_name' => $this->input->post('full_name'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address'),
                'role' => $this->input->post('role'),
                'is_active' => $this->input->post('is_active')
            );

            // Change password if provided
            if (!empty($this->input->post('password'))) {
                $update_data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
            }

            if ($this->User_model->update($id, $update_data)) {
                $this->session->set_flashdata('success', 'User berhasil diperbarui');
                redirect('user');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui user');
                redirect('user/edit/' . $id);
            }
        }

        $this->load->view('admin/templates/admin_header', $data);
        $this->load->view('admin/templates/admin_sidebar');
        $this->load->view('admin/user/form_edit', $data);
        $this->load->view('admin/templates/admin_footer');
    }

    public function hapus($id)
    {
        // Prevent deleting self
        if ($id == $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Anda tidak bisa menghapus akun sendiri');
            redirect('user');
        }

        if ($this->User_model->delete($id)) {
            $this->session->set_flashdata('success', 'User berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus user');
        }

        redirect('user');
    }
}
