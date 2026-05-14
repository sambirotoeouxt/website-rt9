<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Galeri extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Galeri_model');
        $this->load->helper('url');
        
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $data['title'] = 'Manajemen Galeri';
        $data['galeri'] = $this->Galeri_model->get_all();
        
        $this->load->view('admin/templates/admin_header', $data);
        $this->load->view('admin/templates/admin_sidebar');
        $this->load->view('admin/galeri/index', $data);
        $this->load->view('admin/templates/admin_footer');
    }

    public function upload()
    {
        $data['title'] = 'Upload Gambar';
        
        if ($this->input->post('submit')) {
            $config['upload_path'] = './assets/uploads/galeri/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 5120; // 5MB
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('gambar')) {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('galeri/upload');
            } else {
                $upload_data = $this->upload->data();
                
                $insert_data = array(
                    'judul' => $this->input->post('judul'),
                    'deskripsi' => $this->input->post('deskripsi'),
                    'gambar' => $upload_data['file_name'],
                    'kategori' => $this->input->post('kategori'),
                    'uploaded_by' => $this->session->userdata('user_id')
                );

                if ($this->Galeri_model->insert($insert_data)) {
                    $this->session->set_flashdata('success', 'Gambar berhasil diupload');
                    redirect('galeri');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menyimpan data gambar');
                    redirect('galeri/upload');
                }
            }
        }

        $this->load->view('admin/templates/admin_header', $data);
        $this->load->view('admin/templates/admin_sidebar');
        $this->load->view('admin/galeri/form_upload', $data);
        $this->load->view('admin/templates/admin_footer');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Galeri';
        $data['galeri'] = $this->Galeri_model->get_by_id($id);

        if (empty($data['galeri'])) {
            show_404();
        }

        if ($this->input->post('submit')) {
            $update_data = array(
                'judul' => $this->input->post('judul'),
                'deskripsi' => $this->input->post('deskripsi'),
                'kategori' => $this->input->post('kategori')
            );

            if ($this->Galeri_model->update($id, $update_data)) {
                $this->session->set_flashdata('success', 'Data galeri berhasil diperbarui');
                redirect('galeri');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui data galeri');
                redirect('galeri/edit/' . $id);
            }
        }

        $this->load->view('admin/templates/admin_header', $data);
        $this->load->view('admin/templates/admin_sidebar');
        $this->load->view('admin/galeri/form_edit', $data);
        $this->load->view('admin/templates/admin_footer');
    }

    public function hapus($id)
    {
        $galeri = $this->Galeri_model->get_by_id($id);
        
        if (empty($galeri)) {
            show_404();
        }

        if (file_exists('./assets/uploads/galeri/' . $galeri['gambar'])) {
            unlink('./assets/uploads/galeri/' . $galeri['gambar']);
        }

        if ($this->Galeri_model->delete($id)) {
            $this->session->set_flashdata('success', 'Gambar berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus gambar');
        }

        redirect('galeri');
    }
}
