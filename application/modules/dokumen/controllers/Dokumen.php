<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokumen extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('dokumen_model', 'dokumen');
	}
	
	
	public function index()
	{

		$data['title'] = "Dokumen";
		$data['subtitle'] = "Daftar Publikasi Dokumen";
		$this->template->load('home/layouts', 'vFront',$data);
	}


	public function ajax_list()
	{
		$list = $this->dokumen->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $dokumen) {
			
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $dokumen->nama;
			$row[] = '<a href="' . base_url() . 'uploads/lampiran/' . $dokumen->lampiran . '" target="_blank" class="btn btn-primary"><i class="ri-archive-line"></i> Download  </a>';
		
			$data[] = $row;
		}
		
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->dokumen->count_all(),
			"recordsFiltered" => $this->dokumen->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}


	
	
}
