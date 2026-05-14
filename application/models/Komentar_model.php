<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Komentar_model
 * Model untuk mengelola komentar artikel
 */
class Komentar_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'komentar';
    }

    /**
     * Get all komentar
     */
    public function get_all($limit = null, $offset = null)
    {
        $this->db->select('komentar.*, artikel.judul, users.full_name');
        $this->db->from($this->table);
        $this->db->join('artikel', 'komentar.artikel_id = artikel.id');
        $this->db->join('users', 'komentar.user_id = users.id', 'left');
        $this->db->order_by('komentar.created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get()->result_array();
    }

    /**
     * Get komentar by artikel
     */
    public function get_by_artikel($artikel_id, $status = 'approved')
    {
        $this->db->where('artikel_id', $artikel_id);
        if ($status) {
            $this->db->where('status', $status);
        }
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get($this->table)->result_array();
    }

    /**
     * Get komentar by ID
     */
    public function get_by_id($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row_array();
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
    public function approve($id, $user_id)
    {
        return $this->db->where('id', $id)->update($this->table, array(
            'status' => 'approved',
            'approved_by' => $user_id
        ));
    }

    /**
     * Reject komentar
     */
    public function reject($id)
    {
        return $this->db->where('id', $id)->update($this->table, array(
            'status' => 'rejected'
        ));
    }

    /**
     * Get pending komentar count
     */
    public function get_pending_count()
    {
        return $this->db->where('status', 'pending')->get($this->table)->num_rows();
    }

    /**
     * Get pending komentar
     */
    public function get_pending($limit = 10, $offset = 0)
    {
        $this->db->where('status', 'pending');
        $this->db->order_by('created_at', 'ASC');
        $this->db->limit($limit, $offset);
        return $this->db->get($this->table)->result_array();
    }
}
