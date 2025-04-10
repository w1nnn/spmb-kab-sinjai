<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Profil extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('profil/manage_model', 'manage');
	}


	public function sambutan()
	{
		$data['title'] = "Sambutan Kepala Dinas ";
		$data['subtitle'] = "Profil >  Sambutan";
		$data['get'] = $this->manage->get();
		$this->template->load('home/layouts', 'vSambutan', $data);
	}

	public function ppdb()
	{
		$data['title'] = "Apa itu SPMB";
		$data['subtitle'] = "Profil > SPMB";
		$data['get'] = $this->manage->get();
		$this->template->load('home/layouts', 'vPpdb', $data);
	}


	public function panduan()
	{
		$data['title'] = "Panduan";
		$data['subtitle'] = "Profil > Panduan";
		$data['get'] = $this->manage->get();
		$this->template->load('home/layouts', 'vPanduan', $data);
	}

	public function jadwal()
	{
		// cek_session();
		$jadwal_file = FCPATH . '/uploads/jadwal.json';
		$jadwal = null;
		if (is_file($jadwal_file)) {
			$jadwal = file_get_contents($jadwal_file);
			if (isValidJSON($jadwal)) {
				$jadwal = json_decode($jadwal);
			}
		}

		$data['title'] = "Jadwal Pendafataran";
		$data['subtitle'] = "Informasi > Jadwal Pendaftaran";
		$data['jadwal'] = $jadwal;
		$this->template->load('home/layouts', 'vJadwal', $data);
	}




	public function kontak()
	{
		$data['title'] = "Konrak";
		$data['subtitle'] = "Kontak Panitia SPMB ";
		$data['get'] = $this->manage->get();
		$this->template->load('home/layouts', 'vKontak', $data);
	}
}
