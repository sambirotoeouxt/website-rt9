<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home Controller
 * Handle public pages
 */
class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Artikel_model', 'Penduduk_model', 'Iuran_model', 'Galeri_model', 'Menu_model', 'Pengaturan_model', 'Komentar_model'));
        $this->load->helper(array('url', 'form', 'text'));
    }

    /**
     * Home page
     */
    public function index()
    {
        $data['title'] = 'Beranda - Website RT 9';
        $data['menu'] = $this->Menu_model->get_active_menu();
        $data['settings'] = $this->Pengaturan_model->get_first();
        $data['artikel_terbaru'] = $this->Artikel_model->get_published_articles(5);
        $data['total_penduduk'] = $this->Penduduk_model->count_all();
        $data['total_iuran_bulan_ini'] = $this->Iuran_model->count_paid_this_month();

        $this->load->view('templates/public_header', $data);
        $this->load->view('public/home', $data);
        $this->load->view('templates/public_footer', $data);
    }

    /**
     * Daftar artikel
     */
    public function artikel()
    {
        $page = $this->input->get('page') ? $this->input->get('page') : 0;
        $limit = 10;

        $data['title'] = 'Artikel - Website RT 9';
        $data['menu'] = $this->Menu_model->get_active_menu();
        $data['settings'] = $this->Pengaturan_model->get_first();
        $data['artikel'] = $this->Artikel_model->get_published_articles($limit, $page);
        $data['total'] = $this->Artikel_model->count_published();
        $data['limit'] = $limit;
        $data['page'] = $page;

        $this->load->view('templates/public_header', $data);
        $this->load->view('public/artikel', $data);
        $this->load->view('templates/public_footer', $data);
    }

    /**
     * Detail artikel
     */
    public function artikel_detail($slug)
    {
        $artikel = $this->Artikel_model->get_by_slug($slug);

        if (!$artikel) {
            show_404();
        }

        // Increment view count
        $this->Artikel_model->increment_views($artikel->id);

        // Get comments
        $komentar = $this->Komentar_model->get_approved_comments($artikel->id);

        // Get like count
        $likes = $this->db->where('artikel_id', $artikel->id)->count_all_results('artikel_like');

        $data['title'] = $artikel->judul . ' - Website RT 9';
        $data['menu'] = $this->Menu_model->get_active_menu();
        $data['settings'] = $this->Pengaturan_model->get_first();
        $data['artikel'] = $artikel;
        $data['komentar'] = $komentar;
        $data['likes'] = $likes;
        $data['enable_komentar'] = $this->Pengaturan_model->get_first()->enable_komentar;

        $this->load->view('templates/public_header', $data);
        $this->load->view('public/artikel_detail', $data);
        $this->load->view('templates/public_footer', $data);
    }

    /**
     * Data penduduk
     */
    public function penduduk()
    {
        $page = $this->input->get('page') ? $this->input->get('page') : 0;
        $limit = 20;
        $search = $this->input->get('search');
        $rt = $this->input->get('rt');

        if ($search) {
            $penduduk = $this->Penduduk_model->search($search, $limit, $page);
            $total = $this->Penduduk_model->search_count($search);
        } elseif ($rt) {
            $penduduk = $this->Penduduk_model->get_by_rt($rt, $limit, $page);
            $total = $this->Penduduk_model->count_by_rt($rt);
        } else {
            $penduduk = $this->Penduduk_model->get_all($limit, $page);
            $total = $this->Penduduk_model->count_all();
        }

        $data['title'] = 'Data Penduduk - Website RT 9';
        $data['menu'] = $this->Menu_model->get_active_menu();
        $data['settings'] = $this->Pengaturan_model->get_first();
        $data['penduduk'] = $penduduk;
        $data['total'] = $total;
        $data['limit'] = $limit;
        $data['page'] = $page;
        $data['search'] = $search;
        $data['rt'] = $rt;

        $this->load->view('templates/public_header', $data);
        $this->load->view('public/penduduk', $data);
        $this->load->view('templates/public_footer', $data);
    }

    /**
     * Informasi iuran kas
     */
    public function iuran()
    {
        $page = $this->input->get('page') ? $this->input->get('page') : 0;
        $limit = 20;
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun') ? $this->input->get('tahun') : date('Y');

        if ($bulan) {
            $iuran = $this->Iuran_model->get_by_month($bulan, $tahun, $limit, $page);
            $total = $this->Iuran_model->count_by_month($bulan, $tahun);
        } else {
            $iuran = $this->Iuran_model->get_all($limit, $page);
            $total = $this->Iuran_model->count_all();
        }

        $data['title'] = 'Iuran Kas RT - Website RT 9';
        $data['menu'] = $this->Menu_model->get_active_menu();
        $data['settings'] = $this->Pengaturan_model->get_first();
        $data['iuran'] = $iuran;
        $data['total'] = $total;
        $data['limit'] = $limit;
        $data['page'] = $page;
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        $this->load->view('templates/public_header', $data);
        $this->load->view('public/iuran', $data);
        $this->load->view('templates/public_footer', $data);
    }

    /**
     * Galeri
     */
    public function galeri()
    {
        $page = $this->input->get('page') ? $this->input->get('page') : 0;
        $limit = 12;
        $kategori = $this->input->get('kategori');

        if ($kategori) {
            $galeri = $this->Galeri_model->get_by_kategori($kategori, $limit, $page);
            $total = $this->Galeri_model->count_by_kategori($kategori);
        } else {
            $galeri = $this->Galeri_model->get_all($limit, $page);
            $total = $this->Galeri_model->count_all();
        }

        $data['title'] = 'Galeri - Website RT 9';
        $data['menu'] = $this->Menu_model->get_active_menu();
        $data['settings'] = $this->Pengaturan_model->get_first();
        $data['galeri'] = $galeri;
        $data['total'] = $total;
        $data['limit'] = $limit;
        $data['page'] = $page;
        $data['kategori'] = $kategori;

        $this->load->view('templates/public_header', $data);
        $this->load->view('public/galeri', $data);
        $this->load->view('templates/public_footer', $data);
    }

    /**
     * Tentang RT
     */
    public function tentang()
    {
        $data['title'] = 'Tentang RT - Website RT 9';
        $data['menu'] = $this->Menu_model->get_active_menu();
        $data['settings'] = $this->Pengaturan_model->get_first();
        $data['total_penduduk'] = $this->Penduduk_model->count_all();

        $this->load->view('templates/public_header', $data);
        $this->load->view('public/tentang', $data);
        $this->load->view('templates/public_footer', $data);
    }

    /**
     * Hubungi kami
     */
    public function kontak()
    {
        $data['title'] = 'Hubungi Kami - Website RT 9';
        $data['menu'] = $this->Menu_model->get_active_menu();
        $data['settings'] = $this->Pengaturan_model->get_first();

        $this->load->view('templates/public_header', $data);
        $this->load->view('public/kontak', $data);
        $this->load->view('templates/public_footer', $data);
    }

    /**
     * Like artikel (AJAX)
     */
    public function like_artikel()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $artikel_id = $this->input->post('artikel_id');
        $user_id = $this->auth->user_id();
        $ip_address = $this->input->ip_address();

        // Check if already liked
        $this->db->where('artikel_id', $artikel_id);
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        } else {
            $this->db->where('ip_address', $ip_address);
        }
        $existing = $this->db->get('artikel_like')->row();

        if ($existing) {
            // Unlike
            $this->db->where('id', $existing->id)->delete('artikel_like');
            $liked = FALSE;
        } else {
            // Like
            $like_data = array(
                'artikel_id' => $artikel_id,
                'user_id' => $user_id,
                'ip_address' => $ip_address
            );
            $this->db->insert('artikel_like', $like_data);
            $liked = TRUE;
        }

        // Get total likes
        $total_likes = $this->db->where('artikel_id', $artikel_id)->count_all_results('artikel_like');

        echo json_encode(array(
            'success' => TRUE,
            'liked' => $liked,
            'total_likes' => $total_likes
        ));
    }

    /**
     * Tambah komentar (AJAX)
     */
    public function komentar_artikel()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $artikel_id = $this->input->post('artikel_id');
        $isi_komentar = $this->input->post('isi_komentar');
        $user_id = $this->auth->user_id();

        if (empty($isi_komentar)) {
            echo json_encode(array('success' => FALSE, 'message' => 'Komentar tidak boleh kosong'));
            return;
        }

        $komentar_data = array(
            'artikel_id' => $artikel_id,
            'user_id' => $user_id,
            'isi_komentar' => $isi_komentar,
            'status' => $this->Pengaturan_model->get_first()->auto_approve_komentar ? 'approved' : 'pending'
        );

        if ($user_id) {
            $user = $this->auth->user();
            $komentar_data['nama_pengunjung'] = $user->full_name;
            $komentar_data['email_pengunjung'] = $user->email;
        } else {
            $komentar_data['nama_pengunjung'] = $this->input->post('nama');
            $komentar_data['email_pengunjung'] = $this->input->post('email');
        }

        $insert = $this->Komentar_model->insert($komentar_data);

        if ($insert) {
            echo json_encode(array(
                'success' => TRUE,
                'message' => $this->Pengaturan_model->get_first()->auto_approve_komentar ? 'Komentar berhasil ditambahkan' : 'Komentar Anda sedang menunggu persetujuan admin'
            ));
        } else {
            echo json_encode(array('success' => FALSE, 'message' => 'Gagal menambahkan komentar'));
        }
    }
}
