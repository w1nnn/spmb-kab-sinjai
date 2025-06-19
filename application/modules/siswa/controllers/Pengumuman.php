<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengumuman extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('siswa/pengumuman_model', 'pengumuman');
		$this->load->model('sekolah/sekolah_model', 'sekolah');
	}

	public function index()
	{

		$npsn = $this->input->get('npsn');

		$data['title'] = $npsn?"Pengumuman - " . sekolah($npsn)->nama:"Pengumuman";
		$data['subtitle'] = "";
		$data['sekolahs'] = $this->sekolah->get_all();
		$this->template->load('home/layouts', 'vPengumuman', $data);
	}


	public function ajax_list()
	{

		$list = $this->pengumuman->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pengumuman) {
			if ($pengumuman->status_verifikasi == "y") {
				$status = "LULUS";
				$color = "success";
			}elseif ($pengumuman->status_verifikasi == "n") {
				$status = "TIDAK LULUS";
				$color = "danger";
			}else{
				$status = "Belum Diproses";
				$color = "secondary";
			}
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = "<b>".strtoupper($pengumuman->nama_siswa)." </b>  ";
			$row[] = $pengumuman->tempat_lahir." / ". tgl_indo($pengumuman->tgl_lahir);
			$row[] = sekolah($pengumuman->pilihan_sekolah_1)->nama;
			$row[] = jalur($pengumuman->jalur)->nama;
			$row[] = "<span class='badge badge-".$color."'>".$status."</span> ";
			$row[] = $pengumuman->catatan_verifikasi;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->pengumuman->count_all(),
			"recordsFiltered" => $this->pengumuman->count_filtered(),
			"data" => $data,
		);
		echo json_encode($output);
	}



}
