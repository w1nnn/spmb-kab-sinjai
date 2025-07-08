<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Manage extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dokumen_model', 'dokumen');
	}

	public function index()
	{
		cek_session();
		$data['title'] = "Dokumen";
		$data['subtitle'] = "Kelola Dokumen";
		$this->template->load('home/layouts', 'manage/vList', $data);
	}

	public function edit()
	{
		cek_session();
		$id = $this->uri->segment(4);
		$data['title'] = "Edit Dokumen";
		$data['subtitle'] = "Dokumen > Edit";
		$data['get'] = $this->dokumen->get_by_id($id);
		$this->template->load('home/layouts', 'manage/vEdit', $data);
	}


	public function add()
	{
		cek_session();
		$data['title'] = "Dokumen";
		$data['subtitle'] = "Tambah Dokumen";
		$this->template->load('home/layouts', 'manage/vAdd', $data);
	}


	public function ajax_list()
	{
		cek_session();
		$list = $this->dokumen->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $dokumen) {

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $dokumen->nama;
			$row[] = '<a href="' . base_url() . 'uploads/lampiran/' . $dokumen->lampiran . '" target="_blank" class="btn btn-primary"><i class="ri-archive-line"></i> Lampiran  </a>';
			$row[] = '<a href="' . base_url() . 'dokumen/manage/edit/' . $dokumen->id . '"  class="btn btn-sm btn-warning mr-1 "> <i class="ri-edit-2-line "></i> Edit</a>
					  <a href="#" class="btn btn-danger btn-sm "  onclick="delete_(' . "'" . $dokumen->id . "'" . ')">  <i class="ri-delete-bin-2-line "></i> Hapus</a> ';

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


	public function save()
{
	cek_session();
	$config['upload_path'] = './uploads/lampiran';
	$config['allowed_types'] = 'pdf|jpg|png|doc|docx';
	$this->load->library('upload', $config);
	
	if (!$this->upload->do_upload("lampiran")) {
		// Handle upload error
		$error = $this->upload->display_errors();
		redirect(base_url('dokumen/manage?alert=danger&message=' . urlencode('Upload gagal: ' . $error)));
		return;
	}
	
	$file = $this->upload->data();
	$filename = $file['file_name'];
	$jenis_file = $this->input->post('jenis_file', TRUE);
	
	// Cek apakah sudah ada data dengan jenis_file yang sama
	$existing_data = $this->dokumen->get_by_jenis_file($jenis_file);
	
	if ($existing_data) {
		// Jika ada data dengan jenis_file yang sama, lakukan update (replace)
		
		// Hapus file lama jika ada
		$old_file = $existing_data->lampiran;
		if ($old_file && is_file(FCPATH . '/uploads/lampiran/' . $old_file)) {
			unlink(FCPATH . '/uploads/lampiran/' . $old_file);
		}
		
		// Update data yang sudah ada
		$data = array(
			'nama' => $this->input->post('nama', TRUE),
			'lampiran' => $filename,
			'tgl_submit' => date('Y-m-d H:i:s'),
			'jenis_file' => $jenis_file
		);
		
		$this->dokumen->update(array('id' => $existing_data->id), $data);
		
		redirect(base_url('dokumen/manage?alert=info&message=' . urlencode('Berhasil Update Data dengan Jenis File yang Sama')));
	} else {
		// Jika tidak ada data dengan jenis_file yang sama, insert data baru
		$data = array(
			'nama' => $this->input->post('nama', TRUE),
			'lampiran' => $filename,
			'tgl_submit' => date('Y-m-d H:i:s'),
			'jenis_file' => $jenis_file
		);
		
		$this->dokumen->save($data);
		
		redirect(base_url('dokumen/manage?alert=success&message=' . urlencode('Berhasil Tambah Data')));
	}
}

public function update()
{
	cek_session();

	$config['upload_path'] = './uploads/lampiran';
	$config['allowed_types'] = 'pdf|jpg|png|doc|docx';
	$this->load->library('upload', $config);

	if ($this->upload->do_upload("lampiran")) {
		
		// Hapus file lama
		$id = $this->input->post('id');
		$old_data = $this->dokumen->get_by_id($id);
		if ($old_data && $old_data->lampiran && is_file(FCPATH . '/uploads/lampiran/' . $old_data->lampiran)) {
			unlink(FCPATH . '/uploads/lampiran/' . $old_data->lampiran);
		}
		
		$file = $this->upload->data();
		$filename = $file['file_name'];
		$data = array(
			'nama' => $this->input->post('nama', TRUE),
			'lampiran' => $filename,
			'jenis_file' => $this->input->post('jenis_file', TRUE)
		);
	} else {
		// Jika tidak ada file baru yang diupload
		$data = array(
			'nama' => $this->input->post('nama', TRUE),
			'jenis_file' => $this->input->post('jenis_file', TRUE)
		);
	}

	$this->dokumen->update(array('id' => $this->input->post('id')), $data);

	redirect(base_url('dokumen/manage?alert=info&message=' . urlencode('Berhasil Update Data')));
}



	public function ajax_delete($id)
	{
		$this->dokumen->delete_by_id($id);

		echo json_encode(array("status" => TRUE));
	}
}
