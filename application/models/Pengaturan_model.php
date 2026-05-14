<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->table = 'pengaturan';
    }

    /**
     * Get all settings
     */
    public function get_all()
    {
        $result = $this->db->get($this->table)->row_array();
        return $result ? $result : array();
    }

    /**
     * Get setting by key
     */
    public function get($key)
    {
        $settings = $this->get_all();
        return isset($settings[$key]) ? $settings[$key] : NULL;
    }

    /**
     * Update settings
     */
    public function update($data)
    {
        $settings = $this->get_all();
        
        if ($settings) {
            return $this->db->update($this->table, $data);
        } else {
            return $this->db->insert($this->table, $data);
        }
    }

    /**
     * Update single setting
     */
    public function update_setting($key, $value)
    {
        return $this->update(array($key => $value));
    }
}
