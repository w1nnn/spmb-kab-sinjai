<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model', 'user');
	}
	
	
	public function index()
	{
		cek_session();
		$this->template->load('home/layouts', 'vList');
	}
	
	public function edit()
	{
		cek_session();
		$id = $this->uri->segment(3);
		$data['get'] = $this->user->get_by_id($id);
		$this->template->load('home/layouts', 'vEdit',$data);
	}
	
	
	public function add()
	{
		cek_session();
		$this->template->load('home/layouts', 'vAdd');
	}
	
	
	public function ajax_list()
	{
		// cek_session();
		$list = $this->user->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $user) {
			
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $user->nama;
			$row[] = $user->wa;
			$row[] = $user->username;
			$row[] = '<a href="'.base_url().'user/edit/'.$user->id_users.'"  class="btn btn-warning mb-2 mr-2 rounded-circle"> <i class="fa fa-edit"></i>
					  <a href="#" class="btn btn-danger mb-2 mr-2 rounded-circle" onclick="delete_('."'".$user->id_users."'".')">  <i class="fa fa-trash"></i>';
			
			$data[] = $row;
		}
		
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->user->count_all(),
			"recordsFiltered" => $this->user->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	
	
	public function save()
	{
		cek_session();
		$data = array('nama' => $this->input->post('nama', TRUE),
			'wa' => $this->input->post('wa', TRUE),
			'username' => $this->input->post('username', TRUE),
			'password' => md5($this->input->post('password', TRUE)),
			'passcode' => $this->input->post('password', TRUE)
		);
		$this->user->save($data);
		$this->session->set_flashdata(array('message' => "success"));
		redirect(base_url('user'));
	}
	
	
	public function update()
	{
		cek_session();
		$data = array('nama' => $this->input->post('nama', TRUE),
			'wa' => $this->input->post('wa', TRUE),
			'username' => $this->input->post('username', TRUE),
			'password' => md5($this->input->post('password', TRUE)),
			'passcode' => $this->input->post('password', TRUE)
		);
		$this->user->update(array('id_users' => $this->input->post('id')), $data);
		$this->session->set_flashdata(array('message' => "success"));
		redirect(base_url('user'));
	}
	
	
	public function ajax_delete($id)
	{
		$this->user->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
	
	
	
}
