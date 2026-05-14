<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Artikel_model');
        $this->load->helper(array('url', 'text'));
        
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $data['title'] = 'Manajemen Artikel';
        $data['artikel'] = $this->Artikel_model->get_all();
        
        $this->load->view('admin/templates/admin_header', $data);
        $this->load->view('admin/templates/admin_sidebar');
        $this->load->view('admin/artikel/index', $data);
        $this->load->view('admin/templates/admin_footer');
    }

    public function tambah()
    {
        $data['title'] = 'Tulis Artikel Baru';
        
        if ($this->input->post('submit')) {
            $config['upload_path'] = './assets/uploads/artikel/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            $gambar = '';
            if (!empty($_FILES['gambar']['name'])) {
                if (!$this->upload->do_upload('gambar')) {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('artikel/tambah');
                } else {
                    $upload_data = $this->upload->data();
                    $gambar = $upload_data['file_name'];
                }
            }

            $slug = url_title($this->input->post('judul'), 'dash', true);
            
            $insert_data = array(
                'judul' => $this->input->post('judul'),
                'slug' => $slug,
                'isi' => $this->input->post('isi'),
                'gambar' => $gambar,
                'kategori' => $this->input->post('kategori'),
                'status' => $this->input->post('status'),
                'author_id' => $this->session->userdata('user_id')
            );

            if ($this->Artikel_model->insert($insert_data)) {
                $this->session->set_flashdata('success', 'Artikel berhasil dipublikasikan');
                redirect('artikel');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan artikel');
                redirect('artikel/tambah');
            }
        }

        $this->load->view('admin/templates/admin_header', $data);
        $this->load->view('admin/templates/admin_sidebar');
        $this->load->view('admin/artikel/form_tambah', $data);
        $this->load->view('admin/templates/admin_footer');
    }

    public function edit($slug)
    {
        $data['title'] = 'Edit Artikel';
        $data['artikel'] = $this->Artikel_model->get_by_slug($slug);

        if (empty($data['artikel'])) {
            show_404();
        }

        if ($this->input->post('submit')) {
            $config['upload_path'] = './assets/uploads/artikel/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            $gambar = $data['artikel']['gambar'];
            if (!empty($_FILES['gambar']['name'])) {
                if ($this->upload->do_upload('gambar')) {
                    if (file_exists('./assets/uploads/artikel/' . $gambar)) {
                        unlink('./assets/uploads/artikel/' . $gambar);
                    }
                    $upload_data = $this->upload->data();
                    $gambar = $upload_data['file_name'];
                }
            }

            $slug = url_title($this->input->post('judul'), 'dash', true);
            
            $update_data = array(
                'judul' => $this->input->post('judul'),
                'slug' => $slug,
                'isi' => $this->input->post('isi'),
                'gambar' => $gambar,
                'kategori' => $this->input->post('kategori'),
                'status' => $this->input->post('status')
            );

            if ($this->Artikel_model->update($data['artikel']['id'], $update_data)) {
                $this->session->set_flashdata('success', 'Artikel berhasil diperbarui');
                redirect('artikel');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui artikel');
                redirect('artikel/edit/' . $slug);
            }
        }

        $this->load->view('admin/templates/admin_header', $data);
        $this->load->view('admin/templates/admin_sidebar');
        $this->load->view('admin/artikel/form_edit', $data);
        $this->load->view('admin/templates/admin_footer');
    }

    public function hapus($id)
    {
        $artikel = $this->Artikel_model->get_by_id($id);
        
        if (empty($artikel)) {
            show_404();
        }

        if (!empty($artikel['gambar']) && file_exists('./assets/uploads/artikel/' . $artikel['gambar'])) {
            unlink('./assets/uploads/artikel/' . $artikel['gambar']);
        }

        if ($this->Artikel_model->delete($id)) {
            $this->session->set_flashdata('success', 'Artikel berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus artikel');
        }

        redirect('artikel');
    }
}
