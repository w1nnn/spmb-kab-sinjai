<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manage_model extends CI_Model
{

	var $table = 'tbl_profil';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	public function get()
	{
		$this->db->from($this->table);
		$query = $this->db->get();
		return $query->row();
	}

	public function update($where, $data)
	{
		// Ganti nama tabel dari 'panduan' menjadi 'profil'
		return $this->db->update('tbl_profil', $data, $where);
	}
}
