<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kecamatan_model extends CI_Model {
	
	var $kabupaten = '7307'; //kabupaten sinjai
	var $table = 'kecamatan';
	var $column_order = array('id_kec',null); //set column field database for datatable orderable
	var $column_search = array('nama_kec' ); //set column field database for datatable searchable just fikecamatantname , lastname , address are searchable
	var $order = array('id_kec' => 'DESC'); // default order
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	private function _get_datatables_query()
	{
		// active record
		$this->db->select('*');
		$this->db->from('kecamatan');
		$this->db->where('id_kab',$this->kabupaten);
		
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
		$this->db->from('kecamatan');
		$this->db->where('id_kab',$this->kabupaten);
		$this->db->order_by('id_kec','ASC');
		$query = $this->db->get();
		return $query->result();
	}
	
	
	public function get_by_id($id)
	{
		$this->db->select('* ');
		$this->db->from('kecamatan');
		$this->db->where('id_kec',$id);
		$this->db->where('id_kab',$this->kabupaten);
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
		$this->db->where('id_kec', $id);
		$this->db->delete($this->table);
	}
	
	
	
}
