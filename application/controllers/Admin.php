<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Controller - Base class for admin pages
 */
class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('User_model', 'Pengaturan_model'));
        $this->load->helper(array('form', 'url', 'security'));

        // Check if user is logged in
        if (!$this->auth->is_logged_in()) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu');
            redirect('auth/login');
        }

        // Check if user is admin
        if (!$this->auth->is_admin()) {
            show_error('Akses ditolak. Anda bukan admin.', 403);
        }
    }

    /**
     * Dashboard
     */
    public function dashboard()
    {
        $this->load->model(array('Penduduk_model', 'Iuran_model', 'Artikel_model'));

        $data['title'] = 'Dashboard';
        $data['total_penduduk'] = $this->Penduduk_model->count_all();
        $data['total_iuran_bulan_ini'] = $this->Iuran_model->count_paid_this_month();
        $data['jumlah_iuran_bulan_ini'] = $this->Iuran_model->sum_paid_this_month();
        $data['total_artikel'] = $this->Artikel_model->count_published();
        $data['user'] = $this->auth->user();
        $data['menu'] = $this->get_admin_menu();

        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('templates/admin_footer', $data);
    }

    /**
     * Get admin sidebar menu
     */
    protected function get_admin_menu()
    {
        $menus = array();

        if ($this->auth->is_superadmin()) {
            $menus[] = array('title' => 'Data Penduduk', 'icon' => 'fas fa-users', 'url' => 'admin/penduduk');
            $menus[] = array('title' => 'Iuran Kas', 'icon' => 'fas fa-money-bill-alt', 'url' => 'admin/iuran');
            $menus[] = array('title' => 'Artikel', 'icon' => 'fas fa-newspaper', 'url' => 'admin/artikel');
            $menus[] = array('title' => 'Komentar', 'icon' => 'fas fa-comments', 'url' => 'admin/komentar');
            $menus[] = array('title' => 'Galeri', 'icon' => 'fas fa-images', 'url' => 'admin/galeri');
            $menus[] = array('title' => 'Pengguna', 'icon' => 'fas fa-user-circle', 'url' => 'admin/user');
            $menus[] = array('title' => 'Menu Website', 'icon' => 'fas fa-bars', 'url' => 'admin/menu');
            $menus[] = array('title' => 'Pengaturan', 'icon' => 'fas fa-cog', 'url' => 'admin/pengaturan');
        } else {
            $menus[] = array('title' => 'Artikel', 'icon' => 'fas fa-newspaper', 'url' => 'admin/artikel');
            $menus[] = array('title' => 'Galeri', 'icon' => 'fas fa-images', 'url' => 'admin/galeri');
        }

        return $menus;
    }
}
