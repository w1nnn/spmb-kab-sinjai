<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Manage extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('jalur_model', 'jalur');
	}

	public function index()
	{
		cek_session();
		$data['title'] = "Jalur Pendaftaran";
		$data['subtitle'] = "Kelola Jalur Pendaftaran";
		$this->template->load('home/layouts', 'manage/vList', $data);
	}

	public function detail()
	{
		cek_session();
		$id = $this->uri->segment(4);
		$data['title'] = "Detail Jalur Pendaftaran";
		$data['subtitle'] = "Jalur Pendaftaran > Detail ";
		$data['get'] = $this->jalur->get_by_id($id);
		$this->template->load('home/layouts', 'manage/vDetail', $data);
	}


	public function edit()
	{
		cek_session();
		$id = $this->uri->segment(4);
		$data['title'] = "Edit Jalur Pendaftaran";
		$data['subtitle'] = "Jalur Pendaftaran > Edit";
		$data['get'] = $this->jalur->get_by_id($id);
		$this->template->load('home/layouts', 'manage/vEdit', $data);
	}


	public function add()
	{
		cek_session();
		$data['title'] = "Jalur Pendaftaran";
		$data['subtitle'] = "Tambah Jalur Pendaftaran";
		$this->template->load('home/layouts', 'manage/vAdd', $data);
	}


	public function ajax_list()
	{
		cek_session();
		$list = $this->jalur->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $jalur) {

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $jalur->nama;
			$row[] = '<a href="' . base_url() . 'jalur/manage/detail/' . $jalur->id . '"  class="btn btn-sm btn-primary mr-1 align-center "> <i class="ri-search-2-line"></i> Detail </a>';
			$row[] = '<a href="' . base_url() . 'jalur/manage/edit/' . $jalur->id . '"  class="btn btn-sm btn-warning mr-1 "> <i class="ri-edit-2-line "></i> Edit</a>
					  <a href="#" class="btn btn-danger btn-sm "  onclick="delete_(' . "'" . $jalur->id . "'" . ')">  <i class="ri-delete-bin-2-line "></i> Hapus</a> ';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->jalur->count_all(),
			"recordsFiltered" => $this->jalur->count_filtered(),
			"data" => $data,
		);
		//output to json format
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
			'deskripsi' => $this->input->post('deskripsi', TRUE),
			'lampiran' => $filename,
			'tgl_submit' => date('Y-m-d H:i:s')
		);

		$this->jalur->save($data);

		redirect(base_url('jalur/manage?alert=success&message=' . urlencode('Berhasil Input Data')));
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
				'deskripsi' => $this->input->post('deskripsi', TRUE),
				'lampiran' => $filename
			);
		} else {
			$data = array(
				'nama' => $this->input->post('nama', TRUE),
				'deskripsi' => $this->input->post('deskripsi', TRUE)
			);
		}

		$this->jalur->update(array('id' => $this->input->post('id')), $data);

		redirect(base_url('jalur/manage?alert=info&message=' . urlencode('Berhasil Update Data')));
	}



	public function ajax_delete($id)
	{
		$this->jalur->delete_by_id($id);

		echo json_encode(array("status" => TRUE));
	}
}
