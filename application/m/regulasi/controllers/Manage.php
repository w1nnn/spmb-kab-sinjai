<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Manage extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('regulasi_model', 'regulasi');
	}

	public function index()
	{
		cek_session();
		$data['title'] = "Regulasi";
		$data['subtitle'] = "Kelola Regulasi";
		$this->template->load('home/layouts', 'manage/vList', $data);
	}

	public function edit()
	{
		cek_session();
		$id = $this->uri->segment(4);
		$data['title'] = "Edit Regulasi";
		$data['subtitle'] = "Regulasi > Edit";
		$data['get'] = $this->regulasi->get_by_id($id);
		$this->template->load('home/layouts', 'manage/vEdit', $data);
	}

	public function add()
	{
		cek_session();
		$data['title'] = "Regulasi";
		$data['subtitle'] = "Tambah Regulasi";
		$this->template->load('home/layouts', 'manage/vAdd', $data);
	}

	public function ajax_list()
	{
		cek_session();
		$list = $this->regulasi->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $regulasi) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $regulasi->nama;
			$row[] = '<a href="' . base_url() . 'uploads/lampiran/' . $regulasi->lampiran . '" target="_blank" class="btn btn-sm btn-primary"><i class="ri-search-eye-line"></i> Download</a>';
			$row[] = '<a href="' . base_url() . 'regulasi/manage/edit/' . $regulasi->id . '" class="btn btn-sm btn-warning mr-1"><i class="ri-edit-2-line"></i> Edit</a>
					  <a href="#" class="btn btn-danger btn-sm" onclick="delete_(' . "'" . $regulasi->id . "'" . ')"><i class="ri-delete-bin-2-line"></i> Hapus</a>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->regulasi->count_all(),
			"recordsFiltered" => $this->regulasi->count_filtered(),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function save()
	{
		cek_session();
		$config['upload_path'] = './uploads/lampiran';
		$config['allowed_types'] = 'pdf|jpg|png';
		$this->load->library('upload', $config);
		$this->upload->do_upload("lampiran");
		$file = $this->upload->data();
		$filename = $file['file_name'];

		$data = array(
			'nama' => $this->input->post('nama', TRUE),
			'lampiran' => $filename,
			'tgl_submit' => date('Y-m-d H:i:s')
		);

		$this->regulasi->save($data);

		redirect(base_url('regulasi/manage?alert=success&message=' . urlencode('Berhasil Tambah Data')));
	}

	public function update()
	{
		cek_session();

		$config['upload_path'] = './uploads/lampiran';
		$config['allowed_types'] = 'pdf|jpg|png';
		$this->load->library('upload', $config);

		if ($this->upload->do_upload("lampiran")) {
			$file = $this->upload->data();
			$filename = $file['file_name'];
			$data = array(
				'nama' => $this->input->post('nama', TRUE),
				'lampiran' => $filename
			);
		} else {
			$data = array('nama' => $this->input->post('nama', TRUE));
		}

		$this->regulasi->update(array('id' => $this->input->post('id')), $data);

		redirect(base_url('regulasi/manage?alert=info&message=' . urlencode('Berhasil Update Data')));
	}

	public function ajax_delete($id)
	{
		$this->regulasi->delete_by_id($id);
		// Tidak redirect karena ini dipanggil via Ajax
		// Jadi pesan alert nanti bisa ditangani via JS jika dibutuhkan
		echo json_encode(array("status" => TRUE, "alert" => "danger", "message" => "Berhasil Hapus Data"));
	}
}
