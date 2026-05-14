<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pengaturan_model');
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
        $data['title'] = 'Pengaturan Website';
        $data['pengaturan'] = $this->Pengaturan_model->get();
        
        if ($this->input->post('submit')) {
            $config['upload_path'] = './assets/uploads/logo/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 5120;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            $logo = $data['pengaturan']['logo'];
            if (!empty($_FILES['logo']['name'])) {
                if ($this->upload->do_upload('logo')) {
                    if (file_exists('./assets/uploads/logo/' . $logo) && !empty($logo)) {
                        unlink('./assets/uploads/logo/' . $logo);
                    }
                    $upload_data = $this->upload->data();
                    $logo = $upload_data['file_name'];
                }
            }

            $update_data = array(
                'nama_website' => $this->input->post('nama_website'),
                'nama_rt' => $this->input->post('nama_rt'),
                'nama_desa' => $this->input->post('nama_desa'),
                'alamat' => $this->input->post('alamat'),
                'kecamatan' => $this->input->post('kecamatan'),
                'kabupaten' => $this->input->post('kabupaten'),
                'provinsi' => $this->input->post('provinsi'),
                'kode_pos' => $this->input->post('kode_pos'),
                'email' => $this->input->post('email'),
                'no_telepon' => $this->input->post('no_telepon'),
                'logo' => $logo,
                'deskripsi_singkat' => $this->input->post('deskripsi_singkat'),
                'footer_text' => $this->input->post('footer_text'),
                'enable_komentar' => $this->input->post('enable_komentar') ? 1 : 0,
                'enable_registrasi' => $this->input->post('enable_registrasi') ? 1 : 0,
                'auto_approve_komentar' => $this->input->post('auto_approve_komentar') ? 1 : 0,
                'items_per_page' => $this->input->post('items_per_page')
            );

            if ($this->Pengaturan_model->update($update_data)) {
                $this->session->set_flashdata('success', 'Pengaturan website berhasil disimpan');
                redirect('pengaturan');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan pengaturan');
                redirect('pengaturan');
            }
        }

        $this->load->view('admin/templates/admin_header', $data);
        $this->load->view('admin/templates/admin_sidebar');
        $this->load->view('admin/pengaturan/index', $data);
        $this->load->view('admin/templates/admin_footer');
    }
}
