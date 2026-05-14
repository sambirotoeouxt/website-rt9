<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Penduduk_model
 * Model untuk mengelola data penduduk RT
 */
class Penduduk_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'penduduk';
    }

    /**
     * Get all penduduk
     */
    public function get_all($limit = null, $offset = null)
    {
        $this->db->order_by('nama', 'ASC');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get($this->table)->result_array();
    }

    /**
     * Get penduduk by ID
     */
    public function get_by_id($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row_array();
    }

    /**
     * Get penduduk by NIK
     */
    public function get_by_nik($nik)
    {
        return $this->db->where('nik', $nik)->get($this->table)->row_array();
    }

    /**
     * Search penduduk
     */
    public function search($keyword, $limit = 10, $offset = 0)
    {
        $this->db->like('nama', $keyword);
        $this->db->or_like('nik', $keyword);
        $this->db->or_like('alamat', $keyword);
        $this->db->or_like('no_hp', $keyword);
        $this->db->limit($limit, $offset);
        $this->db->order_by('nama', 'ASC');
        return $this->db->get($this->table)->result_array();
    }

    /**
     * Filter by RT/RW
     */
    public function get_by_rt_rw($rt, $rw = null)
    {
        $this->db->where('rt', $rt);
        if ($rw) {
            $this->db->where('rw', $rw);
        }
        $this->db->order_by('nama', 'ASC');
        return $this->db->get($this->table)->result_array();
    }

    /**
     * Insert penduduk
     */
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    /**
     * Update penduduk
     */
    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    /**
     * Delete penduduk
     */
    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }

    /**
     * Get total penduduk
     */
    public function get_count()
    {
        return $this->db->get($this->table)->num_rows();
    }

    /**
     * Get count by gender
     */
    public function get_count_by_gender($gender)
    {
        return $this->db->where('jenis_kelamin', $gender)->get($this->table)->num_rows();
    }

    /**
     * Get penduduk dengan join user (untuk created_by)
     */
    public function get_with_creator($limit = null, $offset = null)
    {
        $this->db->select('penduduk.*, users.full_name as creator_name');
        $this->db->from($this->table);
        $this->db->join('users', 'penduduk.created_by = users.id', 'left');
        $this->db->order_by('penduduk.nama', 'ASC');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result_array();
    }

    /**
     * Get distinct RT
     */
    public function get_distinct_rt()
    {
        return $this->db->distinct()->select('rt')->where('rt !=', '')->get($this->table)->result_array();
    }

    /**
     * Get distinct RW
     */
    public function get_distinct_rw()
    {
        return $this->db->distinct()->select('rw')->where('rw !=', '')->get($this->table)->result_array();
    }
}
