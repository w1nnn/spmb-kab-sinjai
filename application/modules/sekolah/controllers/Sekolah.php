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
        $data['kecamatans'] = $this->kecamatan->get_all();
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
        $data['subtitle'] = "SPMB Kabupaten Sinjai";
        $data['get'] = $this->sekolah->get_by_id($id);
        $data['kecamatans'] = $this->kecamatan->get_all();
        $this->template->load('home/layouts', 'vProfil', $data);
    }

    public function tambah()
    {
        cek_session();
        $data['title'] = "Tambah Sekolah";
        $data['subtitle'] = "SPMB Kabupaten Sinjai";
        $data['tingkats'] = $this->sekolah->get_level_sekolah();
        $data['kecamatans'] = $this->kecamatan->get_all();
        $this->template->load('home/layouts', 'vAdd', $data);
    }


   public function laporan()
{
    cek_session();
    $jalur = $this->input->get('jalur');
    $sts_dtks = $this->input->get('sts_dtks'); // Tambahkan parameter status DTKS
    
    if (level_user() == "sekolah") {
        $npsn = $this->session->userdata('npsn');
        $data['siswas'] = $this->siswa->getBySekolah($npsn, $jalur, $sts_dtks);
    } elseif (level_user() == "admin" || level_user() == "superadmin") {
        $npsn = $this->input->get('npsn');
        $data['siswas'] = $this->siswa->getBySekolah($npsn, $jalur, $sts_dtks);
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
        $sts_dtks = $this->input->get('sts_dtks'); // Tambahkan parameter status DTKS
        if (level_user() == "sekolah") {
            $npsn = $this->session->userdata('npsn');
            $data['siswas'] = $this->siswa->getBySekolah($npsn, $jalur, $sts_dtks);
        } elseif (level_user() == "admin" || level_user() == "superadmin") {
            $npsn = $this->input->get('npsn');
            $data['siswas'] = $this->siswa->getBySekolah($npsn, $jalur, $sts_dtks);
        }

        $this->load->view('vExcel', $data);
    }

    // public function export()
    // {
    //     $level = $this->input->get('level');

    //     $data['sekolah'] = $this->sekolah->get_sekolah($level);

    //     $this->load->view('vExport', $data);
    // }


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
            redirect(base_url('sekolah/profil/' . $npsn . '?alert=info&message=' . urlencode('Sukses update data')));
        } else {

            redirect(base_url('sekolah/tambah?alert=danger&message=' . urlencode(':( Gagal Menyimpan, NPSN Telah Terdaftar')));
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
    
        // Add CSS for the modern card design and hover animations
        $output .= '
        <style>
            .modern-school-card {
                background: #ffffff;
                border-radius: 16px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
                padding: 20px;
                transition: all 0.3s ease;
                height: 100%;
                border: 1px solid #f0f0f0;
                overflow: hidden;
                position: relative;
                margin-bottom: 25px;
            }
            
            .modern-school-card:before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(90deg, #3498db, #2ecc71);
                transform: scaleX(0);
                transform-origin: 0 50%;
                transition: transform 0.4s ease;
            }
            
            .modern-school-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
            }
            
            .modern-school-card:hover:before {
                transform: scaleX(1);
            }
            
            .school-card-body {
                padding: 0;
            }
            
            .school-logo {
                width: 70px;
                height: 70px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 12px;
                background: #f8f9fa;
                padding: 8px;
                overflow: hidden;
                transition: all 0.3s ease;
            }
            
            .school-logo img {
                max-width: 100%;
                max-height: 100%;
                object-fit: contain;
                transition: transform 0.3s ease;
            }
            
            .modern-school-card:hover .school-logo img {
                transform: scale(1.1);
            }
            
            .modern-school-card:hover .school-logo {
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }
            
            .school-info {
                margin-left: 16px;
                flex: 1;
            }
            
            .school-name {
                font-weight: 600;
                color: #333;
                margin-bottom: 6px;
                font-size: 17px;
                transition: color 0.3s ease;
                line-height: 1.3;
            }
            
            .modern-school-card:hover .school-name {
                color: #3498db;
            }
            
            .school-address {
                font-size: 13px;
                color: #6c757d;
                margin-bottom: 8px;
                display: flex;
                align-items: flex-start;
            }
            
            .school-address i {
                margin-right: 5px;
                color: #3498db;
                font-size: 14px;
                margin-top: 3px;
            }
            
            .school-stats {
                margin-top: 10px;
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 5px;
            }
            
            .stat-item {
                font-size: 12px;
                color: #6c757d;
                padding: 5px;
                border-radius: 6px;
                background: #f8f9fa;
                transition: all 0.3s ease;
            }
            
            .modern-school-card:hover .stat-item {
                background: #edf7ff;
            }
            
            .stat-item i {
                color: #3498db;
                margin-right: 4px;
            }
            
            .stat-value {
                font-weight: 600;
                color: #333;
                display: block;
                font-size: 14px;
                padding-top: 3px;
            }
            
            .sisa-kuota {
                color: #2ecc71;
            }
            
            .no-result-card {
                border-left: 4px solid #e74c3c;
            }
        </style>';
    
        if ($data->num_rows() > 0) {
            foreach ($data->result() as $value) {
                $sisaKuota = ($value->kuota - $value->pendaftar) ?? 0;
                $kuotaClass = $sisaKuota > 0 ? 'sisa-kuota' : 'text-danger';
                
                $output .= '
                <div class="col-lg-4">
                    <a href="' . base_url() . 'sekolah/profil/' . $value->npsn . '/' . slug($value->nama) . '" class="text-decoration-none">
                        <div class="modern-school-card">
                            <div class="school-card-body">
                                <div class="d-flex align-items-start">
                                    <div class="school-logo">
                                        <img src="' . base_url() . 'assets/images/' . $value->logo . '" class="img-fluid" alt="logo">
                                    </div>
                                    <div class="school-info">
                                        <h6 class="school-name">' . $value->nama . '</h6>
                                        <div class="school-address">
                                            <i class="ri-map-pin-fill"></i>
                                            <div>' . ucwords(strtolower($value->alamat)) . ', Kecamatan ' . kecamatan($value->kec)->nama_kec . '</div>
                                        </div>
                                        
                                        <div class="school-stats">
                                            <div class="stat-item">
                                                <i class="ri-user-fill"></i> Kuota
                                                <span class="stat-value">' . ($value->kuota ?? 0) . ' Orang</span>
                                            </div>
                                            <div class="stat-item">
                                                <i class="ri-registered-fill"></i> Pendaftar
                                                <span class="stat-value">' . ($value->pendaftar ?? 0) . ' Orang</span>
                                            </div>
                                            <div class="stat-item">
                                                <i class="ri-user-fill"></i> Sisa
                                                <span class="stat-value ' . $kuotaClass . '">' . $sisaKuota . ' Orang</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>';
            }
        } else {
            $output .= '
            <div class="col-md-6 offset-3">
                <div class="modern-school-card no-result-card">
                    <div class="school-card-body">
                        <div class="d-flex align-items-center">
                            <div class="school-logo">
                                <img src="' . base_url() . 'assets/images/blank.svg" class="img-fluid" alt="logo">
                            </div>
                            <div class="school-info">
                                <h5 class="text-danger"><b>Sekolah Tidak Ditemukan!</b></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
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

    public function cari_kecamatan()
    {
        $output = '';
        $kecamatan = '';
        $level = '';

        if ($this->input->post('kecamatan')) {
            $kecamatan = $this->input->post('kecamatan');
        }

        if ($this->input->post('level')) {
            $level = $this->input->post('level');
        }

        // var_dump($kecamatan, $level);

        $data = $this->sekolah->fetch_data_by_kecamatan($kecamatan, $level);
        $output .= '
        <style>
            .modern-school-card {
                background: #ffffff;
                border-radius: 16px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
                padding: 20px;
                transition: all 0.3s ease;
                height: 100%;
                border: 1px solid #f0f0f0;
                overflow: hidden;
                position: relative;
                margin-bottom: 25px;
            }
            
            .modern-school-card:before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(90deg, #3498db, #2ecc71);
                transform: scaleX(0);
                transform-origin: 0 50%;
                transition: transform 0.4s ease;
            }
            
            .modern-school-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
            }
            
            .modern-school-card:hover:before {
                transform: scaleX(1);
            }
            
            .school-card-body {
                padding: 0;
            }
            
            .school-logo {
                width: 70px;
                height: 70px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 12px;
                background: #f8f9fa;
                padding: 8px;
                overflow: hidden;
                transition: all 0.3s ease;
            }
            
            .school-logo img {
                max-width: 100%;
                max-height: 100%;
                object-fit: contain;
                transition: transform 0.3s ease;
            }
            
            .modern-school-card:hover .school-logo img {
                transform: scale(1.1);
            }
            
            .modern-school-card:hover .school-logo {
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }
            
            .school-info {
                margin-left: 16px;
                flex: 1;
            }
            
            .school-name {
                font-weight: 600;
                color: #333;
                margin-bottom: 6px;
                font-size: 17px;
                transition: color 0.3s ease;
                line-height: 1.3;
            }
            
            .modern-school-card:hover .school-name {
                color: #3498db;
            }
            
            .school-address {
                font-size: 13px;
                color: #6c757d;
                margin-bottom: 8px;
                display: flex;
                align-items: flex-start;
            }
            
            .school-address i {
                margin-right: 5px;
                color: #3498db;
                font-size: 14px;
                margin-top: 3px;
            }
            
            .school-stats {
                margin-top: 10px;
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 5px;
            }
            
            .stat-item {
                font-size: 12px;
                color: #6c757d;
                padding: 5px;
                border-radius: 6px;
                background: #f8f9fa;
                transition: all 0.3s ease;
            }
            
            .modern-school-card:hover .stat-item {
                background: #edf7ff;
            }
            
            .stat-item i {
                color: #3498db;
                margin-right: 4px;
            }
            
            .stat-value {
                font-weight: 600;
                color: #333;
                display: block;
                font-size: 14px;
                padding-top: 3px;
            }
            
            .sisa-kuota {
                color: #2ecc71;
            }
            
            .no-result-card {
                border-left: 4px solid #e74c3c;
            }
        </style>';
        if ($data->num_rows() > 0) {
            foreach ($data->result() as $value) {
                $sisaKuota = ($value->kuota - $value->pendaftar) ?? 0;
                $kuotaClass = $sisaKuota > 0 ? 'sisa-kuota' : 'text-danger';
                // var_dump($value->pendaftar);
                $output .= '
                <div class="col-lg-4">
                    <a href="' . base_url() . 'sekolah/profil/' . $value->npsn . '/' . slug($value->nama) . '" class="text-decoration-none">
                        <div class="modern-school-card">
                            <div class="school-card-body">
                                <div class="d-flex align-items-start">
                                    <div class="school-logo">
                                        <img src="' . base_url() . 'assets/images/' . $value->logo . '" class="img-fluid" alt="logo">
                                    </div>
                                    <div class="school-info">
                                        <h6 class="school-name">' . $value->nama . '</h6>
                                        <div class="school-address">
                                            <i class="ri-map-pin-fill"></i>
                                            <div>' . ucwords(strtolower($value->alamat)) . ', Kecamatan ' . kecamatan($value->kec)->nama_kec . '</div>
                                        </div>
                                        
                                        <div class="school-stats">
                                            <div class="stat-item">
                                                <i class="ri-user-fill"></i> Kuota
                                                <span class="stat-value">' . ($value->kuota ?? 0) . ' Orang</span>
                                            </div>
                                            <div class="stat-item">
                                                <i class="ri-registered-fill"></i> Pendaftar
                                                <span class="stat-value">' . ($value->pendaftar ?? 0) . ' Orang</span>
                                            </div>
                                            <div class="stat-item">
                                                <i class="ri-user-fill"></i> Sisa
                                                <span class="stat-value ' . $kuotaClass . '">' . $sisaKuota . ' Orang</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>';
            }
        } else {
            $output .= '
            <div class="col-md-6 offset-3">
                <div class="modern-school-card no-result-card">
                    <div class="school-card-body">
                        <div class="d-flex align-items-center">
                            <div class="school-logo">
                                <img src="' . base_url() . 'assets/images/blank.svg" class="img-fluid" alt="logo">
                            </div>
                            <div class="school-info">
                                <h5 class="text-danger"><b>Sekolah Tidak Ditemukan!</b></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }

        echo $output;
    }

    public function cari_dusun()
{
    $output = '';
    $dusun = '';
    $level = '';
    $keamatan = '';

    if ($this->input->post('dusun')) {
        $dusun = $this->input->post('dusun');
    }

    if ($this->input->post('level')) {
        $level = $this->input->post('level');
    }
   
    $data = $this->sekolah->fetch_data_by_dusun($dusun, $level);
    // var_dump($data);
    $output .= '
    <style>
        .modern-school-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 20px;
            transition: all 0.3s ease;
            height: 100%;
            border: 1px solid #f0f0f0;
            overflow: hidden;
            position: relative;
            margin-bottom: 25px;
        }
        
        .modern-school-card:before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3498db, #2ecc71);
            transform: scaleX(0);
            transform-origin: 0 50%;
            transition: transform 0.4s ease;
        }
        
        .modern-school-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }
        
        .modern-school-card:hover:before {
            transform: scaleX(1);
        }
        
        .school-card-body {
            padding: 0;
        }
        
        .school-logo {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: #f8f9fa;
            padding: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .school-logo img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            transition: transform 0.3s ease;
        }
        
        .modern-school-card:hover .school-logo img {
            transform: scale(1.1);
        }
        
        .modern-school-card:hover .school-logo {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .school-info {
            margin-left: 16px;
            flex: 1;
        }
        
        .school-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 6px;
            font-size: 17px;
            transition: color 0.3s ease;
            line-height: 1.3;
        }
        
        .modern-school-card:hover .school-name {
            color: #3498db;
        }
        
        .school-address {
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 8px;
            display: flex;
            align-items: flex-start;
        }
        
        .school-address i {
            margin-right: 5px;
            color: #3498db;
            font-size: 14px;
            margin-top: 3px;
        }
        
        .school-stats {
            margin-top: 10px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 5px;
        }
        
        .stat-item {
            font-size: 12px;
            color: #6c757d;
            padding: 5px;
            border-radius: 6px;
            background: #f8f9fa;
            transition: all 0.3s ease;
        }
        
        .modern-school-card:hover .stat-item {
            background: #edf7ff;
        }
        
        .stat-item i {
            color: #3498db;
            margin-right: 4px;
        }
        
        .stat-value {
            font-weight: 600;
            color: #333;
            display: block;
            font-size: 14px;
            padding-top: 3px;
        }
        
        .sisa-kuota {
            color: #2ecc71;
        }
        
        .no-result-card {
            border-left: 4px solid #e74c3c;
        }
    </style>';
    
    if ($data->num_rows() > 0) {
        foreach ($data->result() as $value) {
            $sisaKuota = ($value->kuota - $value->pendaftar) ?? 0;
            $kuotaClass = $sisaKuota > 0 ? 'sisa-kuota' : 'text-danger';
            
            $output .= '
            <div class="col-lg-4">
                <a href="' . base_url() . 'sekolah/profil/' . $value->npsn . '/' . slug($value->nama) . '" class="text-decoration-none">
                    <div class="modern-school-card">
                        <div class="school-card-body">
                            <div class="d-flex align-items-start">
                                <div class="school-logo">
                                    <img src="' . base_url() . 'assets/images/' . $value->logo . '" class="img-fluid" alt="logo">
                                </div>
                                <div class="school-info">
                                    <h6 class="school-name">' . $value->nama . '</h6>
                                    <div class="school-address">
                                        <i class="ri-map-pin-fill"></i>
                                        <div>' . ucwords(strtolower($value->alamat)) . ', Dusun ' . $value->dusun . ', Kecamatan ' . kecamatan($value->kec)->nama_kec . '</div>
                                    </div>
                                    
                                    <div class="school-stats">
                                        <div class="stat-item">
                                            <i class="ri-user-fill"></i> Kuota
                                            <span class="stat-value">' . ($value->kuota ?? 0) . ' Orang</span>
                                        </div>
                                        <div class="stat-item">
                                            <i class="ri-registered-fill"></i> Pendaftar
                                            <span class="stat-value">' . ($value->pendaftar ?? 0) . ' Orang</span>
                                        </div>
                                        <div class="stat-item">
                                            <i class="ri-user-fill"></i> Sisa
                                            <span class="stat-value ' . $kuotaClass . '">' . $sisaKuota . ' Orang</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>';
        }
    } else {
        $output .= '
        <div class="col-md-6 offset-3">
            <div class="modern-school-card no-result-card">
                <div class="school-card-body">
                    <div class="d-flex align-items-center">
                        <div class="school-logo">
                            <img src="' . base_url() . 'assets/images/blank.svg" class="img-fluid" alt="logo">
                        </div>
                        <div class="school-info">
                            <h5 class="text-danger"><b>Sekolah Tidak Ditemukan di Dusun ' . $dusun . '!</b></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }

    echo $output;
}

   // Fungsi ukuran yang diperbaiki untuk mendukung dusun
