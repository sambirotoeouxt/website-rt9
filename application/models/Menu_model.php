<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Menu Model
 */
class Menu_model extends CI_Model {
    
    private $table = 'menu';
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get all menu
     */
    public function get_all() {
        $this->db->order_by('urutan', 'ASC');
        return $this->db->get($this->table)->result_array();
    }
    
    /**
     * Get menu by ID
     */
    public function get($id) {
        return $this->db->get_where($this->table, array('id' => $id))->row_array();
    }
    
    /**
     * Get active menu only
     */
    public function get_active() {
        $this->db->where('status', 1);
        $this->db->order_by('urutan', 'ASC');
        return $this->db->get($this->table)->result_array();
    }
    
    /**
     * Get parent menu (menu with no parent)
     */
    public function get_parent_menu() {
        $this->db->where('parent_id', NULL);
        $this->db->where('status', 1);
        $this->db->order_by('urutan', 'ASC');
        return $this->db->get($this->table)->result_array();
    }
    
    /**
     * Get child menu by parent ID
     */
    public function get_child_menu($parent_id) {
        $this->db->where('parent_id', $parent_id);
        $this->db->where('status', 1);
        $this->db->order_by('urutan', 'ASC');
        return $this->db->get($this->table)->result_array();
    }
    
    /**
     * Insert menu
     */
    public function insert($data) {
        return $this->db->insert($this->table, $data) ? $this->db->insert_id() : FALSE;
    }
    
    /**
     * Update menu
     */
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    
    /**
     * Delete menu
     */
    public function delete($id) {
        return $this->db->delete($this->table, array('id' => $id));
    }
    
    /**
     * Update order
     */
    public function update_order($id, $order) {
        return $this->update($id, array('urutan' => $order));
    }
}
