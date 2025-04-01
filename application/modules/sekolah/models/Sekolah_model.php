<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sekolah_model extends CI_Model
{

    var $table = 'tbl_sekolah';
    var $column_order = array('id_sekolah', NULL); //set column field database for datatable orderable
    var $column_search = array('nama', '',); //set column field database for datatable searchable just fisekolahtname , lastname , address are searchable
    var $order = array('id_sekolah' => 'DESC'); // default order

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        // active record
        $this->db->select('*')->from('tbl_sekolah');

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // fisekolaht loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
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
        $this->db->from('tbl_sekolah');
        $this->db->join('tbl_level_sekolah', 'tbl_sekolah.level_sekolah = tbl_level_sekolah.id');
        $this->db->where('tbl_sekolah.level_sekolah', $level);
        $this->db->order_by('npsn', 'ASC');
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

    function get_sekolah($level)
    {
        $this->db->select("s.npsn, s.nama, s.kuota, p.pendaftar");
        $this->db->from("tbl_sekolah AS s");
        $this->db->join('(SELECT s.pilihan_sekolah_1 AS npsn, COUNT(*) AS pendaftar FROM tbl_siswa AS s WHERE `lock` = "y" GROUP BY s.pilihan_sekolah_1 ) AS p', 'p.npsn = s.npsn', 'LEFT');
        $this->db->where('s.level_sekolah', $level);
        $this->db->order_by('s.npsn', 'ASC');
        return $this->db->get();
    }

    function count_size($npsn, $kelamin, $size)
    {
        $qry = $this->db->query("SELECT COUNT(*) AS jumlah FROM ppdb.tbl_siswa WHERE pilihan_sekolah_1 = '$npsn' AND jk = '$kelamin' AND ukuran_baju = '$size' AND `lock` = 'y'");
        $row = $qry->row();

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
