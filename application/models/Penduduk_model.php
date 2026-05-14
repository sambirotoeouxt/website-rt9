<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penduduk_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->table = 'penduduk';
    }

    /**
     * Get resident by ID
     */
    public function get($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row_array();
    }

    /**
     * Get resident by NIK
     */
    public function get_by_nik($nik)
    {
        return $this->db->where('nik', $nik)->get($this->table)->row_array();
    }

    /**
     * Get all residents
     */
    public function get_all($limit = NULL, $offset = NULL, $filters = array())
    {
        $query = $this->db;
        
        // Apply filters
        if (!empty($filters['rt'])) {
            $query = $query->where('rt', $filters['rt']);
        }
        if (!empty($filters['rw'])) {
            $query = $query->where('rw', $filters['rw']);
        }
        if (!empty($filters['search'])) {
            $query = $query->group_start()
                ->like('nama', $filters['search'])
                ->or_like('nik', $filters['search'])
                ->or_like('no_hp', $filters['search'])
                ->group_end();
        }
        
        $query = $query->order_by('nama', 'ASC');
        
        if ($limit) {
            $query = $query->limit($limit, $offset);
        }
        
        return $query->get($this->table)->result_array();
    }

    /**
     * Count all residents
     */
    public function count_all($filters = array())
    {
        $query = $this->db;
        
        if (!empty($filters['rt'])) {
            $query = $query->where('rt', $filters['rt']);
        }
        if (!empty($filters['rw'])) {
            $query = $query->where('rw', $filters['rw']);
        }
        if (!empty($filters['search'])) {
            $query = $query->group_start()
                ->like('nama', $filters['search'])
                ->or_like('nik', $filters['search'])
                ->or_like('no_hp', $filters['search'])
                ->group_end();
        }
        
        return $query->count_all_results($this->table);
    }

    /**
     * Insert resident
     */
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    /**
     * Update resident
     */
    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    /**
     * Delete resident
     */
    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }

    /**
     * Get total residents
     */
    public function get_total()
    {
        return $this->db->count_all($this->table);
    }

    /**
     * Get residents by RT
     */
    public function get_by_rt($rt)
    {
        return $this->db->where('rt', $rt)->order_by('nama', 'ASC')->get($this->table)->result_array();
    }
}
