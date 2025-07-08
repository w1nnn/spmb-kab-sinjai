<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa_model extends CI_Model
{

    var $table = 'tbl_siswa';
    var $column_order = array('id', null);
    var $column_search = array('nama_siswa', 'no_ktp', 'no_kk', 'pilihan_sekolah_1', 'no_pendaftaran'); //set column field database for datatable searchable just fisiswatname , lastname , address are searchable
    var $order = array('id' => 'DESC'); 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        if (level_user() == "sekolah") {
            $jalur = $this->input->get('jalur');
			$npsn  = $this->session->userdata('npsn');
			if ($jalur == "") {
				$this->db->select('*');
				$this->db->from('tbl_siswa');
				$this->db->where('pilihan_sekolah_1', $npsn);
				$this->db->where('lock', 'y');
			} else {
				$this->db->select('*');
				$this->db->from('tbl_siswa');
				$this->db->where('pilihan_sekolah_1', $npsn);
				$this->db->where('jalur', $jalur);
				$this->db->where('lock', 'y');
			}
        } elseif (level_user() == "admin" or level_user() == "superadmin" or level_user() == "kadis") {

            $jalur   = $this->input->get('jalur');
            $tingkat = $this->input->get('tingkat');
            $npsn  = $this->input->get('npsn');
            $sts_dtks = $this->input->get('sts_dtks');
			log_message('debug', 'DTKS value received: ' . $sts_dtks);

            $this->db->select('*');
            $this->db->from('tbl_siswa');
            if ($tingkat) {
                $this->db->where('tingkat_sekolah', $tingkat);
            }
            if ($jalur) {
                $this->db->where('jalur', $jalur);
            }
            if ($npsn) {
                $this->db->where('pilihan_sekolah_1', $npsn);
            }
            if ($sts_dtks !== null && $sts_dtks !== '') {
				$this->db->where('sts_dtks', $sts_dtks);
			}
            $this->db->where('lock', 'y');
        }


        $i = 0;

        foreach ($this->column_search as $item) 
        {
            if ($_POST['search']['value']) 
            {
                if ($i === 0) 
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }

        if (isset($_POST['order']))
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_all()
    {
        $this->db->from('tbl_siswa');
        $this->db->order_by('id_siswa', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_by_id($id)
    {
        $this->db->select('* ');
        $this->db->from('tbl_siswa');
        $this->db->where('id_siswa', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function profil($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_siswa');
        $this->db->join('kecamatan', 'tbl_siswa.kec = kecamatan.id_kec');
        $this->db->join('tbl_daerah_zonasi', 'tbl_siswa.dusun = tbl_daerah_zonasi.id_master_zonasi');
        $this->db->where('tbl_siswa.id_siswa', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function getByNoHp($hp)
    {
        $this->db->select('* ');
        $this->db->from('tbl_siswa');
        $this->db->where('no_hp_ortu', $hp);
        $query = $this->db->get();
        return $query->row();
    }

    public function getByNoKtp($no)
    {
        $this->db->select('* ');
        $this->db->from('tbl_siswa');
        $this->db->where('no_ktp', $no);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getByNoKtpOther($no, $id)
    {
        $this->db->select('* ');
        $this->db->from('tbl_siswa');
        $this->db->group_start();
        $this->db->where('no_ktp', $no);
        $this->db->where('id_siswa !=', $id);
        $this->db->group_end();
        $query = $this->db->get();
        return $query->num_rows();
    }

   public function getBySekolah($npsn, $jalur, $sts_dtks)
{
    $this->db->select('*');
    $this->db->from('tbl_siswa');
    $this->db->where('pilihan_sekolah_1', $npsn);
    $this->db->where('lock', 'y');
    
    if ($jalur != "all" && $jalur != "" && $jalur !== null) {
        $this->db->where('jalur', $jalur);
    }
    
    if ($sts_dtks !== null && $sts_dtks !== '') {
        $this->db->where('sts_dtks', $sts_dtks);
    }
    $this->db->order_by('tgl_daftar', 'DESC');
    return $this->db->get()->result();
}

    public function getByCustom()
    {
        $jalur = $this->input->get('jalur');
        $tingkat = $this->input->get('tingkat');
        $npsn = $this->input->get('npsn');
        $sts_dtks = $this->input->get('sts_dtks');

        $this->db->select('*');
        $this->db->from('tbl_siswa');
        if ($jalur && $jalur != 'all') {
            $this->db->where('jalur', $jalur);
        }
        if ($tingkat) {
            $this->db->where('tingkat_sekolah', $tingkat);
        }
        if ($npsn) {
            $this->db->where('pilihan_sekolah_1', $npsn);
        }
        if ($sts_dtks !== null && $sts_dtks !== '') {
            $this->db->where('sts_dtks', $sts_dtks);
        }
        $this->db->where('lock', 'y');
        $this->db->order_by('tingkat_sekolah', 'asc');
        $this->db->order_by('pilihan_sekolah_1', 'asc');
        $this->db->order_by('nama_siswa', 'asc');

        return $this->db->get()->result();
    }

    public function auth($email, $password)
    {
        $password = sha1(md5($password));
        $this->db->where('no_ktp', $email);
        $this->db->where('password', $password);
        $query = $this->db->get('tbl_siswa');
        if ($query->num_rows() == 1) {
            foreach ($query->result() as $row) {
                $data = array(
                    'id' => $row->id_siswa,
                    'nama' => $row->nama_siswa,
                    'no_hp_ortu' => $row->no_hp_ortu,
                    'level' => "siswa",
                    'isLogin' => TRUE
                );
            }
            $this->session->set_userdata($data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function save($data)
    {
        $result = $this->db->insert($this->table, $data);
        return $result;
    }

    public function update($where, $data)
    {
        $this->db->set($data);
        $this->db->where($where);
        $this->db->update($this->table);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id)
    {
        $this->db->where('id_siswa', $id);
        $this->db->delete($this->table);
    }
   
    public function getLulusanByAsalSekolah($nama_sekolah)
    {
        if (empty($nama_sekolah)) {
            return array();
        }
        
        $this->db->select('*');
        $this->db->from('tbl_siswa');
        $this->db->where('asal_sekolah', $nama_sekolah);
        $this->db->where('sts_daftar', 1);
        $query = $this->db->get();
        
        return $query->result();
    }

}