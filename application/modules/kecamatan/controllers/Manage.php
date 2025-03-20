<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('kecamatan_model', 'kecamatan');
	}

	public function index()
	{
		cek_session();
		$data['title'] = "Kecamatan";
		$data['subtitle'] = "Kelola Kecamatan";
		$this->template->load('home/layouts', 'manage/vList', $data);
	}

	public function edit()
	{
		cek_session();
		$id = $this->uri->segment(4);
		$data['title'] = "Edit Kecamatan";
		$data['subtitle'] = "Kecamatan > Edit";
		$data['get'] = $this->kecamatan->get_by_id($id);
		$this->template->load('home/layouts', 'manage/vEdit', $data);
	}


	public function add()
	{
		cek_session();
		$data['title'] = "Kecamatan";
		$data['subtitle'] = "Tambah Kecamatan";
		$this->template->load('home/layouts', 'manage/vAdd', $data);
	}


	public function ajax_list()
	{
		cek_session();
		$list = $this->kecamatan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $kecamatan) {

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $kecamatan->nama_kec;
			$row[] = '<a href="' . base_url() . 'kecamatan/manage/edit/' . $kecamatan->id_kec . '"  class="btn btn-sm btn-warning mr-1 "> <i class="ri-edit-2-line "></i> Edit</a>
					  <a href="#"  class="btn btn-danger btn-sm "  onclick="delete_(' . "'" . $kecamatan->id_kec . "'" . ')">  <i class="ri-delete-bin-2-line "></i> Hapus</a> ';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->kecamatan->count_all(),
			"recordsFiltered" => $this->kecamatan->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}


	public function save()
	{
		cek_session();
		$data = array('nama_kec' => $this->input->post('nama_kec', TRUE));
		$this->kecamatan->save($data);
		$this->session->set_flashdata(array('status' => "success", 'message' => "Berhasil Input Data"));
		redirect(base_url('kecamatan/manage'));
	}


	public function update()
	{
		cek_session();
		$data = array('nama_kec' => $this->input->post('nama_kec', TRUE));

		$this->kecamatan->update(array('id_kec' => $this->input->post('id')), $data);
		$this->session->set_flashdata(array('status' => "info", 'message' => "Berhasil Update Data"));
		redirect(base_url('kecamatan/manage'));
	}


	public function ajax_delete($id)
	{
		$this->kecamatan->delete_by_id($id);
		$this->session->set_flashdata(array('status' => "danger"));

		echo json_encode(array("status" => TRUE));
	}


}
