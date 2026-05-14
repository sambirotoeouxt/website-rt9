<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Iuran Model
 */
class Iuran_model extends CI_Model {
    
    private $table = 'iuran_kas';
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get all iuran
     */
    public function get_all($limit = NULL, $offset = 0) {
        $this->db->select('iuran_kas.*, penduduk.nama');
        $this->db->join('penduduk', 'penduduk.id = iuran_kas.penduduk_id');
        $this->db->order_by('iuran_kas.tahun', 'DESC');
        $this->db->order_by('iuran_kas.bulan', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get($this->table)->result_array();
    }
    
    /**
     * Get iuran by ID
     */
    public function get($id) {
        $this->db->select('iuran_kas.*, penduduk.nama, penduduk.no_rumah');
        $this->db->join('penduduk', 'penduduk.id = iuran_kas.penduduk_id');
        return $this->db->get_where($this->table, array('iuran_kas.id' => $id))->row_array();
    }
    
    /**
     * Get iuran by penduduk ID
     */
    public function get_by_penduduk($penduduk_id, $limit = NULL, $offset = 0) {
        $this->db->where('penduduk_id', $penduduk_id);
        $this->db->order_by('tahun', 'DESC');
        $this->db->order_by('bulan', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get($this->table)->result_array();
    }
    
    /**
     * Get iuran by bulan & tahun
     */
    public function get_by_bulan_tahun($bulan, $tahun) {
        $this->db->select('iuran_kas.*, penduduk.nama, penduduk.no_rumah');
        $this->db->join('penduduk', 'penduduk.id = iuran_kas.penduduk_id');
        $this->db->where('bulan', $bulan);
        $this->db->where('tahun', $tahun);
        $this->db->order_by('penduduk.no_rumah', 'ASC');
        
        return $this->db->get($this->table)->result_array();
    }
    
    /**
     * Count total iuran
     */
    public function count_all() {
        return $this->db->count_all($this->table);
    }
    
    /**
     * Count by status
     */
    public function count_by_status($status) {
        return $this->db->get_where($this->table, array('status' => $status))->num_rows();
    }
    
    /**
     * Insert iuran
     */
    public function insert($data) {
        return $this->db->insert($this->table, $data) ? $this->db->insert_id() : FALSE;
    }
    
    /**
     * Update iuran
     */
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    
    /**
     * Delete iuran
     */
    public function delete($id) {
        return $this->db->delete($this->table, array('id' => $id));
    }
    
    /**
     * Total iuran by status
     */
    public function total_by_status($status) {
        $this->db->select_sum('jumlah_iuran');
        $this->db->where('status', $status);
        $result = $this->db->get($this->table)->row_array();
        return $result['jumlah_iuran'] ? $result['jumlah_iuran'] : 0;
    }
    
    /**
     * Get iuran summary by status
     */
    public function get_summary_by_status() {
        $this->db->select('status, COUNT(*) as count, SUM(jumlah_iuran) as total');
        $this->db->group_by('status');
        return $this->db->get($this->table)->result_array();
    }
}
