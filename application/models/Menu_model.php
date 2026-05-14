<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Menu_model
 * Model untuk mengelola menu website
 */
class Menu_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'menu';
    }

    /**
     * Get all menu
     */
    public function get_all()
    {
        $this->db->where('status', 1);
        $this->db->where('parent_id', null);
        $this->db->order_by('urutan', 'ASC');
        return $this->db->get($this->table)->result_array();
    }

    /**
     * Get all menu (admin view - include inactive)
     */
    public function get_all_admin()
    {
        $this->db->where('parent_id', null);
        $this->db->order_by('urutan', 'ASC');
        return $this->db->get($this->table)->result_array();
    }

    /**
     * Get submenu
     */
    public function get_submenu($parent_id)
    {
        $this->db->where('parent_id', $parent_id);
        $this->db->where('status', 1);
        $this->db->order_by('urutan', 'ASC');
        return $this->db->get($this->table)->result_array();
    }

    /**
     * Get menu by ID
     */
    public function get_by_id($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row_array();
    }

    /**
     * Insert menu
     */
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    /**
     * Update menu
     */
    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    /**
     * Delete menu
     */
    public function delete($id)
    {
        // Delete submenu first
        $this->db->where('parent_id', $id)->delete($this->table);
        
        // Then delete menu
        return $this->db->where('id', $id)->delete($this->table);
    }

    /**
     * Get max urutan
     */
    public function get_max_urutan()
    {
        $result = $this->db->select_max('urutan')->get($this->table)->row_array();
        return isset($result['urutan']) ? $result['urutan'] + 1 : 1;
    }

    /**
     * Get total menu
     */
    public function get_count()
    {
        return $this->db->get($this->table)->num_rows();
    }

    /**
     * Reorder menu
     */
    public function update_urutan($id, $urutan)
    {
        return $this->db->where('id', $id)->update($this->table, array('urutan' => $urutan));
    }
}
