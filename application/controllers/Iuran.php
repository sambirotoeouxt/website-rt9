<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Iuran extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Iuran_model');
        $this->load->model('Penduduk_model');
        $this->load->helper('url');
        
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $data['title'] = 'Iuran Kas RT';
        $tahun = $this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
        $bulan = $this->input->get('bulan') ? $this->input->get('bulan') : '';
        
        $data['iuran'] = $this->Iuran_model->get_all_filtered($tahun, $bulan);
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['tahun_list'] = range(2020, date('Y'));
        
        $this->load->view('admin/templates/admin_header', $data);
        $this->load->view('admin/templates/admin_sidebar');
        $this->load->view('admin/iuran/index', $data);
        $this->load->view('admin/templates/admin_footer');
    }

    public function tambah()
    {
        $data['title'] = 'Input Iuran';
        $data['penduduk'] = $this->Penduduk_model->get_all();
        
        if ($this->input->post('submit')) {
            $insert_data = array(
                'penduduk_id' => $this->input->post('penduduk_id'),
                'bulan' => $this->input->post('bulan'),
                'tahun' => $this->input->post('tahun'),
                'jumlah_iuran' => str_replace('.', '', $this->input->post('jumlah_iuran')),
                'status' => $this->input->post('status'),
                'tanggal_bayar' => $this->input->post('status') === 'Sudah Bayar' ? $this->input->post('tanggal_bayar') : NULL,
                'metode_pembayaran' => $this->input->post('metode_pembayaran'),
                'catatan' => $this->input->post('catatan'),
                'recorded_by' => $this->session->userdata('user_id')
            );

            if ($this->Iuran_model->insert($insert_data)) {
                $this->session->set_flashdata('success', 'Data iuran berhasil ditambahkan');
                redirect('iuran');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan data iuran');
                redirect('iuran/tambah');
            }
        }

        $this->load->view('admin/templates/admin_header', $data);
        $this->load->view('admin/templates/admin_sidebar');
        $this->load->view('admin/iuran/form_tambah', $data);
        $this->load->view('admin/templates/admin_footer');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Iuran';
        $data['iuran'] = $this->Iuran_model->get_by_id($id);
        $data['penduduk'] = $this->Penduduk_model->get_all();

        if (empty($data['iuran'])) {
            show_404();
        }

        if ($this->input->post('submit')) {
            $update_data = array(
                'penduduk_id' => $this->input->post('penduduk_id'),
                'bulan' => $this->input->post('bulan'),
                'tahun' => $this->input->post('tahun'),
                'jumlah_iuran' => str_replace('.', '', $this->input->post('jumlah_iuran')),
                'status' => $this->input->post('status'),
                'tanggal_bayar' => $this->input->post('status') === 'Sudah Bayar' ? $this->input->post('tanggal_bayar') : NULL,
                'metode_pembayaran' => $this->input->post('metode_pembayaran'),
                'catatan' => $this->input->post('catatan')
            );

            if ($this->Iuran_model->update($id, $update_data)) {
                $this->session->set_flashdata('success', 'Data iuran berhasil diperbarui');
                redirect('iuran');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui data iuran');
                redirect('iuran/edit/' . $id);
            }
        }

        $this->load->view('admin/templates/admin_header', $data);
        $this->load->view('admin/templates/admin_sidebar');
        $this->load->view('admin/iuran/form_edit', $data);
        $this->load->view('admin/templates/admin_footer');
    }

    public function hapus($id)
    {
        $iuran = $this->Iuran_model->get_by_id($id);
        
        if (empty($iuran)) {
            show_404();
        }

        if ($this->Iuran_model->delete($id)) {
            $this->session->set_flashdata('success', 'Data iuran berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data iuran');
        }

        redirect('iuran');
    }

    public function laporan()
    {
        $data['title'] = 'Laporan Iuran Kas';
        $tahun = $this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
        
        $data['laporan'] = $this->Iuran_model->get_laporan($tahun);
        $data['tahun'] = $tahun;
        $data['tahun_list'] = range(2020, date('Y'));
        
        $this->load->view('admin/templates/admin_header', $data);
        $this->load->view('admin/templates/admin_sidebar');
        $this->load->view('admin/iuran/laporan', $data);
        $this->load->view('admin/templates/admin_footer');
    }
}
