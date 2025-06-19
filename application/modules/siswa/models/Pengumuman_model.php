<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengumuman_model extends CI_Model {
	
	var $table = 'tbl_siswa';
	var $column_order = array('id_siswa',null);
	var $column_search = array('nama_siswa' ); 
	var $order = array('id_siswa' => 'DESC'); 
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	private function _get_datatables_query()
	{
		$npsn = $this->input->get('npsn');
		$this->db->select('*');
		$this->db->from('tbl_siswa');
		$this->db->where('pilihan_sekolah_1',$npsn);
		$this->db->where('lock','y');
		
		$i = 0;
		
		foreach ($this->column_search as $item) 
		{
			if($_POST['search']['value']) 
			{
				if($i===0) 
				{
					$this->db->group_start(); 
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				
				if(count($this->column_search) - 1 == $i) 
					$this->db->group_end();
			}
			$i++;
		}
		
		if(isset($_POST['order'])) 
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
	
	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
	
	public function get_all()
	{
		$this->db->from('tbl_siswa');
		$this->db->order_by('id_siswa','DESC');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_by_id($id)
	{
		$this->db->select('* ');
		$this->db->from('tbl_siswa');
		$this->db->where('id_siswa',$id);
		$query = $this->db->get();
		return $query->row();
	}
}
