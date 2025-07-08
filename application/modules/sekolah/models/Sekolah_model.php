<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sekolah_model extends CI_Model
{

    var $table = 'tbl_sekolah';
    var $column_order = array('id_sekolah', NULL); 
    var $column_search = array('nama', '',); 
    var $order = array('id_sekolah' => 'DESC'); 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        $this->db->select('*')->from('tbl_sekolah');

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
    public function get_by_level($level)
{
    $this->db->select('tbl_sekolah.*, tbl_level_sekolah.*, kecamatan.nama_kec');
    $this->db->from('tbl_sekolah');
    $this->db->join('tbl_level_sekolah', 'tbl_sekolah.level_sekolah = tbl_level_sekolah.id');
    $this->db->join('kecamatan', 'tbl_sekolah.kec = kecamatan.id_kec', 'LEFT');
    $this->db->where('tbl_sekolah.level_sekolah', $level);
    $this->db->order_by('kecamatan.nama_kec', 'ASC');
    $this->db->order_by('tbl_sekolah.kel', 'ASC');
    $query = $this->db->get();
    return $query->result();
}

    function fetch_data($query, $level)
    {
        $this->db->select("tbl_sekolah.*, tbl_level_sekolah.*, kecamatan.id_kec, kecamatan.id_kab, kecamatan.nama_kec, p.pendaftar");
        $this->db->from("tbl_sekolah");
        $this->db->join('tbl_level_sekolah', 'tbl_sekolah.level_sekolah = tbl_level_sekolah.id');
        $this->db->join('kecamatan', 'tbl_sekolah.kec = kecamatan.id_kec');
        $this->db->join('( SELECT s.pilihan_sekolah_1 AS npsn, COUNT(*) AS pendaftar FROM tbl_siswa AS s GROUP BY s.pilihan_sekolah_1 ) AS p', 'p.npsn = tbl_sekolah.npsn', 'LEFT');

        if ($level != 'All') {
            $this->db->where('tbl_sekolah.level_sekolah', $level);
        }

        if ($query != '') {
            $this->db->group_start();
            $this->db->like('tbl_sekolah.nama', $query);
            $this->db->or_like('tbl_sekolah.npsn', $query);
            $this->db->or_like('kecamatan.nama_kec', $query);
            $this->db->group_end();
            $this->db->limit(20);
        }

        $this->db->order_by('tbl_sekolah.npsn', 'ASC');
        return $this->db->get();
    }

function get_sekolah_by_dusun($level, $dusun = '', $status_dtks = '')
{
    $this->db->select("s.npsn, s.nama, s.kuota, p.pendaftar, s.lulusan, s.kel, s.dusun, s.alamat, kec");
    $this->db->from("tbl_sekolah AS s");

    $this->db->join('kecamatan AS k', 's.kec = k.id_kec', 'LEFT');
    $this->db->select('k.nama_kec AS kec'); 

    
    $subquery = "SELECT s.pilihan_sekolah_1 AS npsn, COUNT(*) AS pendaftar FROM tbl_siswa AS s WHERE `lock` = 'y'";
    
    // Kondisi khusus untuk sts_dtks dalam subquery
    if ($status_dtks !== '' && $status_dtks !== null) {
        if ($status_dtks == '2') {
            // Jika sts_dtks = '2', tampilkan siswa yang memiliki SKTM atau sts_dtks = '1'
            $subquery .= " AND (s.sktm IS NOT NULL OR s.sts_dtks = '1')";
        } else {
            // Untuk nilai sts_dtks lainnya, gunakan filter normal
            $subquery .= " AND s.sts_dtks = '$status_dtks'";
        }
    }
    
    $subquery .= " GROUP BY s.pilihan_sekolah_1";
    
    $this->db->join("($subquery) AS p", 'p.npsn = s.npsn', 'LEFT');
    
    if ($dusun != '' && $dusun !== 'Pilih Dusun') {
        $clean_dusun = str_replace(['DUSUN ', 'KELURAHAN ', 'KEL ', 'DESA '], '', strtoupper($dusun));
        $clean_dusun = trim($clean_dusun);
        
        $this->db->group_start();
        $this->db->like('UPPER(s.kel)', strtoupper($dusun));
        $this->db->or_like('UPPER(s.alamat)', strtoupper($dusun));
        $this->db->or_like('UPPER(s.dusun)', strtoupper($dusun));
        
        if ($clean_dusun != strtoupper($dusun)) {
            $this->db->or_like('UPPER(s.kel)', $clean_dusun);
            $this->db->or_like('UPPER(s.alamat)', $clean_dusun);
            $this->db->or_like('UPPER(s.dusun)', $clean_dusun);
        }
        $this->db->group_end();
    }
    
    $this->db->where('s.level_sekolah', $level);
    $this->db->order_by('s.kel', 'ASC');
    return $this->db->get();
}

function get_sekolah($level, $kecamatan = '', $status_dtks = '', $dusun = '')
{
    $this->db->select("s.npsn, s.nama, s.kuota, p.pendaftar, s.lulusan, s.kel, s.dusun, s.alamat, kec");
    $this->db->from("tbl_sekolah AS s");

    $this->db->join('kecamatan AS k', 's.kec = k.id_kec', 'LEFT');
    $this->db->select('k.nama_kec AS kec'); 
    
    $subquery = "SELECT s.pilihan_sekolah_1 AS npsn, COUNT(*) AS pendaftar FROM tbl_siswa AS s WHERE `lock` = 'y'";

    // Kondisi khusus untuk sts_dtks dalam subquery
    if ($status_dtks !== '' && $status_dtks !== null) {
        if ($status_dtks == '2') {
            // Jika sts_dtks = '2', tampilkan siswa yang memiliki SKTM atau sts_dtks = '1'
            $subquery .= " AND (s.sktm IS NOT NULL OR s.sts_dtks = '1')";
        } else {
            // Untuk nilai sts_dtks lainnya, gunakan filter normal
            $subquery .= " AND s.sts_dtks = '$status_dtks'";
        }
    }
    
    $subquery .= " GROUP BY s.pilihan_sekolah_1";
    
    $this->db->join("($subquery) AS p", 'p.npsn = s.npsn', 'LEFT');
    
    if ($kecamatan != '') {
        $this->db->join('kecamatan', 's.kec = kecamatan.id_kec');
        $this->db->where('kecamatan.nama_kec', $kecamatan);
    }
    
    if ($dusun != '' && $dusun !== 'Pilih Dusun') {
        $clean_dusun = str_replace(['DUSUN ', 'KELURAHAN ', 'KEL ', 'DESA '], '', strtoupper($dusun));
        $clean_dusun = trim($clean_dusun);
        
        $this->db->group_start();
        $this->db->like('UPPER(s.kel)', strtoupper($dusun));
        $this->db->or_like('UPPER(s.alamat)', strtoupper($dusun));
        $this->db->or_like('UPPER(s.dusun)', strtoupper($dusun));
        
        if ($clean_dusun != strtoupper($dusun)) {
            $this->db->or_like('UPPER(s.kel)', $clean_dusun);
            $this->db->or_like('UPPER(s.alamat)', $clean_dusun);
            $this->db->or_like('UPPER(s.dusun)', $clean_dusun);
        }
        $this->db->group_end();
    }
    
    $this->db->where('s.level_sekolah', $level);
    $this->db->order_by('k.nama_kec', 'ASC');
    $this->db->order_by('s.kel', 'ASC');
    return $this->db->get();
}

    function count_size($npsn, $kelamin, $size, $status_dtks = '')
{
    $this->db->select("COUNT(*) AS jumlah");
    $this->db->from("spmg9739_spmb.tbl_siswa");
    $this->db->where('pilihan_sekolah_1', $npsn);
    $this->db->where('jk', $kelamin);
    $this->db->where('ukuran_baju', $size);
    $this->db->where('lock', 'y');
    
    // Kondisi khusus untuk sts_dtks
    if ($status_dtks !== '' && $status_dtks !== null) {
        if ($status_dtks == '2') {
            // Jika sts_dtks = '2', tampilkan siswa yang memiliki SKTM atau sts_dtks = '1'
            $this->db->group_start();
            $this->db->where('sktm IS NOT NULL');
            $this->db->or_where('sts_dtks', '1');
            $this->db->group_end();
        } else {
            // Untuk nilai sts_dtks lainnya, gunakan filter normal
            $this->db->where('sts_dtks', $status_dtks);
        }
    }
    
    $query = $this->db->get();
    $row = $query->row();
    
    return $row->jumlah;
}

    function cari_sekolah($query)
    {
        $this->db->select("*");
        $this->db->from("tbl_sekolah");
        $this->db->join('tbl_level_sekolah', 'tbl_sekolah.level_sekolah = tbl_level_sekolah.id');
        $this->db->join('kecamatan', 'tbl_sekolah.kec = kecamatan.id_kec');

        if ($query != '') {
            $this->db->like('nama', $query);
            $this->db->or_like('npsn', $query);
            $this->db->or_like('nama_kec', $query);
            $this->db->limit('9');
        } else {
            $this->db->limit('0');
        }
        $this->db->order_by('npsn', 'ASC');
        return $this->db->get();
    }

    public function get_all()
    {
        $this->db->select('*');
        $this->db->from('tbl_sekolah');
        $this->db->order_by('level_sekolah', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function fetch_data_by_kecamatan($kecamatan = '', $level = '')
    {
        $this->db->select("tbl_sekolah.*, tbl_level_sekolah.*, kecamatan.nama_kec, p.pendaftar");
        $this->db->from("tbl_sekolah");
        $this->db->join('tbl_level_sekolah', 'tbl_sekolah.level_sekolah = tbl_level_sekolah.id');
        $this->db->join('kecamatan', 'tbl_sekolah.kec = kecamatan.id_kec');
        $this->db->join('( SELECT s.pilihan_sekolah_1 AS npsn, COUNT(*) AS pendaftar FROM tbl_siswa AS s WHERE `lock` = \'y\' GROUP BY s.pilihan_sekolah_1 ) AS p', 'p.npsn = tbl_sekolah.npsn', 'LEFT');
    
        if ($kecamatan != '') {
            $this->db->where('kecamatan.nama_kec', $kecamatan);
        }
    
        if ($level != '') {
            $this->db->where('tbl_sekolah.level_sekolah', $level);
        }
    
        $this->db->order_by('tbl_sekolah.kel', 'ASC');
        return $this->db->get();
    }

    public function fetch_data_by_dusun($dusun = '', $level = '')
{
    $this->db->select("tbl_sekolah.*, tbl_level_sekolah.*, kecamatan.nama_kec, p.pendaftar");
    $this->db->from("tbl_sekolah");
    $this->db->join('tbl_level_sekolah', 'tbl_sekolah.level_sekolah = tbl_level_sekolah.id');
    $this->db->join('kecamatan', 'tbl_sekolah.kec = kecamatan.id_kec');
    $this->db->join('( SELECT s.pilihan_sekolah_1 AS npsn, COUNT(*) AS pendaftar FROM tbl_siswa AS s WHERE `lock` = \'y\' GROUP BY s.pilihan_sekolah_1 ) AS p', 'p.npsn = tbl_sekolah.npsn', 'LEFT');

    if ($dusun != '') {
        $clean_dusun = str_replace(['DUSUN ', 'KELURAHAN ', 'KEL ', 'DESA '], '', strtoupper($dusun));
        $clean_dusun = trim($clean_dusun);
        
        $this->db->group_start();
        $this->db->like('UPPER(tbl_sekolah.kel)', strtoupper($dusun));
        $this->db->or_like('UPPER(tbl_sekolah.alamat)', strtoupper($dusun));
        $this->db->or_like('UPPER(tbl_sekolah.dusun)', strtoupper($dusun));
        
        if ($clean_dusun != strtoupper($dusun)) {
            $this->db->or_like('UPPER(tbl_sekolah.kel)', $clean_dusun);
            $this->db->or_like('UPPER(tbl_sekolah.alamat)', $clean_dusun);
            $this->db->or_like('UPPER(tbl_sekolah.dusun)', $clean_dusun);
        }
        $this->db->group_end();
    }

    if ($level != '') {
        $this->db->where('tbl_sekolah.level_sekolah', $level);
    }
    $this->db->order_by('tbl_sekolah.nama', 'ASC');
    return $this->db->get();
}


    public function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_sekolah');
        $this->db->join('kecamatan', 'tbl_sekolah.kec = kecamatan.id_kec');
        $this->db->join('kabupaten', 'tbl_sekolah.kab = kabupaten.id_kab');
        $this->db->join('tbl_level_sekolah', 'tbl_sekolah.level_sekolah = tbl_level_sekolah.id');
        $this->db->where('tbl_sekolah.npsn', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_level_sekolah()
    {
        $this->db->select('*');
        $this->db->from('tbl_level_sekolah');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_by_level_sekolah($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_level_sekolah');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query;
    }

    public function cekPassword($npsn, $pwdLama)
    {
        $this->db->select('*');
        $this->db->from('tbl_sekolah');
        $this->db->where('npsn', $npsn);
        $this->db->where('password', $pwdLama);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function save($data)
    {
        $result = $this->db->insert($this->table, $data);
        return $result;
    }

    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id)
    {
        $this->db->where('id_sekolah', $id);
        $this->db->delete($this->table);
    }
}
