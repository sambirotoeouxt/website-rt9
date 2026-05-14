<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penduduk extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Penduduk_model');
        $this->load->helper('url');
        
        // Check if user is logged in and is admin
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $data['title'] = 'Data Penduduk';
        $data['penduduk'] = $this->Penduduk_model->get_all();
        $this->load->view('admin/templates/admin_header', $data);
        $this->load->view('admin/templates/admin_sidebar');
        $this->load->view('admin/penduduk/index', $data);
        $this->load->view('admin/templates/admin_footer');
    }

    public function tambah()
    {
        $data['title'] = 'Tambah Penduduk';
        
        if ($this->input->post('submit')) {
            $config['upload_path'] = './assets/uploads/penduduk/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            $foto = '';
            if (!empty($_FILES['foto']['name'])) {
                if (!$this->upload->do_upload('foto')) {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('penduduk/tambah');
                } else {
                    $upload_data = $this->upload->data();
                    $foto = $upload_data['file_name'];
                }
            }

            $insert_data = array(
                'nik' => $this->input->post('nik'),
                'nama' => $this->input->post('nama'),
                'tempat_lahir' => $this->input->post('tempat_lahir'),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'agama' => $this->input->post('agama'),
                'pekerjaan' => $this->input->post('pekerjaan'),
                'alamat' => $this->input->post('alamat'),
                'no_rumah' => $this->input->post('no_rumah'),
                'rt' => $this->input->post('rt'),
                'rw' => $this->input->post('rw'),
                'desa' => $this->input->post('desa'),
                'kecamatan' => $this->input->post('kecamatan'),
                'kabupaten' => $this->input->post('kabupaten'),
                'provinsi' => $this->input->post('provinsi'),
                'kode_pos' => $this->input->post('kode_pos'),
                'no_hp' => $this->input->post('no_hp'),
                'status_perkawinan' => $this->input->post('status_perkawinan'),
                'hubungan_keluarga' => $this->input->post('hubungan_keluarga'),
                'foto' => $foto,
                'keterangan' => $this->input->post('keterangan'),
                'created_by' => $this->session->userdata('user_id')
            );

            if ($this->Penduduk_model->insert($insert_data)) {
                $this->session->set_flashdata('success', 'Data penduduk berhasil ditambahkan');
                redirect('penduduk');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan data penduduk');
                redirect('penduduk/tambah');
            }
        }

        $this->load->view('admin/templates/admin_header', $data);
        $this->load->view('admin/templates/admin_sidebar');
        $this->load->view('admin/penduduk/form_tambah', $data);
        $this->load->view('admin/templates/admin_footer');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Penduduk';
        $data['penduduk'] = $this->Penduduk_model->get_by_id($id);

        if (empty($data['penduduk'])) {
            show_404();
        }

        if ($this->input->post('submit')) {
            $config['upload_path'] = './assets/uploads/penduduk/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            $foto = $data['penduduk']['foto'];
            if (!empty($_FILES['foto']['name'])) {
                if ($this->upload->do_upload('foto')) {
                    // Delete old file
                    if (file_exists('./assets/uploads/penduduk/' . $foto)) {
                        unlink('./assets/uploads/penduduk/' . $foto);
                    }
                    $upload_data = $this->upload->data();
                    $foto = $upload_data['file_name'];
                }
            }

            $update_data = array(
                'nik' => $this->input->post('nik'),
                'nama' => $this->input->post('nama'),
                'tempat_lahir' => $this->input->post('tempat_lahir'),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'agama' => $this->input->post('agama'),
                'pekerjaan' => $this->input->post('pekerjaan'),
                'alamat' => $this->input->post('alamat'),
                'no_rumah' => $this->input->post('no_rumah'),
                'rt' => $this->input->post('rt'),
                'rw' => $this->input->post('rw'),
                'desa' => $this->input->post('desa'),
                'kecamatan' => $this->input->post('kecamatan'),
                'kabupaten' => $this->input->post('kabupaten'),
                'provinsi' => $this->input->post('provinsi'),
                'kode_pos' => $this->input->post('kode_pos'),
                'no_hp' => $this->input->post('no_hp'),
                'status_perkawinan' => $this->input->post('status_perkawinan'),
                'hubungan_keluarga' => $this->input->post('hubungan_keluarga'),
                'foto' => $foto,
                'keterangan' => $this->input->post('keterangan')
            );

            if ($this->Penduduk_model->update($id, $update_data)) {
                $this->session->set_flashdata('success', 'Data penduduk berhasil diperbarui');
                redirect('penduduk');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui data penduduk');
                redirect('penduduk/edit/' . $id);
            }
        }

        $this->load->view('admin/templates/admin_header', $data);
        $this->load->view('admin/templates/admin_sidebar');
        $this->load->view('admin/penduduk/form_edit', $data);
        $this->load->view('admin/templates/admin_footer');
    }

    public function hapus($id)
    {
        $penduduk = $this->Penduduk_model->get_by_id($id);
        
        if (empty($penduduk)) {
            show_404();
        }

        // Delete photo if exists
        if (!empty($penduduk['foto']) && file_exists('./assets/uploads/penduduk/' . $penduduk['foto'])) {
            unlink('./assets/uploads/penduduk/' . $penduduk['foto']);
        }

        if ($this->Penduduk_model->delete($id)) {
            $this->session->set_flashdata('success', 'Data penduduk berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data penduduk');
        }

        redirect('penduduk');
    }

    public function export()
    {
        $this->load->library('excel');
        $penduduk = $this->Penduduk_model->get_all();
        
        // Create Excel file
        $this->excel->setActiveSheet(0);
        $sheet = $this->excel->getActiveSheet();
        $sheet->setTitle('Data Penduduk');
        
        // Set headers
        $headers = array('No', 'NIK', 'Nama', 'Tempat Lahir', 'Tanggal Lahir', 'Jenis Kelamin', 'Agama', 'Pekerjaan', 'Alamat', 'RT', 'RW', 'No HP');
        foreach ($headers as $key => $header) {
            $sheet->setCellValueByColumnAndRow($key + 1, 1, $header);
        }
        
        // Set data
        $row = 2;
        foreach ($penduduk as $key => $data) {
            $sheet->setCellValueByColumnAndRow(1, $row, $key + 1);
            $sheet->setCellValueByColumnAndRow(2, $row, $data['nik']);
            $sheet->setCellValueByColumnAndRow(3, $row, $data['nama']);
            $sheet->setCellValueByColumnAndRow(4, $row, $data['tempat_lahir']);
            $sheet->setCellValueByColumnAndRow(5, $row, $data['tanggal_lahir']);
            $sheet->setCellValueByColumnAndRow(6, $row, $data['jenis_kelamin']);
            $sheet->setCellValueByColumnAndRow(7, $row, $data['agama']);
            $sheet->setCellValueByColumnAndRow(8, $row, $data['pekerjaan']);
            $sheet->setCellValueByColumnAndRow(9, $row, $data['alamat']);
            $sheet->setCellValueByColumnAndRow(10, $row, $data['rt']);
            $sheet->setCellValueByColumnAndRow(11, $row, $data['rw']);
            $sheet->setCellValueByColumnAndRow(12, $row, $data['no_hp']);
            $row++;
        }
        
        $filename = 'Data_Penduduk_' . date('Y-m-d_H-i-s') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $writer->save('php://output');
    }
}
