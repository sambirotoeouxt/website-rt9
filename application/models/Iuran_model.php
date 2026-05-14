<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Iuran_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->table = 'iuran_kas';
    }

    /**
     * Get iuran by ID
     */
    public function get($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row_array();
    }

    /**
     * Get all iuran
     */
    public function get_all($limit = NULL, $offset = NULL, $filters = array())
    {
        $query = $this->db->select('i.*, p.nama as penduduk_nama')
            ->from($this->table . ' i')
            ->join('penduduk p', 'i.penduduk_id = p.id', 'left');
        
        if (!empty($filters['tahun'])) {
            $query = $query->where('i.tahun', $filters['tahun']);
        }
        if (!empty($filters['bulan'])) {
            $query = $query->where('i.bulan', $filters['bulan']);
        }
        if (!empty($filters['status'])) {
            $query = $query->where('i.status', $filters['status']);
        }
        if (!empty($filters['penduduk_id'])) {
            $query = $query->where('i.penduduk_id', $filters['penduduk_id']);
        }
        
        $query = $query->order_by('i.tahun', 'DESC')->order_by('i.bulan', 'DESC');
        
        if ($limit) {
            $query = $query->limit($limit, $offset);
        }
        
        return $query->get()->result_array();
    }

    /**
     * Count all iuran
     */
    public function count_all($filters = array())
    {
        $query = $this->db->select('i.*, p.nama as penduduk_nama')
            ->from($this->table . ' i')
            ->join('penduduk p', 'i.penduduk_id = p.id', 'left');
        
        if (!empty($filters['tahun'])) {
            $query = $query->where('i.tahun', $filters['tahun']);
        }
        if (!empty($filters['bulan'])) {
            $query = $query->where('i.bulan', $filters['bulan']);
        }
        if (!empty($filters['status'])) {
            $query = $query->where('i.status', $filters['status']);
        }
        
        return $query->count_all_results();
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
     * Get iuran by penduduk and bulan-tahun
     */
    public function get_by_penduduk_bulan($penduduk_id, $bulan, $tahun)
    {
        return $this->db->where(array(
            'penduduk_id' => $penduduk_id,
            'bulan' => $bulan,
            'tahun' => $tahun
        ))->get($this->table)->row_array();
    }

    /**
     * Get iuran summary by status
     */
    public function get_summary_by_status()
    {
        return $this->db->select('status, COUNT(*) as total, SUM(jumlah_iuran) as jumlah')
            ->where('tahun', date('Y'))
            ->group_by('status')
            ->get($this->table)->result_array();
    }

    /**
     * Get total collected iuran
     */
    public function get_total_collected($tahun = NULL)
    {
        $query = $this->db->select('SUM(jumlah_iuran) as total')
            ->where('status', 'Sudah Bayar');
        
        if ($tahun) {
            $query = $query->where('tahun', $tahun);
        } else {
            $query = $query->where('tahun', date('Y'));
        }
        
        $result = $query->get($this->table)->row_array();
        return $result['total'] ? $result['total'] : 0;
    }
}
