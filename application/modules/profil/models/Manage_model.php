<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_model extends CI_Model {
	
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
	
	public function update($where,$data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}
	

	
	
}
