<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_model');
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
        $data['title'] = 'Manajemen Menu';
        $data['menu'] = $this->Menu_model->get_all();
        
        $this->load->view('admin/templates/admin_header', $data);
        $this->load->view('admin/templates/admin_sidebar');
        $this->load->view('admin/menu/index', $data);
        $this->load->view('admin/templates/admin_footer');
    }

    public function tambah()
    {
        $data['title'] = 'Tambah Menu';
        $data['menu'] = $this->Menu_model->get_all();
        
        if ($this->input->post('submit')) {
            $insert_data = array(
                'nama_menu' => $this->input->post('nama_menu'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'urutan' => $this->input->post('urutan'),
                'status' => $this->input->post('status'),
                'tipe' => $this->input->post('tipe'),
                'parent_id' => $this->input->post('parent_id') ?: NULL,
                'created_by' => $this->session->userdata('user_id')
            );

            if ($this->Menu_model->insert($insert_data)) {
                $this->session->set_flashdata('success', 'Menu berhasil ditambahkan');
                redirect('menu');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan menu');
                redirect('menu/tambah');
            }
        }

        $this->load->view('admin/templates/admin_header', $data);
        $this->load->view('admin/templates/admin_sidebar');
        $this->load->view('admin/menu/form_tambah', $data);
        $this->load->view('admin/templates/admin_footer');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Menu';
        $data['menu_item'] = $this->Menu_model->get_by_id($id);
        $data['menu'] = $this->Menu_model->get_all();

        if (empty($data['menu_item'])) {
            show_404();
        }

        if ($this->input->post('submit')) {
            $update_data = array(
                'nama_menu' => $this->input->post('nama_menu'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'urutan' => $this->input->post('urutan'),
                'status' => $this->input->post('status'),
                'tipe' => $this->input->post('tipe'),
                'parent_id' => $this->input->post('parent_id') ?: NULL
            );

            if ($this->Menu_model->update($id, $update_data)) {
                $this->session->set_flashdata('success', 'Menu berhasil diperbarui');
                redirect('menu');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui menu');
                redirect('menu/edit/' . $id);
            }
        }

        $this->load->view('admin/templates/admin_header', $data);
        $this->load->view('admin/templates/admin_sidebar');
        $this->load->view('admin/menu/form_edit', $data);
        $this->load->view('admin/templates/admin_footer');
    }

    public function hapus($id)
    {
        $menu = $this->Menu_model->get_by_id($id);
        
        if (empty($menu)) {
            show_404();
        }

        if ($this->Menu_model->delete($id)) {
            $this->session->set_flashdata('success', 'Menu berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus menu');
        }

        redirect('menu');
    }
}
