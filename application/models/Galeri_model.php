<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Galeri_model
 * Model untuk mengelola galeri/foto
 */
class Galeri_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'galeri';
    }

    /**
     * Get all galeri
     */
    public function get_all($limit = null, $offset = null)
    {
        $this->db->select('galeri.*, users.full_name as uploader_name');
        $this->db->from($this->table);
        $this->db->join('users', 'galeri.uploaded_by = users.id');
        $this->db->order_by('galeri.created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get()->result_array();
    }

    /**
     * Get galeri by ID
     */
    public function get_by_id($id)
    {
        $this->db->select('galeri.*, users.full_name as uploader_name');
        $this->db->from($this->table);
        $this->db->join('users', 'galeri.uploaded_by = users.id');
        $this->db->where('galeri.id', $id);
        return $this->db->get()->row_array();
    }

    /**
     * Get galeri by kategori
     */
    public function get_by_kategori($kategori, $limit = null, $offset = null)
    {
        $this->db->select('galeri.*, users.full_name as uploader_name');
        $this->db->from($this->table);
        $this->db->join('users', 'galeri.uploaded_by = users.id');
        $this->db->where('galeri.kategori', $kategori);
        $this->db->order_by('galeri.created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get()->result_array();
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
     * Get total galeri
     */
    public function get_count()
    {
        return $this->db->get($this->table)->num_rows();
    }

    /**
     * Get distinct kategori
     */
    public function get_distinct_kategori()
    {
        return $this->db->distinct()->select('kategori')
            ->where('kategori !=', '')
            ->get($this->table)->result_array();
    }

    /**
     * Get latest galeri
     */
    public function get_latest($limit = 12)
    {
        return $this->get_all($limit, 0);
    }
}
