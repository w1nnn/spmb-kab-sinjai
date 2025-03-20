<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('pengumuman_model', 'pengumuman');
	}
	
	public function index()
	{
		cek_session();
		$data['title'] = "Pengumuman";
		$data['subtitle'] = "Kelola Pengumuman";
		$this->template->load('home/layouts', 'manage/vList', $data);
	}
	
	public function edit()
	{
		cek_session();
		$id = $this->uri->segment(4);
		$data['title'] = "Edit Pengumuman";
		$data['subtitle'] = "Pengumuman > Edit";
		$data['get'] = $this->pengumuman->get_by_id($id);
		$this->template->load('home/layouts', 'manage/vEdit', $data);
	}
	
	
	public function add()
	{
		cek_session();
		$data['title'] = "Pengumuman";
		$data['subtitle'] = "Tambah Pengumuman";
		$this->template->load('home/layouts', 'manage/vAdd', $data);
	}
	
	
	public function ajax_list()
	{
		cek_session();
		$list = $this->pengumuman->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pengumuman) {
			
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $pengumuman->nama;
			$row[] = $pengumuman->deskripsi;
			$row[] = $pengumuman->lampiran;
			$row[] = '<a href="' . base_url() . 'pengumuman/manage/edit/' . $pengumuman->id . '"  class="btn btn-sm btn-warning mr-1 "> <i class="ri-edit-2-line "></i> Edit</a>
					  <a href="#" class="btn btn-danger btn-sm "  onclick="delete_(' . "'" . $pengumuman->id . "'" . ')">  <i class="ri-delete-bin-2-line "></i> Hapus</a> ';
			
			$data[] = $row;
		}
		
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->pengumuman->count_all(),
			"recordsFiltered" => $this->pengumuman->count_filtered(),
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
		
		
		$data = array('nama' => $this->input->post('nama', TRUE),
			'deskripsi' => $this->input->post('deskripsi', TRUE),
			'lampiran' => $filename,
			'tgl_submit' => date('Y-m-d H:i:s')
		);
		
		$this->pengumuman->save($data);
		
		$this->session->set_flashdata(array('status' => "success", 'message' => "Berhasil Input Data"));
		redirect(base_url('pengumuman/manage'));
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
			$data = array('nama' => $this->input->post('nama', TRUE),
				'deskripsi' => $this->input->post('deskripsi', TRUE),
				'lampiran' => $filename);
		} else {
			$data = array('nama' => $this->input->post('nama', TRUE), 'deskripsi' => $this->input->post('deskripsi', TRUE));
		}
		
		
		$this->pengumuman->update(array('id' => $this->input->post('id')), $data);
		$this->session->set_flashdata(array('status' => "info", 'message' => "Berhasil Update Data"));
		redirect(base_url('pengumuman/manage'));
	}
	
	
	public function ajax_delete($id)
	{
		$this->pengumuman->delete_by_id($id);
		$this->session->set_flashdata(array('status' => "danger", 'message' => "Berhasil Input Data"));
		
		echo json_encode(array("status" => TRUE));
	}
	
	
}
