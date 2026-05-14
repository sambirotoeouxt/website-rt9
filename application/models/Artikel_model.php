<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->table = 'artikel';
    }

    /**
     * Get artikel by ID
     */
    public function get($id)
    {
        return $this->db->select('a.*, u.full_name as author_name')
            ->from($this->table . ' a')
            ->join('users u', 'a.author_id = u.id', 'left')
            ->where('a.id', $id)
            ->get()->row_array();
    }

    /**
     * Get artikel by slug
     */
    public function get_by_slug($slug)
    {
        return $this->db->select('a.*, u.full_name as author_name')
            ->from($this->table . ' a')
            ->join('users u', 'a.author_id = u.id', 'left')
            ->where('a.slug', $slug)
            ->get()->row_array();
    }

    /**
     * Get all published articles
     */
    public function get_all($limit = NULL, $offset = NULL, $published_only = TRUE)
    {
        $query = $this->db->select('a.*, u.full_name as author_name')
            ->from($this->table . ' a')
            ->join('users u', 'a.author_id = u.id', 'left');
        
        if ($published_only) {
            $query = $query->where('a.status', 'published');
        }
        
        $query = $query->order_by('a.created_at', 'DESC');
        
        if ($limit) {
            $query = $query->limit($limit, $offset);
        }
        
        return $query->get()->result_array();
    }

    /**
     * Count all articles
     */
    public function count_all($published_only = TRUE)
    {
        $query = $this->db;
        
        if ($published_only) {
            $query = $query->where('status', 'published');
        }
        
        return $query->count_all_results($this->table);
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
     * Increment view counter
     */
    public function increment_views($id)
    {
        $this->db->set('views', 'views+1', FALSE);
        return $this->db->where('id', $id)->update($this->table);
    }

    /**
     * Get artikel by kategori
     */
    public function get_by_category($kategori, $limit = NULL, $offset = NULL)
    {
        $query = $this->db->select('a.*, u.full_name as author_name')
            ->from($this->table . ' a')
            ->join('users u', 'a.author_id = u.id', 'left')
            ->where('a.kategori', $kategori)
            ->where('a.status', 'published')
            ->order_by('a.created_at', 'DESC');
        
        if ($limit) {
            $query = $query->limit($limit, $offset);
        }
        
        return $query->get()->result_array();
    }

    /**
     * Generate unique slug
     */
    public function generate_slug($title)
    {
        $slug = url_title($title, 'dash', TRUE);
        $count = 1;
        $original_slug = $slug;
        
        while ($this->db->where('slug', $slug)->count_all_results($this->table) > 0) {
            $slug = $original_slug . '-' . $count;
            $count++;
        }
        
        return $slug;
    }
}
