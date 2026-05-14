<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komentar_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->table = 'komentar';
    }

    /**
     * Get komentar by ID
     */
    public function get($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row_array();
    }

    /**
     * Get all komentar for artikel
     */
    public function get_by_artikel($artikel_id, $approved_only = TRUE)
    {
        $query = $this->db->where('artikel_id', $artikel_id);
        
        if ($approved_only) {
            $query = $query->where('status', 'approved');
        }
        
        return $query->order_by('created_at', 'ASC')->get($this->table)->result_array();
    }

    /**
     * Get pending komentars
     */
    public function get_pending()
    {
        return $this->db->where('status', 'pending')
            ->order_by('created_at', 'DESC')
            ->get($this->table)->result_array();
    }

    /**
     * Insert komentar
     */
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    /**
     * Update komentar
     */
    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    /**
     * Delete komentar
     */
    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }

    /**
     * Approve komentar
     */
    public function approve($id, $approved_by)
    {
        return $this->update($id, array(
            'status' => 'approved',
            'approved_by' => $approved_by,
            'updated_at' => date('Y-m-d H:i:s')
        ));
    }

    /**
     * Reject komentar
     */
    public function reject($id, $approved_by)
    {
        return $this->update($id, array(
            'status' => 'rejected',
            'approved_by' => $approved_by,
            'updated_at' => date('Y-m-d H:i:s')
        ));
    }

    /**
     * Count pending komentars
     */
    public function count_pending()
    {
        return $this->db->where('status', 'pending')->count_all_results($this->table);
    }
}
