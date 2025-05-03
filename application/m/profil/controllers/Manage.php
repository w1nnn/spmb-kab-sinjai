<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Manage extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('profil/manage_model', 'manage');
	}


	public function sambutan()
	{
		cek_session();
		$data['title'] = "Sambutan Kepala Dinas ";
		$data['subtitle'] = "Kelola Sambutan";
		$data['get'] = $this->manage->get();
		$this->template->load('home/layouts', 'manage/sambutan', $data);
	}

	public function ppdb()
	{
		cek_session();
		$data['title'] = "Apa itu PPDB ?  ";
		$data['subtitle'] = "Kelola Penjelasan SPMB";
		$data['get'] = $this->manage->get();
		$this->template->load('home/layouts', 'manage/ppdb', $data);
	}

	public function panduan()
	{
		cek_session();
		$data['title'] = "Panduan Pendaftaran ";
		$data['subtitle'] = "Penerimaan Peserta Didik Baru";
		$data['get'] = $this->manage->get();
		$this->template->load('home/layouts', 'manage/panduan', $data);
	}


	public function kontak()
	{
		cek_session();
		$data['title'] = "Kontak ";
		$data['subtitle'] = "Kontak Dinas Pendidikan";
		$data['get'] = $this->manage->get();
		$this->template->load('home/layouts', 'manage/kontak', $data);
	}




	public function update()
	{
		cek_session();
		$act = $this->input->post('act');
		if ($act == "sambutan") {

			$config['upload_path'] = './uploads';
			$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|PNG|jpeg';
			$this->load->library('upload', $config);

			if ($this->upload->do_upload("fotokadis")) {
				$file = $this->upload->data();
				$image = $file['file_name'];
				$data = array('nama_kadis' => $this->input->post('nama_kadis', TRUE), 'sambutan' => $this->input->post('sambutan', TRUE), 'foto_kadis' => $image);
			} else {
				$data = array('nama_kadis' => $this->input->post('nama_kadis', TRUE), 'sambutan' => $this->input->post('sambutan', TRUE));
			}
		} else if ($act == "ppdb") {

			$config['upload_path'] = './uploads';
			$config['allowed_types'] = 'pdf';
			$this->load->library('upload', $config);

			if ($this->upload->do_upload("lampiran")) {
				$file = $this->upload->data();
				$lampiran = $file['file_name'];
				$data = array('ppdb' => $this->input->post('ppdb', TRUE), 'lampiran' => $lampiran);
			} else {
				$data = array('ppdb' => $this->input->post('ppdb', TRUE));
			}
		} elseif ($act == "panduan") {

			$config['upload_path'] = './uploads/panduan';  // Pastikan folder ini ada dan memiliki izin yang benar
			$config['allowed_types'] = 'pdf';  // Hanya PDF yang diperbolehkan
			$config['max_size'] = 2048;  // Maksimal ukuran file 2MB
			$this->load->library('upload', $config);

			if ($this->upload->do_upload('panduan')) {
				// Mengambil data file yang di-upload
				$file = $this->upload->data();
				$panduan = $file['file_name'];  // Nama file yang di-upload

				// Siapkan data untuk update
				$data = array(
					'panduan' => $panduan  // Nama file untuk disimpan dalam kolom 'panduan'
				);

				// Tentukan kondisi update, misalnya berdasarkan ID
				$where = array('id_profil' => 1);  // Sesuaikan dengan kondisi yang kamu butuhkan

				// Load model dan update data
				$this->load->model('Manage_model');
				$update = $this->Manage_model->update($where, $data);

				if ($update > 0) {
					// Jika berhasil update
					echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Panduan berhasil di-upload!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = '" . base_url('profil/manage/panduan') . "';
                });
              </script>";
				} else {
					// Jika gagal update
					echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal menyimpan data panduan!',
                    text: 'Terjadi kesalahan saat menyimpan data.',
                    showConfirmButton: true
                }).then(function() {
                    window.location.href = '" . base_url('profil/manage/panduan') . "';
                });
              </script>";
				}
			} else {
				// Jika upload gagal
				echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Upload Gagal!',
                text: '" . $this->upload->display_errors() . "',
                showConfirmButton: true
            }).then(function() {
                window.location.href = '" . base_url('profil/manage/panduan') . "';
            });
          </script>";
			}
		} elseif ($act == "kontak") {

			$data = array(
				'alamat' => $this->input->post('alamat', TRUE),
				'hp' =>  $this->input->post('hp', TRUE),
				'wa' =>  $this->input->post('wa', TRUE),
				'email' =>  $this->input->post('email', TRUE),
				'fb' =>  $this->input->post('fb', TRUE),
				'ig' =>  $this->input->post('ig', TRUE),
				'twitter' =>  $this->input->post('twitter', TRUE)
			);
		}

		$this->manage->update(array('id_profil' => '1'), $data);

		redirect(base_url('profil/manage/' . $act . '?alert=success&message=' . urlencode('Sukses Update Data')));
	}
}
