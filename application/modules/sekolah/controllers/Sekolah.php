<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Sekolah extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('sekolah_model', 'sekolah');
        $this->load->model('siswa/siswa_model', 'siswa');
        $this->load->model('kecamatan/kecamatan_model', 'kecamatan');
        $this->load->model('jalur/jalur_model', 'jalur');
    }


    public function index()
    {
        // die('ads');
        $id = $this->input->get('level');
        $level = ($id == "") ? 'All' : $id;
        $query = $this->sekolah->get_by_level_sekolah($id);
        $sekolah = $query->row()->desc;
        $data['title'] = "Daftar " . $sekolah . "";
        $data['subtitle'] = "Kabupaten Sinjai";
        $data['level'] = $level;
        $this->template->load('home/layouts', 'vFront', $data);
    }


    public function profil()
    {
        if (level_user() == "sekolah") {
            $id = $this->session->userdata('npsn');
        } else {
            $id = $this->uri->segment(3);
        }

        $data['title'] = "Profil Sekolah";
        $data['subtitle'] = "PPDB Kabupaten Sinjai";
        $data['get'] = $this->sekolah->get_by_id($id);
        $data['kecamatans'] = $this->kecamatan->get_all();
        $this->template->load('home/layouts', 'vProfil', $data);
    }

    public function tambah()
    {
        cek_session();
        $data['title'] = "Tambah Sekolah";
        $data['subtitle'] = "PPDB Kabupaten Sinjai";
        $data['tingkats'] = $this->sekolah->get_level_sekolah();
        $data['kecamatans'] = $this->kecamatan->get_all();
        $this->template->load('home/layouts', 'vAdd', $data);
    }


    public function laporan()
    {
        cek_session();
        $jalur = $this->input->get('jalur');
        if (level_user() == "sekolah") {
            $npsn = $this->session->userdata('npsn');
            $data['siswas'] = $this->siswa->getBySekolah($npsn, $jalur);
        } elseif (level_user() == "admin" || level_user() == "superadmin") {
            $npsn = $this->input->get('npsn');
            $data['siswas'] = $this->siswa->getBySekolah($npsn, $jalur);
            $data['sekolah'] = $this->sekolah->get_all();
        }

        $data['title'] = "Laporan";
        $data['subtitle'] = "Laporan Pendaftar";
        $data['jalurs'] = $this->jalur->get_all();

        $this->template->load('home/layouts', 'vLaporan', $data);
    }


    public function excel()
    {
        cek_session();
        $jalur = $this->input->get('jalur');
        if (level_user() == "sekolah") {
            $npsn = $this->session->userdata('npsn');
            $data['siswas'] = $this->siswa->getBySekolah($npsn, $jalur);
        } elseif (level_user() == "admin" || level_user() == "superadmin") {
            $npsn = $this->input->get('npsn');
            $data['siswas'] = $this->siswa->getBySekolah($npsn, $jalur);
        }

        $this->load->view('vExcel', $data);
    }

    public function export()
    {
        $level = $this->input->get('level');

        $data['sekolah'] = $this->sekolah->get_sekolah($level);
        
        $this->load->view('vExport', $data);
    }

    public function ukuran()
    {
        $level = $this->input->get('level');

        $qry_sekolah = $this->sekolah->get_sekolah($level)->result();

        $record = [];
        $l = [];
        $p = [];
        $ukuran = [
            'S',
            'M',
            'L',
            'XL',
            'XXL'
        ];

        foreach ($qry_sekolah as $key => $value) {
            foreach ($ukuran as $v) {
                $count_l = $this->sekolah->count_size($value->npsn, 'L', $v);
                $count_p = $this->sekolah->count_size($value->npsn, 'P', $v);

                $l[$value->npsn][$v] = $count_l;
                $p[$value->npsn][$v] = $count_p;
            }

            $record[] = [
                'npsn'     => $value->npsn,
                'nama'     => $value->nama,
                'ukuran_l' => $l[$value->npsn],
                'ukuran_p' => $p[$value->npsn]
            ];
        }

        $data = [
            'record' => $record,
            'ukuran' => $ukuran
        ];

        $this->load->view('vUkuran', $data);
    }





    public function save()
    {
        cek_session();
        $npsn = $this->input->post('npsn');
        $cek = $this->db->get_where('tbl_sekolah', array('npsn' => $npsn))->num_rows();
        if ($cek == 0) {
            $data = array(
                'level_sekolah' => $this->input->post('tingkat', TRUE),
                'npsn' => $this->input->post('npsn', TRUE),
                'nama' => $this->input->post('nama', TRUE),
                'alamat' => $this->input->post('alamat', TRUE),
                'kel' => $this->input->post('kel', TRUE),
                'kec' => $this->input->post('kec', TRUE),
                'kab' => "7307",
                'status' => $this->input->post('status', TRUE),
                'email' => $this->input->post('email', TRUE),
                'no_hp' => $this->input->post('no_hp', TRUE),
                'no_hp_kepsek' => $this->input->post('no_hp_kepsek', TRUE),
                'username' => $this->input->post('npsn', TRUE),
                'password' => sha1(md5($this->input->post('npsn', TRUE))),
            );
            $npsn = $this->input->post('npsn', TRUE);
            $this->sekolah->save($data);
            $this->session->set_flashdata(array('status' => "info", "message" => "Sukses update data"));
            redirect(base_url('sekolah/profil/' . $npsn . ''));
        } else {

            $this->session->set_flashdata(array('status' => "danger", "message" => ":( Gagal Menyimpan, NPSN Telah Terdaftar"));
            redirect(base_url('sekolah/tambah'));
        }
    }



    public function cari()
    {
        $output = '';
        $query = '';
        $level = '';

        if ($this->input->post('query')) {
            $query = $this->input->post('query');
        }

        if ($this->input->post('level')) {
            $level = $this->input->post('level');
        }

        $data = $this->sekolah->fetch_data($query, $level);

        if ($data->num_rows() > 0) {
            foreach ($data->result() as $value) {
                $output .= '
				 <div class="col-lg-4">
					<a href="' . base_url() . 'sekolah/profil/' . $value->npsn . '/' . slug($value->nama) . ' ">
						<div class="iq-card iq-card-block iq-card-stretch iq-card-height iq-bg-primary-warning-hover ">
							<div class="iq-card-body">
								<div class="d-flex align-items-center">
									<div class="rounded-circle iq-card-icon">
										<img src="' . base_url() . 'assets/images/' . $value->logo . '" class="img-fluid" alt="logo">
									</div>
									<div class="text-left ml-3">
										<h6 class="text-secondary"><b> ' . $value->nama . '</b></h6>
										<small class="mb-0 text-muted"><i class="ri-map-pin-fill"></i> ' . ucwords(strtolower($value->alamat)) .  '<br><i class="ri-map-pin-fill"></i>   Kecamatan ' . kecamatan($value->kec)->nama_kec . '  </small> <br>
										<small class="mb-0 text-muted"><i class="ri-user-fill"></i> Kuota Diterima :   <b> ' . ($value->kuota ?? 0) . ' Orang </b> </small> <br>
										<small class="mb-0 text-muted"><i class="ri-registered-fill"></i> Pendaftar :   <b> ' . ($value->pendaftar ?? 0) . ' Orang </b> </small>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>

			';
            }
        } else {
            $output .= '
				<div class="col-md-6 offset-3">
					<div class="iq-card iq-card-block iq-card-stretch iq-card-height iq-bg-primary-warning-hover ">
							<div class="iq-card-body">
								<div class="d-flex align-items-center">
									<div class="rounded-circle iq-card-icon">
										<img src="' . base_url() . 'assets/images/blank.svg" class="img-fluid" alt="logo">
									</div>
									<div class="text-left ml-3">
										<h5 class="text-danger"><b> Sekolah Tidak Ditemukan !!  </b></h5>
									</div>
								</div>
							</div>
					</div>
				</div>
			';
        }

        echo $output;
    }


    public function cari_all()
    {
        $output = '';
        $query = '';

        if ($this->input->post('query')) {
            $query = $this->input->post('query');
        }

        $data = $this->sekolah->cari_sekolah($query);
        if ($query == "") {
            $output .= '';
        } else {

            if ($data->num_rows() > 0) {
                foreach ($data->result() as $value) {
                    $output .= '
				 <div class="col-lg-4">
					<a href="' . base_url() . 'sekolah/profil/' . $value->npsn . '/' . slug($value->nama) . ' ">
						<div class="iq-card iq-card-block iq-card-stretch iq-card-height iq-bg-primary-warning-hover ">
							<div class="iq-card-body">
								<div class="d-flex align-items-center">
									<div class="rounded-circle iq-card-icon">
										<img src="' . base_url() . 'assets/images/' . $value->logo . '" class="img-fluid" alt="logo">
									</div>
									<div class="text-left ml-3">
										<h6 class="text-secondary"><b> ' . $value->nama . '</b></h6>
										<small class="mb-0 text-muted"><i class="ri-map-pin-fill"></i> ' . ucwords(strtolower($value->alamat)) . ',' . ucwords(strtolower($value->kel)) . '  </small>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
				 ';
                }
            } else {
                $output .= '
				<div class="col-md-6 offset-3">
					<div class="iq-card iq-card-block iq-card-stretch iq-card-height iq-bg-primary-warning-hover ">
							<div class="iq-card-body">
								<div class="d-flex align-items-center">
									<div class="rounded-circle iq-card-icon">
										<img src="' . base_url() . 'assets/images/blank.svg" class="img-fluid" alt="logo">
									</div>
									<div class="text-left ml-3">
										<h5 class="text-danger"><b> Sekolah Tidak Ditemukan !!  </b></h5>
									</div>
								</div>
							</div>
					</div>
				</div>
			';
            }
        }

        echo $output;
    }

    public function delete()
    {
        if (level_user() == "superadmin") {
            $id = $this->uri->segment(3);
            $this->sekolah->delete_by_id($id);
            $this->session->set_flashdata(array('status' => "danger", "message" => "Berhasil menghapus data sekolah"));
            redirect(base_url('sekolah/'));
        } else {
            echo "Anda siapa ? Ada masalah ? -> robikurniawan.it@gmail.com ";
        }
    }



    /*
	 *  Kecamatan -> Daerah Zonasi -> Sekolah
	 *
	 * */

    public function update()
    {
        cek_session();
        $npsn = $this->input->post('npsn');
        $id = $this->input->post('id');
        $data = array(
            'npsn' => $npsn,
            'nama' => $this->input->post('nama', TRUE),
            'alamat' => $this->input->post('alamat', TRUE),
            'kel' => $this->input->post('kel', TRUE),
            'kec' => $this->input->post('kec', TRUE),
            'status' => $this->input->post('status', TRUE),
            'email' => $this->input->post('email', TRUE),
            'no_hp' => $this->input->post('no_hp', TRUE),
            'no_hp_kepsek' => $this->input->post('no_hp_kepsek', TRUE),
            'username' => $npsn,
        );

        $this->sekolah->update(array('id_sekolah' => $id), $data);
        $this->session->set_flashdata(array('status' => "info", "message" => "Sukses update data"));
        if (level_user() == "superadmin" or level_user() == "admin") {
            redirect(base_url('sekolah/profil/' . $npsn . ''));
        } else {
            redirect(base_url('sekolah/profil'));
        }
    }


    public function updateKuota()
    {
        cek_session();
        $npsn = $this->input->post('npsn');
        $data = array('kuota' => $this->input->post('kuota', TRUE));
        $this->sekolah->update(array('npsn' => $npsn), $data);
        $this->session->set_flashdata(array('status' => "info", "message" => "Sukses update data"));
        if (level_user() == "superadmin" || level_user() == "admin") {
            redirect(base_url('sekolah/profil/' . $npsn . ''));
        } else {
            redirect(base_url('sekolah/profil'));
        }
    }

    public function updatePassword()
    {
        cek_session();
        $npsn = $this->input->post('npsn');
        $pwdLama = sha1(md5($this->input->post('pwdLama')));
        $checkPwd = $this->sekolah->cekPassword($npsn, $pwdLama);
        if ($checkPwd == 1) {
            $pwdBaru = sha1(md5($this->input->post('pwdBaru')));
            $data = array('password' => $pwdBaru);
            $this->sekolah->update(array('npsn' => $npsn), $data);
            $this->session->set_flashdata(array('status' => "success", "message" => "Password Berhasil Diupdate "));
        } else {
            $this->session->set_flashdata(array('status' => "danger", "message" => "Gagal , Password Lama Salah."));
        }

        if (level_user() == "superadmin" || level_user() == "admin") {
            redirect(base_url('sekolah/profil/' . $npsn . ''));
        } else {
            redirect(base_url('sekolah/profil'));
        }
    }



    public function resetpassword()
    {
        cek_session();
        $id = $this->uri->segment(3);
        $npsn = $this->uri->segment(4);
        $pwdReset = sha1(md5($npsn));

        $data = array('password' => $pwdReset);
        $this->sekolah->update(array('id_sekolah' => $id), $data);
        $this->session->set_flashdata(array('status' => "success", "message" => "Password Berhasil Direset "));

        if (level_user() == "superadmin" || level_user() == "admin") {
            redirect(base_url('sekolah/profil/' . $npsn . ''));
        } else {
            redirect(base_url('sekolah/profil'));
        }
    }
}