public function ukuran()
{
    $kecamatan = $this->input->get('kecamatan');
    $dusun = $this->input->get('dusun');
    $level = $this->input->get('level');
    $status_dtks = $this->input->get('sts_dtks');

    // Tentukan method yang akan digunakan berdasarkan parameter
    if (!empty($dusun) && $dusun !== 'Pilih Dusun') {
        $qry_sekolah = $this->sekolah->fetch_data_by_dusun($dusun, $level)->result();
    } elseif (!empty($kecamatan)) {
        $qry_sekolah = $this->sekolah->fetch_data_by_kecamatan($kecamatan, $level)->result();
    } else {
        $qry_sekolah = $this->sekolah->get_by_level($level);
    }

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
            $count_l = $this->sekolah->count_size($value->npsn, 'L', $v, $status_dtks);
            $count_p = $this->sekolah->count_size($value->npsn, 'P', $v, $status_dtks);

            $l[$value->npsn][$v] = $count_l;
            $p[$value->npsn][$v] = $count_p;
        }

        $record[] = [
            'npsn'     => $value->npsn,
            'nama'     => $value->nama,
            'alamat'   => $value->alamat,
            'kel'      => $value->kel,
            'kec'      => $value->nama_kec,
            'dusun'    => $value->dusun,
            'ukuran_l' => $l[$value->npsn],
            'ukuran_p' => $p[$value->npsn]
        ];
    }

    $data = [
        'record' => $record,
        'ukuran' => $ukuran,
        'status_dtks' => $status_dtks,
        'dusun' => $dusun
    ];
    
    $this->load->view('vUkuran', $data);
}

