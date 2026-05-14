<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komentar extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Komentar_model');
        $this->load->helper('url');
        
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $data['title'] = 'Moderasi Komentar';
        $data['komentar'] = $this->Komentar_model->get_all_pending();
        
        $this->load->view('admin/templates/admin_header', $data);
        $this->load->view('admin/templates/admin_sidebar');
        $this->load->view('admin/komentar/index', $data);
        $this->load->view('admin/templates/admin_footer');
    }

    public function approve($id)
    {
        $komentar = $this->Komentar_model->get_by_id($id);
        
        if (empty($komentar)) {
            show_404();
        }

        $update_data = array(
            'status' => 'approved',
            'approved_by' => $this->session->userdata('user_id')
        );

        if ($this->Komentar_model->update($id, $update_data)) {
            $this->session->set_flashdata('success', 'Komentar berhasil disetujui');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyetujui komentar');
        }

        redirect('komentar');
    }

    public function reject($id)
    {
        $komentar = $this->Komentar_model->get_by_id($id);
        
        if (empty($komentar)) {
            show_404();
        }

        $update_data = array(
            'status' => 'rejected',
            'approved_by' => $this->session->userdata('user_id')
        );

        if ($this->Komentar_model->update($id, $update_data)) {
            $this->session->set_flashdata('success', 'Komentar berhasil ditolak');
        } else {
            $this->session->set_flashdata('error', 'Gagal menolak komentar');
        }

        redirect('komentar');
    }

    public function hapus($id)
    {
        $komentar = $this->Komentar_model->get_by_id($id);
        
        if (empty($komentar)) {
            show_404();
        }

        if ($this->Komentar_model->delete($id)) {
            $this->session->set_flashdata('success', 'Komentar berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus komentar');
        }

        redirect('komentar');
    }
}
