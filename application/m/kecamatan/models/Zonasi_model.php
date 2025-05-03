<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zonasi_model extends CI_Model {
	
	var $kabupaten = '7307'; //kabupaten sinjai
	var $table = 'tbl_daerah_zonasi';
	var $column_order = array('tbl_daerah_zonasi.kecamatan',null); //set column field database for datatable orderable
	var $column_search = array('tbl_daerah_zonasi.daerah_zonasi' ); //set column field database for datatable searchable just fikecamatantname , lastname , address are searchable
	var $order = array('tbl_daerah_zonasi.kecamatan' => 'DESC'); // default order
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	private function _get_datatables_query()
	{
		// active record
		$this->db->select('*');
		$this->db->from('tbl_daerah_zonasi');
		$this->db->join('kecamatan','tbl_daerah_zonasi.kecamatan = kecamatan.id_kec');
		$this->db->where('kecamatan.id_kab',$this->kabupaten);
		
		$i = 0;
		
		foreach ($this->column_search as $item) // loop column
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // fikecamatant loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				
				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
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
		$this->db->select('*');
		$this->db->from('tbl_daerah_zonasi');
		$this->db->join('kecamatan','tbl_daerah_zonasi.kecamatan = kecamatan.id_kec');
		$this->db->where('kecamatan.id_kab',$this->kabupaten);
		$this->db->order_by('tbl_daerah_zonasi.kecamatan','ASC');
		$query = $this->db->get();
		return $query->result();
	}
	
	
	public function get_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_daerah_zonasi');
		$this->db->join('kecamatan','tbl_daerah_zonasi.kecamatan = kecamatan.id_kec');
		$this->db->where('kecamatan.id_kab',$this->kabupaten);
		$this->db->where('tbl_daerah_zonasi.id_master_zonasi',$id);
		$query = $this->db->get();
		return $query->row();
	}
	
	
	
	
	function save($data){
		$result= $this->db->insert($this->table,$data);
		return $result;
	}
	
	
	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}
	
	
	public function delete_by_id($id)
	{
		$this->db->where('id_master_zonasi', $id);
		$this->db->delete($this->table);
	}
	
	
	
}
