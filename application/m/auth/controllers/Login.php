<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');
class Login extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		// echo "Constructor running"; // Debug line
		$this->load->model('Login_model', 'login');
		// var_dump($this->login); // Debug line
		$this->load->library('session');
		// var_dump($this->session); // Debug line
		$this->load->helper('url');
		$this->load->helper('form');
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

		if ($this->login->authAdmin($email, $password) || $this->login->authSekolah($email, $password)) {
			redirect(base_url('home/dashboard?alert=success&message=' . urlencode('Login berhasil')));
		} else {
			$alert = 'error';
			$message = urlencode('Username atau password salah');
			$encodedEmail = urlencode($email);

			redirect(base_url("login?alert={$alert}&message={$message}&email={$encodedEmail}"));
		}
	}





	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
