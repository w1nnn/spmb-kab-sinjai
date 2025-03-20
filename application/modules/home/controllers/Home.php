<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('home_model', 'home');
		$this->load->model("jalur/jalur_model", 'jalur');
		$this->load->model('profil/manage_model', 'manage');
	}

	public function index()
	{
		if ($this->session->userdata('isLogin')) {
			if ($this->session->userdata('level') == 'siswa') {
				return redirect(base_url('siswa/profil'));
			}
			return redirect(base_url('home/dashboard'));
		}
		$this->load->view('landing');
	}


	public function dashboard()
	{
		if ($this->session->userdata('isLogin') == TRUE) {
			if ($this->session->userdata('level') == 'siswa') {
				return redirect(base_url('siswa/profil'));
			}
			//dashboard admin
			$data['title'] = "Penerimaan Peserta Didik Baru";
			$data['subtitle'] = "Dinas Pendidikan Kabupaten Sinjai";
			$data['profil'] = $this->manage->get();
			$data['jalurs'] = $this->jalur->get_all();
			$data['total_genders'] = $this->home->totalGender();
			$data['levelSekolahs'] = $this->home->levelSekolah();
			if (level_user() == "siswa") {
				$this->template->load('layouts', 'dashboard/siswa', $data);
			} else if (level_user() == "sekolah") {
				$this->template->load('layouts', 'dashboard/sekolah', $data);
			} else if (level_user() == "superadmin" || level_user() == "kadis" || level_user() == "admin") {
				$this->template->load('layouts', 'dashboard/super', $data);
			}
		} else {
			$data['title'] = "Penerimaan Peserta Didik Baru";
			$data['subtitle'] = "Dinas Pendidikan Kabupaten Sinjai";
			$data['jalurs'] = $this->jalur->get_all();
			$data['profil'] = $this->manage->get();
			$this->template->load('layouts', 'dashboard/public', $data);
		}
	}
}
