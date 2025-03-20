<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Login_model', 'login');
	}


	public function index()
	{
		if ($this->session->userdata('isLogin') == 1) {
			redirect(base_url('home/dashboard'));
		} else {
			$this->load->view('login');
		}
	}


	public function validate()
	{
		$email = $this->input->post('username', TRUE);
		$password = $this->input->post('password', TRUE);
		if ($this->login->authAdmin($email, $password)) {

			$this->session->set_flashdata(array('message' => "success"));
			redirect(base_url('home/dashboard'));
		} else if ($this->login->authSekolah($email, $password)) {

			$this->session->set_flashdata(array('message' => "success"));
			redirect(base_url('home/dashboard'));
		} else {

			$this->session->set_flashdata(array('message' => "fail", "email" => $email, 'password' => $password));
			redirect(base_url('login'));
		}
	}


	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
