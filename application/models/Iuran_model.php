<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Iuran_model
 * Model untuk mengelola data iuran kas RT
 */
class Iuran_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'iuran_kas';
    }

    /**
     * Get all iuran
     */
    public function get_all($limit = null, $offset = null)
    {
        $this->db->select('iuran_kas.*, penduduk.nama, penduduk.no_rumah, penduduk.rt, penduduk.rw');
        $this->db->from($this->table);
        $this->db->join('penduduk', 'iuran_kas.penduduk_id = penduduk.id');
        $this->db->order_by('iuran_kas.tahun', 'DESC');
        $this->db->order_by('iuran_kas.bulan', 'DESC');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result_array();
    }

    /**
     * Get iuran by ID
     */
    public function get_by_id($id)
    {
        $this->db->select('iuran_kas.*, penduduk.nama, penduduk.no_rumah');
        $this->db->from($this->table);
        $this->db->join('penduduk', 'iuran_kas.penduduk_id = penduduk.id');
        $this->db->where('iuran_kas.id', $id);
        return $this->db->get()->row_array();
    }

    /**
     * Get iuran by penduduk and bulan/tahun
     */
    public function get_by_penduduk_bulan($penduduk_id, $bulan, $tahun)
    {
        return $this->db->where('penduduk_id', $penduduk_id)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get($this->table)->row_array();
    }

    /**
     * Get iuran by penduduk
     */
    public function get_by_penduduk($penduduk_id)
    {
        $this->db->where('penduduk_id', $penduduk_id);
        $this->db->order_by('tahun', 'DESC');
        $this->db->order_by('bulan', 'DESC');
        return $this->db->get($this->table)->result_array();
    }

    /**
     * Insert iuran
     */
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    /**
     * Update iuran
     */
    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    /**
     * Delete iuran
     */
    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }

    /**
     * Get iuran bulan tertentu
     */
    public function get_by_bulan_tahun($bulan, $tahun, $limit = null, $offset = null)
    {
        $this->db->select('iuran_kas.*, penduduk.nama, penduduk.no_rumah, penduduk.rt, penduduk.rw');
        $this->db->from($this->table);
        $this->db->join('penduduk', 'iuran_kas.penduduk_id = penduduk.id');
        $this->db->where('iuran_kas.bulan', $bulan);
        $this->db->where('iuran_kas.tahun', $tahun);
        $this->db->order_by('penduduk.no_rumah', 'ASC');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result_array();
    }

    /**
     * Get laporan iuran per tahun
     */
    public function get_laporan_tahun($tahun)
    {
        $this->db->select('iuran_kas.*, penduduk.nama, penduduk.no_rumah, penduduk.rt');
        $this->db->from($this->table);
        $this->db->join('penduduk', 'iuran_kas.penduduk_id = penduduk.id');
        $this->db->where('iuran_kas.tahun', $tahun);
        $this->db->order_by('iuran_kas.bulan', 'ASC');
        $this->db->order_by('penduduk.no_rumah', 'ASC');
        return $this->db->get()->result_array();
    }

    /**
     * Get statistik iuran
     */
    public function get_statistik($tahun = null)
    {
        if (!$tahun) {
            $tahun = date('Y');
        }

        $result = array();

        // Total iuran
        $this->db->where('tahun', $tahun);
        $total = $this->db->select_sum('jumlah_iuran')
            ->get($this->table)->row_array();
        $result['total_iuran'] = $total['jumlah_iuran'] ?? 0;

        // Status terbayar
        $this->db->where('tahun', $tahun);
        $this->db->where('status', 'Sudah Bayar');
        $result['sudah_bayar'] = $this->db->get($this->table)->num_rows();

        // Status belum bayar
        $this->db->where('tahun', $tahun);
        $this->db->where('status', 'Belum Bayar');
        $result['belum_bayar'] = $this->db->get($this->table)->num_rows();

        // Status menunggak
        $this->db->where('tahun', $tahun);
        $this->db->where('status', 'Menunggak');
        $result['menunggak'] = $this->db->get($this->table)->num_rows();

        return $result;
    }

    /**
     * Get iuran yang belum dibayar
     */
    public function get_pending()
    {
        $this->db->select('iuran_kas.*, penduduk.nama, penduduk.no_rumah');
        $this->db->from($this->table);
        $this->db->join('penduduk', 'iuran_kas.penduduk_id = penduduk.id');
        $this->db->where_in('iuran_kas.status', array('Belum Bayar', 'Menunggak'));
        $this->db->order_by('iuran_kas.tahun', 'DESC');
        $this->db->order_by('iuran_kas.bulan', 'DESC');
        return $this->db->get()->result_array();
    }
}
