<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Jalur extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('jalur_model', 'jalur');
	}
	
	public function index()
	{
		$data['title'] = "Jalur Pendaftaran ";
		$data['subtitle'] = "Home > Jalur Pendaftaran";
		$data['jalurs'] = $this->jalur->get_all();
		
		$this->template->load('home/layouts', 'vFront',$data);
	}
	
	public function detail()
	{
		$data['title'] = "Jalur Pendaftaran ";
		$data['subtitle'] = "Home > Jalur Pendaftaran";
		$id = $this->uri->segment(3);
		$data['get'] = $this->jalur->get_by_id($id);
		$this->template->load('home/layouts', 'vDetail',$data);
	}
	
	
	
}
