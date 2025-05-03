<?php
// ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Regulasi extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('regulasi_model', 'regulasi');
	}


	public function index()
	{

		$data['title'] = "Regulasi";
		$data['subtitle'] = "Daftar Regulasi";
		$this->template->load('home/layouts', 'vFront', $data);
	}


	public function ajax_list()
	{
		$list = $this->regulasi->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $regulasi) {

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $regulasi->nama;
			$row[] = '<a href="' . base_url() . 'uploads/lampiran/' . $regulasi->lampiran . '" target="_blank" class="btn btn-primary"><i class="ri-archive-line"></i> Download  </a>';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->regulasi->count_all(),
			"recordsFiltered" => $this->regulasi->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function jadwal()
	{
		cek_session();
		$jadwal_file = FCPATH . '/uploads/jadwal.json';
		$jadwal = null;
		if (is_file($jadwal_file)) {
			$jadwal = file_get_contents($jadwal_file);
			if (isValidJSON($jadwal)) {
				$jadwal = json_decode($jadwal);
			}
		}

		$data['title'] = "Jadwal SPMB";
		$data['subtitle'] = "Pengaturan Jadwal SPMB";
		$data['jadwal'] = $jadwal;
		$this->template->load('home/layouts', 'vJadwal', $data);
	}

	public function setjadwal()
	{
		cek_session();
		$insert = file_put_contents(FCPATH . '/uploads/jadwal.json', json_encode($this->input->post()));

		if ($insert) {
			$message = urlencode('Jadwal berhasil disimpan');
			redirect('/regulasi/regulasi/jadwal?alert=success&message=' . $message);
		} else {
			$message = urlencode('Jadwal gagal disimpan');
			redirect('/regulasi/regulasi/jadwal?alert=danger&message=' . $message);
		}
	}
}
