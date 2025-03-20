<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Zonasi extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('kecamatan_model', 'kecamatan');
		$this->load->model('zonasi_model', 'zonasi');
	}
	
	public function index()
	{
		cek_session();
		$data['title'] = "Master Zonasi Daerah Kecamatan";
		$data['subtitle'] = "Kelola Master Zonasi Daerah Kecamatan";
		$this->template->load('home/layouts', 'zonasi/vList', $data);
	}
	
	public function edit()
	{
		cek_session();
		$id = $this->uri->segment(4);
		$data['title'] = "Edit Master Zonasi Daerah Kecamatan";
		$data['subtitle'] = "Master Zonasi Daerah Kecamatan > Edit";
		$data['get'] = $this->zonasi->get_by_id($id);
		$data['kecamatan'] = $this->kecamatan->get_all();
		$this->template->load('home/layouts', 'zonasi/vEdit', $data);
	}
	
	
	public function add()
	{
		cek_session();
		$data['title'] = "Master Zonasi Daerah Kecamatan";
		$data['subtitle'] = "Tambah Master Zonasi Daerah Kecamatan";
		$data['kecamatan'] = $this->kecamatan->get_all();
		$this->template->load('home/layouts', 'zonasi/vAdd', $data);
	}
	
	
	public function ajax_list()
	{
		cek_session();
		$list = $this->zonasi->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $kecamatan) {
			
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $kecamatan->nama_kec;
			$row[] = $kecamatan->daerah_zonasi;
			$row[] = '<a href="' . base_url() . 'kecamatan/zonasi/edit/' . $kecamatan->id_master_zonasi . '"  class="btn btn-sm btn-warning mr-1 "> <i class="ri-edit-2-line "></i> Edit</a>
					  <a href="#"  class="btn btn-danger btn-sm "  onclick="delete_(' . "'" . $kecamatan->id_master_zonasi . "'" . ')">  <i class="ri-delete-bin-2-line "></i> Hapus</a> ';
			
			$data[] = $row;
		}
		
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->zonasi->count_all(),
			"recordsFiltered" => $this->zonasi->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	
	
	public function save()
	{
		cek_session();
		$data = array('kecamatan' => $this->input->post('kecamatan', TRUE) , 'daerah_zonasi' => $this->input->post('daerah',TRUE) );
		$this->zonasi->save($data);
		$this->session->set_flashdata(array('status' => "success", 'message' => "Berhasil Input Data"));
		redirect(base_url('kecamatan/zonasi'));
	}
	
	
	public function update()
	{
		cek_session();
		$data = array('kecamatan' => $this->input->post('kecamatan', TRUE) , 'daerah_zonasi' => $this->input->post('daerah',TRUE) );
		
		$this->zonasi->update(array('id_master_zonasi' => $this->input->post('id')), $data);
		$this->session->set_flashdata(array('status' => "info", 'message' => "Berhasil Update Data"));
		redirect(base_url('kecamatan/zonasi'));
	}
	
	
	public function ajax_delete($id)
	{
		$this->zonasi->delete_by_id($id);
		$this->session->set_flashdata(array('status' => "danger"));
		
		echo json_encode(array("status" => TRUE));
	}
	
	
	
	
	
}
