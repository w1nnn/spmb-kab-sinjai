<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {


	public function get_all_profil()
	{
		$this->db->from('tbl_profil');
		$query = $this->db->get();

		return $query->result();
    }
    
	public function totalGender()
	{
		if(level_user() == "sekolah") {
			$npsn = $this->session->userdata('npsn'); 
			$laki      = $this->db->get_where('tbl_siswa',array('jk' => "L" , 'pilihan_sekolah_1' => $npsn, 'lock' => 'y' ))->num_rows();
			$perempuan = $this->db->get_where('tbl_siswa',array('jk' => "P" , 'pilihan_sekolah_1' => $npsn, 'lock' => 'y' ))->num_rows();

		}else{
			$laki      = $this->db->get_where('tbl_siswa',array('jk' => "L" , 'lock' => 'y' ))->num_rows();
			$perempuan = $this->db->get_where('tbl_siswa',array('jk' => "P" , 'lock' => 'y' ))->num_rows();
		}
		
		return array('L' => $laki , 'P' => $perempuan );
	}


	public function levelSekolah()
	{
		$this->db->order_by('id','ASC');
		return $this->db->get('tbl_level_sekolah')->result();
	}

	public function top_10($level) {
		$this->db->select('tbl_siswa.pilihan_sekolah_1, COUNT(*) AS total , tbl_sekolah.npsn , tbl_sekolah.nama AS nm_sekolah ');
		$this->db->from('tbl_siswa');
		$this->db->join('tbl_sekolah','tbl_siswa.pilihan_sekolah_1 = tbl_sekolah.npsn ');
		$this->db->where('tbl_siswa.tingkat_sekolah',$level);
		$this->db->where('tbl_siswa.lock','y');
		$this->db->group_by('tbl_siswa.pilihan_sekolah_1');
		$this->db->order_by('total','DESC');
		$this->db->limit('10');
		return $this->db->get()->result();
	}
	// SELECT  pilihan_sekolah_1 , COUNT(*) as total  FROM tbl_siswa WHERE tingkat_sekolah = '4'  GROUP BY pilihan_sekolah_1 ORDER BY total DESC LIMIT 10


}
