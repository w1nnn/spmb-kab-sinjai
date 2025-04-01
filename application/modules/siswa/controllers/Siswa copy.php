<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

use Carbon\Carbon;

class Siswa extends CI_Controller
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
		redirect(base_url());
		// $jalur = $this->uri->segment(3);?
	}

	public function profil()
	{
		cek_session();

		if (level_user() == "siswa") {
			$id = $this->session->userdata('id');
		} else {
			$id = $this->uri->segment(3);
		}
		$lock = $this->siswa->get_by_id($id)->lock;

		if ($lock == "y") {

			$data['title'] = "Data Calon Siswa ";
			$data['subtitle'] = "Menungggu Verifikasi Admin";
			$data['get'] = $this->siswa->get_by_id($id);
			$this->template->load('home/layouts', 'vDetail', $data);
		} else {

			$pages = $this->uri->segment(3);

			if ($pages == "datadiri") {
				$page = "data/data_diri";
			} else if ($pages == "orangtua") {
				$page = "data/orangtua";
			} else if ($pages == "sekolah") {
				$page = "data/sekolah";
			} else if ($pages == "lampiran") {
				$page = "data/lampiran";
			} else if ($pages == "selesai") {
				$page = "data/selesai";
			} else {
				$page = "data/jalur";
			}

			$data['page'] = $page;
			$data['title'] = "Pendaftaran ";
			$data['subtitle'] = "Lengkapi Form Pendaftaran Dibawah";
			$data['get'] = $this->siswa->get_by_id($id);
			$data['tingkat'] = $this->sekolah->get_level_sekolah();
			$data['sekolah'] = $this->sekolah->get_all();
			$data['jalur'] = $this->jalur->get_all();
			$data['kecamatan'] = $this->kecamatan->get_all();


			$this->template->load('home/layouts', 'vProfil', $data);
		}
	}


	public function edit()
	{
		cek_session();


		$id = $this->input->get('id');


		$pages = $this->uri->segment(3);

		if ($pages == "datadiri") {
			$page = "data/data_diri";
		} else if ($pages == "orangtua") {
			$page = "data/orangtua";
		} else if ($pages == "sekolah") {
			$page = "data/sekolah";
		} else if ($pages == "lampiran") {
			$page = "data/lampiran";
		} else if ($pages == "selesai") {
			$page = "data/selesai";
		} else {
			$page = "data/jalur";
		}

		$data['page'] = $page;
		$data['title'] = "Pendaftaran ";
		$data['subtitle'] = "Lengkapi Form Pendaftaran Dibawah";
		$data['get'] = $this->siswa->get_by_id($id);
		$data['tingkat'] = $this->sekolah->get_level_sekolah();
		$data['sekolah'] = $this->sekolah->get_all();
		$data['jalur'] = $this->jalur->get_all();
		$data['kecamatan'] = $this->kecamatan->get_all();


		$this->template->load('home/layouts', 'vProfil', $data);
	}


	public function save()
	{
		cek_session();
		$id = $this->input->post('id');
		$page = $this->input->post('page');
		$next = $this->input->post('lanjut');
		if ($page == "jalur") {

			$data = array(
				'jalur' => $this->input->post('jalur', TRUE),
				'tingkat_sekolah' => $this->input->post('tingkat', TRUE)
			);
		} else if ($page == "datadiri") {
			$ceknik = $this->siswa->getByNoKtpOther($this->input->post('no_ktp'), $this->input->post('id'));
			if ($this->input->post('no_ktp') == '') {
				$this->session->set_flashdata(array('status' => "danger", 'message' => "NIK tidak boleh kosong!"));
				redirect($_SERVER['HTTP_REFERER']);
			} elseif ($ceknik) {
				$this->session->set_flashdata(array('status' => "danger", 'message' => "NIK \"" . $this->input->post('no_ktp') . "\" telah digunakan!"));
				redirect($_SERVER['HTTP_REFERER']);
			}

			$data = array(
				'no_ktp' => $this->input->post('no_ktp', TRUE),
				'nama_siswa' => $this->input->post('nama_siswa', TRUE),
				'tempat_lahir' => $this->input->post('tempat_lahir', TRUE),
				'tgl_lahir' => $this->input->post('tgl_lahir', TRUE),
				'jk' => $this->input->post('jk', TRUE),
				'agama' => $this->input->post('agama', TRUE),
				'ukuran_baju' => $this->input->post('ukuran_baju', TRUE),
				'asal_sekolah' => $this->input->post('asal_sekolah', TRUE),
				'alamat' => $this->input->post('alamat', TRUE),
				'kec' => $this->input->post('kec', TRUE),
				'dusun' => $this->input->post('dusun', TRUE)
			);

			$siswa = $this->siswa->get_by_id($id);
			$endJuni = Carbon::now()->month(6)->endOfMonth();
			$age = Carbon::parse($this->input->post('tgl_lahir', TRUE))->diff($endJuni);
			$ts = $siswa->tingkat_sekolah;

			if ($ts == 4) {
				if ($age->y < 4) {
					$this->session->set_flashdata(array('error' => 'usia', 'status' => "danger", 'message' => "Batas umur untuk jenjang TK adalah paling rendah 4 Tahun pada bulan Juli!"));
					$this->siswa->update(array('id_siswa' => $id), $data);
					redirect($_SERVER['HTTP_REFERER']);
				}
			} elseif ($ts == 5) {
				if ($age->y < 5 || ($age->y == 5 && $age->m < 6)) {
					$this->session->set_flashdata(array('error' => 'usia', 'status' => "danger", 'message' => "Batas umur untuk jenjang SD adalah paling rendah 5 Tahun 6 Bulan pada bulan Juli!"));
					$this->siswa->update(array('id_siswa' => $id), $data);
					redirect($_SERVER['HTTP_REFERER']);
				}
			} elseif ($ts == 6) {
				if ($age->y > 15) {
					$this->session->set_flashdata(array('error' => 'usia', 'status' => "danger", 'message' => "Batas umur untuk jenjang SMP adalah paling tinggi 15 Tahun pada bulan Juli!"));
					$this->siswa->update(array('id_siswa' => $id), $data);
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
		} else if ($page == "orangtua") {
			$data = array(
				'nm_ayah' => $this->input->post('nama_ayah', TRUE),
				'pekerjaan_ayah' => $this->input->post('pekerjaan_ayah', TRUE),
				'nm_ibu' => $this->input->post('nama_ibu', TRUE),
				'pekerjaan_ibu' => $this->input->post('pekerjaan_ibu', TRUE),
				'nm_wali' => $this->input->post('nama_wali', TRUE),
				'pekerjaan_wali' => $this->input->post('pekerjaan_wali', TRUE),
				'no_kk' => $this->input->post('no_kk', TRUE),
				'no_hp_ortu' => $this->input->post('no_hp_ortu', TRUE),
			);
		} else if ($page == "sekolah") {
			$data = array(
				'pilihan_sekolah_1' => $this->input->post('sekolah_pilihan_1', TRUE)
			);
		} else if ($page == "lampiran") {


			$config['upload_path'] = './uploads/siswa/';
			$config['allowed_types'] = 'pdf|jpg|png|jpeg';
			$config['remove_spaces'] = TRUE;
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload', $config);


			if ($this->upload->do_upload("foto")) {
				$foto = $this->siswa->get_by_id($id)->foto;
				if ($foto && is_file(FCPATH . '/uploads/siswa/' . $foto)) {
					unlink(FCPATH . '/uploads/siswa/' . $foto);
				}
				$file = $this->upload->data();
				$filename = $file['file_name'];
				$foto = array('foto' => $filename);
				$this->siswa->update(array('id_siswa' => $id), $foto);
			} else {

				$foto = $this->siswa->get_by_id($id)->foto;
				if ($foto == "") {
					$error = $this->upload->display_errors();
					$this->session->set_flashdata(array('status' => "danger", 'message' => $error . "-foto", "field_error" => "foto"));
					redirect(base_url('siswa/profil/' . $page . ''));
				}
			}


			if ($this->upload->do_upload("kk")) {
				$kk = $this->siswa->get_by_id($id)->kk;
				if ($kk && is_file(FCPATH . '/uploads/siswa/' . $kk)) {
					unlink(FCPATH . '/uploads/siswa/' . $kk);
				}
				$file = $this->upload->data();
				$filename = $file['file_name'];
				$kk = array('kk' => $filename);
				$this->siswa->update(array('id_siswa' => $id), $kk);
			} else {

				$kk = $this->siswa->get_by_id($id)->kk;
				if ($kk == "") {
					$error = $this->upload->display_errors();
					$this->session->set_flashdata(array('status' => "danger", 'message' => $error . "-kk", "error_kk" => "error_kk"));
					redirect(base_url('siswa/profil/' . $page . ''));
				}
			}

			if ($this->upload->do_upload("akta")) {
				$akta_kelahiran_siswa = $this->siswa->get_by_id($id)->akta_kelahiran_siswa;
				if ($akta_kelahiran_siswa && is_file(FCPATH . '/uploads/siswa/' . $akta_kelahiran_siswa)) {
					unlink(FCPATH . '/uploads/siswa/' . $akta_kelahiran_siswa);
				}
				$file = $this->upload->data();
				$filename = $file['file_name'];
				$akta = array('akta_kelahiran_siswa' => $filename);
				$this->siswa->update(array('id_siswa' => $id), $akta);
			} else {

				$akta = $this->siswa->get_by_id($id)->akta_kelahiran_siswa;
				if ($akta == "") {
					$error = $this->upload->display_errors();
					$this->session->set_flashdata(array('status' => "danger", 'message' => $error . "-akta", "error_akta" => "akta"));
					redirect(base_url('siswa/profil/' . $page . ''));
				}
			}

			if ($this->siswa->get_by_id($id)->jalur != "114") {

				if ($this->upload->do_upload("suket")) {
					$suket = $this->siswa->get_by_id($id)->suket;
					if ($suket && is_file(FCPATH . '/uploads/siswa/' . $suket)) {
						unlink(FCPATH . '/uploads/siswa/' . $suket);
					}
					$file = $this->upload->data();
					$filename = $file['file_name'];
					$suket = array('suket' => $filename);
					$this->siswa->update(array('id_siswa' => $id), $suket);
				} else {

					$suket = $this->siswa->get_by_id($id)->suket;
					if ($suket == "") {
						$error = $this->upload->display_errors();
						$this->session->set_flashdata(array('status' => "danger", 'message' => $error . "-suket", "error_skl" => "suket"));
						redirect(base_url('siswa/profil/' . $page . ''));
					}
				}
			}

			if ($this->upload->do_upload("skl")) {
				$skl = $this->siswa->get_by_id($id)->skl;
				if ($skl && is_file(FCPATH . '/uploads/siswa/' . $skl)) {
					unlink(FCPATH . '/uploads/siswa/' . $skl);
				}
				$file = $this->upload->data();
				$filename = $file['file_name'];
				$skl = array('skl' => $filename);
				$this->siswa->update(array('id_siswa' => $id), $skl);
			}


			if ($this->upload->do_upload("suket_prestasi")) {
				$suket_prestasi = $this->siswa->get_by_id($id)->suket_prestasi;
				if ($suket_prestasi && is_file(FCPATH . '/uploads/siswa/' . $suket_prestasi)) {
					unlink(FCPATH . '/uploads/siswa/' . $suket_prestasi);
				}
				$file = $this->upload->data();
				$filename = $file['file_name'];
				$suket_prestasi = array('suket_prestasi' => $filename);
				$this->siswa->update(array('id_siswa' => $id), $suket_prestasi);
			}



			$data = array('bidang_prestasi' => $this->input->post('bidang_prestasi'));
		} else if ($page == "selesai") {
			$no_pendaftaran = $this->siswa->get_by_id($id)->no_pendaftaran;
			if (!$no_pendaftaran) {
				$no_pendaftaran = nomorUrut();
			}

			$data = array('lock' => "y", 'no_pendaftaran' => $no_pendaftaran, 'tgl_daftar' => date('Y-m-d'));
		}

		$this->siswa->update(array('id_siswa' => $id), $data);
		$this->session->set_flashdata(array('status' => "info", 'message' => "Data sementara berhasil disimpan"));

		if (level_user() == "siswa") {
			redirect(base_url('siswa/profil/' . $next . ' '));
		} else {
			$id_siswa = $this->siswa->get_by_id($id)->id_siswa;

			if ($page == "selesai") {
				redirect(base_url('siswa/profil/' . $id_siswa . ' '));
			} else {

				redirect(base_url('siswa/edit/' . $next . '/?id=' . $id_siswa . ' '));
			}
		}
	}

	public function preview()
	{
		cek_session();
		if (level_user() == "siswa") {
			$id = $this->session->userdata('id');
		} else {
			$id = $this->uri->segment(3);
		}
		$data['title'] = "Preview Data Pendaftaran ";
		$data['subtitle'] = "Pendaftaran";
		$data['get'] = $this->siswa->profil($id);


		$this->template->load('home/layouts', 'vPreview', $data);
	}

	public function cetak()
	{
		cek_session();
		if (level_user() == "siswa") {
			$id = $this->session->userdata('id');
		} else {
			$id = $this->uri->segment(3);
		}
		$this->load->library('pdf');
		$this->pdf->setPaper('A4', 'potrait');
		$this->pdf->filename = "Bukti-Pendaftaran.pdf";
		$data['get'] = $this->siswa->get_by_id($id);
		$this->pdf->load_view('vBuktiPdf', $data, TRUE);
	}


	public function delete()
	{
		$id = $this->uri->segment(3);
		$this->siswa->delete_by_id($id);
		$this->session->set_flashdata(array('status' => "danger", "message" => "Berhasil menghapus data "));
		redirect(base_url('siswa/daftar/index'));
	}


	//auth


	public function register()
	{
		if ($this->session->userdata('isLogin')) {
			if ($this->session->userdata('level') == 'siswa') {
				return redirect(base_url('siswa/profil'));
			}
			return redirect(base_url('home/dashboard'));
		}
		$this->load->view('vRegister');
	}


	public function createAccount()
	{
		$key = randomCode();
		$no_ktp = $this->input->post('no_ktp', TRUE);
		$check = $this->siswa->getByNoKtp($no_ktp);
		if ($check == "0") {
			$data = array(
				'id_siswa' => $key,
				'nama_siswa' => $this->input->post('nama', TRUE),
				'no_ktp' => $this->input->post('no_ktp', TRUE),
				'password' => sha1(md5($this->input->post('password', TRUE))),
				'tgl_buat_akun' => date('Y-m-d')
			);

			$this->siswa->save($data);

			$accountSession = array(
				'id' => $key,
				'nama' => $this->input->post('nama', TRUE),
				'no_ktp' => $this->input->post('no_ktp', TRUE),
				'level' => "siswa",
				'isLogin' => TRUE
			);
			$this->session->set_userdata($accountSession);

			$this->session->set_flashdata(array('status' => "success", 'message' => "Berhasil Registrasi Akun"));
			redirect(base_url('siswa/profil'));
		} else {

			$this->session->set_flashdata(array('status' => "error", 'message' => "Maaf, NIK \"" . $this->input->post('no_ktp') . "\" Telah Terdaftar, Silahkan Masukan NIK Lain"));
			redirect(base_url('siswa/register'));
		}
	}


	public function login()
	{
		if ($this->session->userdata('isLogin')) {
			if ($this->session->userdata('level') == 'siswa') {
				return redirect(base_url('siswa/profil'));
			}
			return redirect(base_url('home/dashboard'));
		}
		$jalur = $this->uri->segment(3);
		$this->load->view('vLogin');
	}

	public function auth()
	{
		$hp = $this->input->post('no_ktp', TRUE);
		$password = $this->input->post('password', TRUE);
		if ($this->siswa->auth($hp, $password)) {
			$this->session->set_flashdata(array('status' => "success", 'message' => "Login Berhasil"));
			redirect(base_url('siswa/profil'));
		} else {
			$this->session->set_flashdata(array('status' => "error", "email" => $hp, 'password' => $password));
			redirect(base_url('siswa/login'));
		}
	}

	public function reset()
	{
		$nik = $this->input->post('nik');
		$tgl_lahir = $this->input->post('tgl_lahir');
		$new_password = $this->input->post('new_password');
		$new_password1 = $this->input->post('new_password1');

		if ($tgl_lahir == '') {
			$tgl_lahir = null;
		}

		$this->db->from('tbl_siswa');
		$this->db->where('no_ktp', $nik);
		$this->db->where('tgl_lahir', $tgl_lahir);
		$this->db->limit(1);
		$query = $this->db->get();

		$data = $query->row();

		if ($data) {
			if ($new_password !== $new_password1) {
				echo json_encode([
					'status' => 'error',
					'message' => 'Perulangan password tidak benar'
				]);
				return;
			}

			$reset = $this->db->update('tbl_siswa', ['password' => sha1(md5($new_password))], ['id' => $data->id]);
			if ($reset) {
				echo json_encode([
					'status' => 'success',
					'message' => 'Password berhasil direset'
				]);
				return;
			}
			echo json_encode([
				'status' => 'error',
				'message' => 'Password tidak dapat direset'
			]);
			return;
		}

		echo json_encode([
			'status' => 'error',
			'message' => 'Data tidak ditemukan'
		]);
		return;
	}
}
