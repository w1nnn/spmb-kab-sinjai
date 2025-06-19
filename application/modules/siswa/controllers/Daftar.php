<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Daftar extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('siswa_model', 'siswa');
		$this->load->model('sekolah/sekolah_model', 'sekolah');
		$this->load->model('jalur/jalur_model', 'jalur');
		$this->load->model('kecamatan/kecamatan_model', 'kecamatan');
		$this->load->model('kecamatan/zonasi_model', 'daerah_zonasi');
		$this->load->model('sekolah/zonasi_model', 'zonasi');
	}

	public function index()
	{
		$jalur =  $this->input->get('jalur');
		if (level_user() == "sekolah") {
			$url = site_url('siswa/daftar/ajax_list?jalur=' . $jalur . '');
		} else if (level_user() == "admin" or level_user() == "superadmin" || level_user() == "kadis") {
			$sekolah = $this->input->get('tingkat');
			$npsn = $this->input->get('npsn');
			$sts_dtks = $this->input->get('sts_dtks');
			$url = site_url('siswa/daftar/ajax_list?jalur=' . $jalur . '&tingkat=' . $sekolah . '&npsn=' . $npsn . '&sts_dtks=' . $sts_dtks . '');
		}

		if ($jalur == "") {
			$jalur_ = "Semua Jalur";
		} else {
			$jalur_ = jalur($jalur)->nama;
		}

		$getTingkat = $this->input->get('tingkat');
		if ($getTingkat == "") {
			$tingkat = "";
		} else {
			$tingkat = ", Tingkat " . tingkat($getTingkat)->level_sekolah;
		}

		$data['title'] = "Data Calon Siswa - " . $jalur_ . " " . $tingkat . "  ";
		$data['subtitle'] = "Daftar Siswa Yang Telah Mendaftar";
		$data['url'] = $url;

		$data['status'] = $this->session->flashdata('status');
		$data['message'] = $this->session->flashdata('message');
		$this->template->load('home/layouts', 'vList', $data);
	}

	public function ajax_list()
	{
		cek_session();
		$this->bulk_update_dtks_status();
		
		$list = $this->siswa->get_datatables();
		$data = array();
		$no = $_POST['start'];
		
		foreach ($list as $siswa) {
			if ($siswa->status_verifikasi == "y") {
				$status = "Diterima";
				$color = "success";
			} elseif ($siswa->status_verifikasi == "n") {
				$status = "Ditolak";
				$color = "danger";
			} else {
				$status = "Belum Diproses";
				$color = "secondary";
			}
			
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = "<img src='" . base_url() . "uploads/siswa/" . $siswa->foto . "' width='70px;' class='rounded'> ";
			$row[] = "<a href='" . base_url() . "siswa/profil/" . $siswa->id_siswa . "'><b>" . strtoupper($siswa->nama_siswa) . "</b> </a> <br> <b > " . jalur($siswa->jalur)->nama . " </b>  ";
			$row[] = $siswa->tempat_lahir . " / " . tgl_indo($siswa->tgl_lahir);
			$row[] = $siswa->no_ktp;

			if (level_user() == "admin" || level_user() == "superadmin" || level_user() == "kadis") {
				$row[] = sekolah($siswa->pilihan_sekolah_1)->nama;
			}

			$row[] = kecamatan($siswa->kec)->nama_kec;
			$row[] = dusun($siswa->dusun)->daerah_zonasi;
			$row[] = "<span class='badge badge-" . $color . "'>" . $status . "</span> ";
			$row[] = '<a href="' . base_url() . 'siswa/profil/' . $siswa->id_siswa . '"  class="btn btn-sm btn-warning mr-1 "> <i class="ri-search-2-line "></i> Detail</a>
					  <a href="#" class="btn btn-danger btn-sm "  onclick="delete_(' . "'" . $siswa->id_siswa . "'" . ')">  <i class="ri-delete-bin-2-line "></i> Hapus</a> ';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->siswa->count_all(),
			"recordsFiltered" => $this->siswa->count_filtered(),
			"data" => $data,
		);
		
		echo json_encode($output);
	}

private function bulk_update_dtks_status()
{
    $sql = "UPDATE tbl_siswa 
            SET sts_dtks = CASE 
                WHEN no_ktp IS NOT NULL 
                AND no_ktp != '' 
                AND EXISTS (
                    SELECT 1 
                    FROM tbl_status_dtks 
                    WHERE nik = tbl_siswa.no_ktp 
                    AND status = 'Terdaftar'
                ) THEN 1
                WHEN no_ktp IS NOT NULL 
                AND no_ktp != '' 
                AND EXISTS (
                    SELECT 1 
                    FROM tbl_status_dtks 
                    WHERE nik = tbl_siswa.no_ktp 
                    AND status = 'Tidak Terdaftar'
                ) THEN 0
                ELSE 3 
            END";
    
    return $this->db->query($sql);
}
	public function update_dtks_manual()
	{
		cek_session();
		
		if (!in_array(level_user(), ['admin', 'superadmin'])) {
			show_error('Unauthorized access', 403);
		}
		
		$start_time = microtime(true);
		$this->bulk_update_dtks_status();
		$end_time = microtime(true);
		
		$execution_time = round(($end_time - $start_time), 2);
		
		$this->session->set_flashdata(array(
			'status' => 'success',
			'message' => "Update DTKS berhasil dilakukan dalam {$execution_time} detik"
		));
		
		redirect('siswa/daftar');
	}

	public function verifikasi()
	{
		cek_session();
		$id = $this->input->post('id');

		$data = array(
			'status_verifikasi'   => $this->input->post('status_verifikasi') ?? null,
			'catatan_verifikasi'  => $this->input->post('catatan_verifikasi') ?? null
		);

		$this->siswa->update(array('id_siswa' => $id), $data);

		$status  = 'info';
		$message = urlencode('Verifikasi berhasil disimpan');

		redirect(base_url("siswa/profil/{$id}?alert={$status}&message={$message}"));
	}

	public function ajax_delete($id)
	{
		$this->siswa->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function excel()
	{
		cek_session();
		if (level_user() == "admin" || level_user() == "superadmin") {
			$data['siswas'] = $this->siswa->getByCustom();
			$this->load->view('vExcel', $data);
		} else {
			$this->session->set_flashdata(array('error' => 'auth', 'status' => "danger", 'message' => "Anda tidak memiliki hak akses!"));
			redirect(base_url('login'));
		}
	}
}