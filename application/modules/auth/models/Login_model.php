<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_model extends CI_Model
{

	public function authAdmin($email, $password)
	{
		$password = sha1(md5($password));
		$this->db->where('username', $email);
		$this->db->where('password', $password);
		$query = $this->db->get('tbl_admin');
		if ($query->num_rows() == 1) {
			foreach ($query->result() as $row) {
				$data = array(
					'id' => $row->id_users,
					'username' => $row->username,
					'nama' => $row->nama,
					'level' => $row->level,
					'isLogin' => TRUE
				);
			}
			$this->session->set_userdata($data);
			return TRUE;
		} else {
			return FALSE;
		}
	}


	public function authSekolah($email, $password)
	{
		$password = sha1(md5($password));
		$this->db->where('username', $email);
		$this->db->where('password', $password);
		$query = $this->db->get('tbl_sekolah');
		if ($query->num_rows() == 1) {
			foreach ($query->result() as $row) {
				$data = array(
					'id' => $row->id_sekolah,
					'npsn' => $row->npsn,
					'username' => $row->username,
					'nama' => $row->nama,
					'level' => "sekolah",
					'isLogin' => TRUE
				);
			}
			$this->session->set_userdata($data);
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
