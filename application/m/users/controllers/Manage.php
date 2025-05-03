<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Manage extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model', 'user');
	}

	public function index()
	{
		cek_session();
		$data['title'] = "User";
		$data['subtitle'] = "Kelola User";
		$this->template->load('home/layouts', 'manage/vList', $data);
	}

	public function edit()
	{
		cek_session();
		$id = $this->uri->segment(4);
		$data['title'] = "Edit User";
		$data['subtitle'] = "User > Edit";
		$data['get'] = $this->user->get_by_id($id);
		$this->template->load('home/layouts', 'manage/vEdit', $data);
	}


	public function add()
	{
		cek_session();
		$data['title'] = "User";
		$data['subtitle'] = "Tambah User";
		$this->template->load('home/layouts', 'manage/vAdd', $data);
	}


	public function ajax_list()
	{
		cek_session();
		$list = $this->user->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $user) {
			if ($user->is_active == 'y') {
				$status = ' <span class="badge badge-success">Active</span> ';
			} else {
				$status = ' <span class="badge badge-success">Blocked</span> ';
			}

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $user->nama;
			$row[] = $user->username;
			$row[] = $user->level;
			$row[] = $status;
			$row[] = '<a href="' . base_url() . 'users/manage/edit/' . $user->id . '"  class="btn btn-sm btn-warning mr-1 "> <i class="ri-edit-2-line "></i> Edit</a>
					  <a href="#" class="btn btn-danger btn-sm "  onclick="delete_(' . "'" . $user->id . "'" . ')">  <i class="ri-delete-bin-2-line "></i> Hapus</a> ';

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

		$nama = $this->input->post('nama', TRUE);
		$username = $this->input->post('username', TRUE);
		$password = $this->input->post('password', TRUE);
		$repassword = $this->input->post('repassword', TRUE);
		$level = $this->input->post('level', TRUE);

		if ($this->user->get_by_username($username)) {
			$message = urlencode("Username telah digunakan");
			redirect($_SERVER['HTTP_REFERER'] . "?alert=danger&message={$message}");
		}

		if ($password !== $repassword) {
			$message = urlencode("Perulangan Password tidak benar");
			redirect($_SERVER['HTTP_REFERER'] . "?alert=danger&message={$message}");
		}

		$data = [
			'nama' => $nama,
			'username' => $username,
			'password' => sha1(md5($password)),
			'level' => $level,
			'is_active' => 'y',
		];

		$this->user->save($data);

		$message = urlencode("Berhasil Input Data");
		redirect(base_url("users/manage?alert=success&message={$message}"));
	}



	public function update()
	{
		cek_session();

		$id = $this->input->post('id', TRUE);
		$nama = $this->input->post('nama', TRUE);
		$username = $this->input->post('username', TRUE);
		$password = $this->input->post('password', TRUE);
		$repassword = $this->input->post('repassword', TRUE);
		$level = $this->input->post('level', TRUE);

		if ($this->user->get_by_other_username($username, $id)) {
			$message = urlencode("Username telah digunakan");
			redirect($_SERVER['HTTP_REFERER'] . "?alert=danger&message={$message}");
		}

		if ($password != '') {
			if ($password !== $repassword) {
				$message = urlencode("Perulangan Password tidak benar");
				redirect($_SERVER['HTTP_REFERER'] . "?alert=danger&message={$message}");
			}
		}

		$data = [
			'nama' => $nama,
			'username' => $username,
			'level' => $level,
		];

		if ($password != '') {
			$data['password'] = sha1(md5($password));
		}

		$this->user->update(array('id' => $id), $data);

		$message = urlencode("Berhasil Update Data");
		redirect(base_url("users/manage?alert=info&message={$message}"));
	}



	public function ajax_delete($id)
	{
		$this->user->delete_by_id($id);

		echo json_encode(array("status" => TRUE));
	}
}
