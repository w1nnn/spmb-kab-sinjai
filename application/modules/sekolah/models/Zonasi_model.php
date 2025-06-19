<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zonasi_model extends CI_Model
{

	var $table = 'tbl_zonasi_sekolah';
	var $column_order = array('id_zonasi', NULL);
	var $column_search = array('daerah_zonasi'); 
	var $order = array('id_zonasi' => 'DESC'); 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		if (level_user() == "admin" || level_user() == "superadmin") {
			$this->db->select('*');
			$this->db->from('tbl_zonasi_sekolah');
			$this->db->join('tbl_sekolah', 'tbl_zonasi_sekolah.npsn_sekolah = tbl_sekolah.npsn');
			$this->db->join('tbl_daerah_zonasi', 'tbl_zonasi_sekolah.id_daerah_zonasi = tbl_daerah_zonasi.id_master_zonasi');
			$this->db->group_by('tbl_zonasi_sekolah.npsn_sekolah');

		}elseif( level_user() == "sekolah") {
			$npsn = $this->session->userdata('npsn');
			$this->db->select('*');
			$this->db->from('tbl_zonasi_sekolah');
			$this->db->join('tbl_sekolah', 'tbl_zonasi_sekolah.npsn_sekolah = tbl_sekolah.npsn');
			$this->db->join('tbl_daerah_zonasi', 'tbl_zonasi_sekolah.id_daerah_zonasi = tbl_daerah_zonasi.id_master_zonasi');
			$this->db->where('tbl_zonasi_sekolah.npsn_sekolah',$npsn);
			$this->db->group_by('tbl_zonasi_sekolah.npsn_sekolah');

		}


		$i = 0;

		foreach ($this->column_search as $item) 
		{
			if ($_POST['search']['value']) 
			{

				if ($i === 0) 
				{
					$this->db->group_start(); 
					$this->db->like($item, $_POST['search']['value']);
					$this->db->or_like('tbl_sekolah.nama', $_POST['search']['value']);
					$this->db->or_like('tbl_sekolah.npsn', $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
					$this->db->or_like('tbl_sekolah.nama', $_POST['search']['value']);
					$this->db->or_like('tbl_sekolah.npsn', $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if (isset($_POST['order'])) 
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
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
		$this->db->from('tbl_zonasi');
		$this->db->order_by('id_zonasi', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_zonasi_sekolah');
		$this->db->where('id_zonasi', $id);
		$query = $this->db->get();
		return $query->row();
	}

	function save($data)
	{
		$result = $this->db->insert($this->table, $data);
		return $result;
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id_zonasi', $id);
		$this->db->delete($this->table);
	}

	public function get_daerah_zonasi($id)
	{
		$this->db->from('tbl_daerah_zonasi');
		$this->db->where('kecamatan',$id);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_all_daerah_zonasi()
	{
		$this->db->from('tbl_daerah_zonasi');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_daerah_sekolah($id)
	{
		$this->db->from('tbl_zonasi_sekolah');
		$this->db->join('tbl_daerah_zonasi','tbl_daerah_zonasi.id_master_zonasi = tbl_zonasi_sekolah.id_daerah_zonasi');
		$this->db->where('tbl_zonasi_sekolah.npsn_sekolah',$id);
		$query = $this->db->get();
		return $query->result();
	}


	public function get_sekolah($id,$tingkat)
	{
		$this->db->from('tbl_zonasi_sekolah');
		$this->db->join('tbl_daerah_zonasi','tbl_daerah_zonasi.id_master_zonasi = tbl_zonasi_sekolah.id_daerah_zonasi');
		$this->db->join('tbl_sekolah','tbl_zonasi_sekolah.npsn_sekolah = tbl_sekolah.npsn');
		$this->db->where('tbl_zonasi_sekolah.id_daerah_zonasi',$id);
		$this->db->where('tbl_sekolah.level_sekolah',$tingkat);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_sekolah_by_tingkat($tingkat)
	{
		$this->db->from('tbl_sekolah');
		$this->db->where('level_sekolah',$tingkat);
		$query = $this->db->get();
		return $query->result();
	}


	public function get_all_sekolah()
	{
		$this->db->from('tbl_sekolah');
		$query = $this->db->get();
		return $query->result();
	}

}
