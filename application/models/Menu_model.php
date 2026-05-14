<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->table = 'menu';
    }

    /**
     * Get menu by ID
     */
    public function get($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row_array();
    }

    /**
     * Get all active menus
     */
    public function get_all($active_only = TRUE)
    {
        $query = $this->db;
        
        if ($active_only) {
            $query = $query->where('status', 1);
        }
        
        return $query->where('parent_id IS NULL', NULL, FALSE)
            ->order_by('urutan', 'ASC')
            ->get($this->table)->result_array();
    }

    /**
     * Get submenu
     */
    public function get_submenu($parent_id)
    {
        return $this->db->where('parent_id', $parent_id)
            ->where('status', 1)
            ->order_by('urutan', 'ASC')
            ->get($this->table)->result_array();
    }

    /**
     * Get menu with submenu
     */
    public function get_with_submenu($active_only = TRUE)
    {
        $menus = $this->get_all($active_only);
        
        foreach ($menus as &$menu) {
            $menu['submenu'] = $this->get_submenu($menu['id']);
        }
        
        return $menus;
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
        // Delete menu
        return $this->db->where('id', $id)->delete($this->table);
    }

    /**
     * Update menu order
     */
    public function update_order($menus)
    {
        $success = TRUE;
        foreach ($menus as $order => $id) {
            if (!$this->update($id, array('urutan' => $order))) {
                $success = FALSE;
            }
        }
        return $success;
    }
}
