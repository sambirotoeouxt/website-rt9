<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Artikel_model
 * Model untuk mengelola artikel dan kegiatan RT
 */
class Artikel_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'artikel';
    }

    /**
     * Get all artikel
     */
    public function get_all($limit = null, $offset = null, $status = null)
    {
        $this->db->select('artikel.*, users.full_name as author_name');
        $this->db->from($this->table);
        $this->db->join('users', 'artikel.author_id = users.id');
        
        if ($status) {
            $this->db->where('artikel.status', $status);
        }
        
        $this->db->order_by('artikel.created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get()->result_array();
    }

    /**
     * Get artikel by ID
     */
    public function get_by_id($id)
    {
        $this->db->select('artikel.*, users.full_name as author_name');
        $this->db->from($this->table);
        $this->db->join('users', 'artikel.author_id = users.id');
        $this->db->where('artikel.id', $id);
        return $this->db->get()->row_array();
    }

    /**
     * Get artikel by slug
     */
    public function get_by_slug($slug)
    {
        $this->db->select('artikel.*, users.full_name as author_name');
        $this->db->from($this->table);
        $this->db->join('users', 'artikel.author_id = users.id');
        $this->db->where('artikel.slug', $slug);
        $this->db->where('artikel.status', 'published');
        return $this->db->get()->row_array();
    }

    /**
     * Get published artikel
     */
    public function get_published($limit = null, $offset = null)
    {
        return $this->get_all($limit, $offset, 'published');
    }

    /**
     * Get artikel by kategori
     */
    public function get_by_kategori($kategori, $limit = 10, $offset = 0)
    {
        $this->db->select('artikel.*, users.full_name as author_name');
        $this->db->from($this->table);
        $this->db->join('users', 'artikel.author_id = users.id');
        $this->db->where('artikel.kategori', $kategori);
        $this->db->where('artikel.status', 'published');
        $this->db->order_by('artikel.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();
    }

    /**
     * Search artikel
     */
    public function search($keyword, $limit = 10, $offset = 0)
    {
        $this->db->select('artikel.*, users.full_name as author_name');
        $this->db->from($this->table);
        $this->db->join('users', 'artikel.author_id = users.id');
        $this->db->like('artikel.judul', $keyword);
        $this->db->or_like('artikel.isi', $keyword);
        $this->db->where('artikel.status', 'published');
        $this->db->order_by('artikel.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();
    }

    /**
     * Insert artikel
     */
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    /**
     * Update artikel
     */
    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    /**
     * Delete artikel
     */
    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }

    /**
     * Increment views
     */
    public function increment_views($id)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, array('views' => $this->db->query("SELECT views FROM {$this->table} WHERE id = {$id}")->row()->views + 1));
        return $this->db->affected_rows() > 0;
    }

    /**
     * Get total artikel
     */
    public function get_count($status = null)
    {
        if ($status) {
            $this->db->where('status', $status);
        }
        return $this->db->get($this->table)->num_rows();
    }

    /**
     * Get latest artikel
     */
    public function get_latest($limit = 5)
    {
        return $this->get_published($limit, 0);
    }

    /**
     * Get most viewed artikel
     */
    public function get_most_viewed($limit = 5)
    {
        $this->db->select('artikel.*, users.full_name as author_name');
        $this->db->from($this->table);
        $this->db->join('users', 'artikel.author_id = users.id');
        $this->db->where('artikel.status', 'published');
        $this->db->order_by('artikel.views', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    /**
     * Generate unique slug
     */
    public function generate_slug($title, $exclude_id = null)
    {
        $slug = url_title($title, 'dash', true);
        $original_slug = $slug;
        $counter = 1;

        while ($this->slug_exists($slug, $exclude_id)) {
            $slug = $original_slug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Check if slug exists
     */
    public function slug_exists($slug, $exclude_id = null)
    {
        $this->db->where('slug', $slug);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->get($this->table)->num_rows() > 0;
    }
}