// Fungsi export yang diperbaiki untuk mendukung dusun
public function export()
{
    $kecamatan = $this->input->get('kecamatan');
    $dusun = $this->input->get('dusun');
    $level = $this->input->get('level');
    $status_dtks = $this->input->get('sts_dtks'); 
    
    // Tentukan method yang akan digunakan berdasarkan parameter
    if (!empty($dusun) && $dusun !== 'Pilih Dusun') {
        // Jika ada filter dusun, gunakan method khusus untuk dusun
        $sekolah = $this->sekolah->get_sekolah_by_dusun($level, $dusun, $status_dtks);
    } elseif (!empty($kecamatan)) {
        // Jika ada filter kecamatan, gunakan method yang sudah ada
        $sekolah = $this->sekolah->get_sekolah($level, $kecamatan, $status_dtks);
    } else {    
        // Jika tidak ada filter lokasi, ambil berdasarkan level saja
        $sekolah = $this->sekolah->get_sekolah($level, '', $status_dtks);
    }
    
    $data = [
        'sekolah' => $sekolah,
        'kecamatan' => $kecamatan,
        'dusun' => $dusun,
        'status_dtks' => $status_dtks
    ];
    
    $this->load->view('vExport', $data);
}
    // public function ukuran()
    // {
    //     $level = $this->input->get('level');

    //     $qry_sekolah = $this->sekolah->get_sekolah($level)->result();

    //     $record = [];
    //     $l = [];
    //     $p = [];
    //     $ukuran = [
    //         'S',
    //         'M',
    //         'L',
    //         'XL',
    //         'XXL'
    //     ];

    //     foreach ($qry_sekolah as $key => $value) {
    //         foreach ($ukuran as $v) {
    //             $count_l = $this->sekolah->count_size($value->npsn, 'L', $v);
    //             $count_p = $this->sekolah->count_size($value->npsn, 'P', $v);

    //             $l[$value->npsn][$v] = $count_l;
    //             $p[$value->npsn][$v] = $count_p;
    //         }

    //         $record[] = [
    //             'npsn'     => $value->npsn,
    //             'nama'     => $value->nama,
    //             'ukuran_l' => $l[$value->npsn],
    //             'ukuran_p' => $p[$value->npsn]
    //         ];
    //     }

    //     $data = [
    //         'record' => $record,
    //         'ukuran' => $ukuran
    //     ];

    //     $this->load->view('vUkuran', $data);
    // }
    public function delete()
    {
        if (level_user() == "superadmin") {
            $id = $this->uri->segment(3);
            $this->sekolah->delete_by_id($id);
            redirect(base_url('sekolah?alert=danger&message=' . urlencode('Berhasil menghapus data sekolah')));
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
            'kel' => $this->input->post('dusun', TRUE),
            'kec' => $this->input->post('kec', TRUE),
            // kordinat
            'kordinat' => $this->input->post('kordinat', TRUE),
            // Dusun
            'dusun' => $this->input->post('dusun', TRUE),
            'status' => $this->input->post('status', TRUE),
            'email' => $this->input->post('email', TRUE),
            'no_hp' => $this->input->post('no_hp', TRUE),
            'no_hp_kepsek' => $this->input->post('no_hp_kepsek', TRUE),
            'username' => $npsn,
        );

        $this->sekolah->update(array('id_sekolah' => $id), $data);

        $alert = urlencode('info');
        $message = urlencode('Sukses update data');

        if (level_user() == "superadmin" or level_user() == "admin") {
            redirect(base_url('sekolah/profil/' . $npsn . '?alert=' . $alert . '&message=' . $message));
        } else {
            redirect(base_url('sekolah/profil?alert=' . $alert . '&message=' . $message));
        }
    }


    public function updateKuota()
    {
        cek_session();
        $npsn = $this->input->post('npsn');
        $data = array('kuota' => $this->input->post('kuota', TRUE));
        $this->sekolah->update(array('npsn' => $npsn), $data);

        $alert = urlencode('info');
        $message = urlencode('Sukses update data');

        if (level_user() == "superadmin" || level_user() == "admin") {
            redirect(base_url('sekolah/profil/' . $npsn . '?alert=' . $alert . '&message=' . $message));
        } else {
            redirect(base_url('sekolah/profil?alert=' . $alert . '&message=' . $message));
        }
    }
    
    // Kuota Kelulusan
    // public function updateKuotaLulusan()
    // {
    //     cek_session();
    //     $npsn = $this->input->post('npsn');
    //     $data = array('kuota_lulusan' => $this->input->post('kuota_lulusan', TRUE));
    //     $this->sekolah->update(array('npsn' => $npsn), $data);

    //     $alert = urlencode('info');
    //     $message = urlencode('Sukses update data');

    //     if (level_user() == "superadmin" || level_user() == "admin") {
    //         redirect(base_url('sekolah/profil/' . $npsn . '?alert=' . $alert . '&message=' . $message));
    //     } else {
    //         redirect(base_url('sekolah/profil?alert=' . $alert . '&message=' . $message));
    //     }
    // }
    public function updateKuotaLulusan()
{
    cek_session();
    $npsn = $this->input->post('npsn');
    $kuota = $this->input->post('kuota_lulusan', TRUE);

    $data = array(
        'kuota_lulusan' => $kuota,
        'lulusan' => $kuota // update kolom 'lulusan' dengan nilai yang sama
    );

    $this->sekolah->update(array('npsn' => $npsn), $data);

    $alert = urlencode('info');
    $message = urlencode('Sukses update data');

    if (level_user() == "superadmin" || level_user() == "admin") {
        redirect(base_url('sekolah/profil/' . $npsn . '?alert=' . $alert . '&message=' . $message));
    } else {
        redirect(base_url('sekolah/profil?alert=' . $alert . '&message=' . $message));
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
            $alert = 'success';
            $message = 'Password Berhasil Diupdate';
        } else {
            $alert = 'danger';
            $message = 'Gagal, Password Lama Salah.';
        }

        $alert = urlencode($alert);
        $message = urlencode($message);

        if (level_user() == "superadmin" || level_user() == "admin") {
            redirect(base_url('sekolah/profil/' . $npsn . '?alert=' . $alert . '&message=' . $message));
        } else {
            redirect(base_url('sekolah/profil?alert=' . $alert . '&message=' . $message));
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

        $alert = urlencode('success');
        $message = urlencode('Password Berhasil Direset');

        if (level_user() == "superadmin" || level_user() == "admin") {
            redirect(base_url('sekolah/profil/' . $npsn . '?alert=' . $alert . '&message=' . $message));
        } else {
            redirect(base_url('sekolah/profil?alert=' . $alert . '&message=' . $message));
        }
    }

    /**
 * Method to get all schools for select2 dropdown
 */
    public function get_all_sekolah()
    {
        // Check if this is an AJAX request
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        
        // Query to get all schools from database
        $query = $this->db->select('nama')
                        ->from('tbl_sekolah')
                        ->order_by('nama', 'ASC')
                        ->get();
        
        $schools = $query->result();
        
        // Build options for select2
        $options = '<option value=""></option>';
        
        foreach ($schools as $school) {
            $options .= '<option value="' . htmlspecialchars($school->nama) . '">' . htmlspecialchars($school->nama) . '</option>';
        }
        
        // Return response as JSON
        $response = array(
            'list_sekolah' => $options
        );
        
        echo json_encode($response);
    }

        public function get_school_quota()
    {
        // Check if this is an AJAX request
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        
        $school_name = $this->input->post('school_name');
        
        // Get school data from database
        $school = $this->db->get_where('tbl_sekolah', ['npsn' => $school_name])->row();
        $pendaftar = jumlahPendaftar($school_name);
        if ($school) {
            echo json_encode([
                'exists' => true,
                'quota' => (int)$school->kuota,
                'npsn' => $school->npsn,
                'pendaftar' => $pendaftar

            ]);
        } else {
            echo json_encode([
                'exists' => false
            ]);
        }
    }

    public function lulusan()
    {
        cek_session();
        
        $nama_sekolah = $this->input->get('nama');
        
        if (level_user() == "sekolah") {
            $nama_sekolah = $nama_sekolah ? $nama_sekolah : $this->session->userdata('nama_sekolah');
            $data['siswas'] = $this->siswa->getLulusanByAsalSekolah($nama_sekolah);
        } elseif (level_user() == "admin" || level_user() == "superadmin") {
            $data['siswas'] = $this->siswa->getLulusanByAsalSekolah($nama_sekolah);
            $data['sekolah'] = $this->sekolah->get_all();
        }

        $data['title'] = "Lulusan";
        $data['subtitle'] = "Data Lulusan";
        $data['nama_sekolah'] = $nama_sekolah;

        $this->template->load('home/layouts', 'vLulusan', $data);
    }

    public function exlulusan()
    {
        cek_session();
        
        $nama_sekolah = $this->input->get('nama');
        
        if (level_user() == "sekolah") {
            $nama_sekolah = $nama_sekolah ? $nama_sekolah : $this->session->userdata('nama_sekolah');
            $data['siswas'] = $this->siswa->getLulusanByAsalSekolah($nama_sekolah);
        } elseif (level_user() == "admin" || level_user() == "superadmin") {
            $data['siswas'] = $this->siswa->getLulusanByAsalSekolah($nama_sekolah);
            $data['sekolah'] = $this->sekolah->get_all();
        }

        $data['title'] = "Lulusan";
        $data['subtitle'] = "Data Lulusan";
        $data['nama_sekolah'] = $nama_sekolah;

        $this->template->load('home/layouts', 'exLulusan', $data);
    }

}
