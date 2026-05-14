<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Galeri_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->table = 'galeri';
    }

    /**
     * Get galeri by ID
     */
    public function get($id)
    {
        return $this->db->select('g.*, u.full_name as uploaded_by_name')
            ->from($this->table . ' g')
            ->join('users u', 'g.uploaded_by = u.id', 'left')
            ->where('g.id', $id)
            ->get()->row_array();
    }

    /**
     * Get all galeri
     */
    public function get_all($limit = NULL, $offset = NULL, $filters = array())
    {
        $query = $this->db->select('g.*, u.full_name as uploaded_by_name')
            ->from($this->table . ' g')
            ->join('users u', 'g.uploaded_by = u.id', 'left');
        
        if (!empty($filters['kategori'])) {
            $query = $query->where('g.kategori', $filters['kategori']);
        }
        
        $query = $query->order_by('g.created_at', 'DESC');
        
        if ($limit) {
            $query = $query->limit($limit, $offset);
        }
        
        return $query->get()->result_array();
    }

    /**
     * Count all galeri
     */
    public function count_all($filters = array())
    {
        $query = $this->db;
        
        if (!empty($filters['kategori'])) {
            $query = $query->where('kategori', $filters['kategori']);
        }
        
        return $query->count_all_results($this->table);
    }

    /**
     * Insert galeri
     */
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    /**
     * Update galeri
     */
    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    /**
     * Delete galeri
     */
    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }

    /**
     * Get all categories
     */
    public function get_categories()
    {
        return $this->db->distinct()->select('kategori')
            ->where('kategori IS NOT NULL', NULL, FALSE)
            ->get($this->table)->result_array();
    }
}
