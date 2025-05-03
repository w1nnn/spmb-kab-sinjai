<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Zonasi extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('zonasi_model', 'zonasi');
		$this->load->model('sekolah_model', 'sekolah');
		$this->load->model('siswa/siswa_model', 'siswa');
	}

	public function index()
	{
		cek_session();
		$data['title'] = "Daerah Zonasi ";
		$data['subtitle'] = "Kelola Daerah Zonasi";
		$this->template->load('home/layouts', 'zonasi/vList', $data);
	}

	public function edit()
	{
		cek_session();
		$id = $this->uri->segment(4);
		$data['title'] = "Edit Zonasi";
		$data['subtitle'] = "Zonasi > Edit";
		$data['get'] = $this->zonasi->get_by_id($id);
		if (level_user() == "admin" || level_user() == "superadmin") {
			$data['sekolah'] = $this->sekolah->get_all();
		}

		$this->template->load('home/layouts', 'zonasi/vEdit', $data);
	}


	public function add()
	{
		cek_session();
		$data['title'] = "Zonasi";
		$data['subtitle'] = "Tambah Zonasi";
		if (level_user() == "admin" || level_user() == "superadmin") {
			$data['sekolah'] = $this->sekolah->get_all();
		}
		$this->template->load('home/layouts', 'zonasi/vAdd', $data);
	}


	public function ajax_list()
	{
		cek_session();
		$list = $this->zonasi->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $zonasi) {
			$npsn = $zonasi->npsn_sekolah;
			$get_daerah = $this->zonasi->get_daerah_sekolah($npsn);
			$i = 1;
			$dataDaerah = array();
			foreach ($get_daerah as $d) {
				$dKec = $this->db->query("select * from  kecamatan where id_kec='$d->kecamatan'")->row();
				$break = ($i != "1") ? "<br>" : " ";
				$dataDaerah[] = $break . "" . $i . ". " . $d->daerah_zonasi . ' - ' . strtoupper($dKec->nama_kec);
				$i++;
			}

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $zonasi->nama;
			$row[] = $dataDaerah;
			if (level_user() == 'superadmin' || level_user() == 'admin' || (level_user() == 'sekolah' && configs()->zonasi->start <= date('Y-m-d') && configs()->zonasi->end >= date('Y-m-d'))) {
				$row[] = '<a href="' . base_url() . 'sekolah/zonasi/edit/' . $zonasi->id_zonasi . '"  class="btn btn-sm btn-warning mr-1 "> <i class="ri-edit-2-line "></i> Edit</a>
				<a href="#" class="btn btn-danger btn-sm "  onclick="delete_(' . "'" . $zonasi->id_zonasi . "'" . ')">  <i class="ri-delete-bin-2-line "></i> Hapus</a> ';
			} else {
				$row[] = '<a href="javascript:void(0)" class="btn btn-sm btn-secondary" disabled><i class="fa fa-fw fa-lock"></i> Data Terkunci</a>';
			}

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->zonasi->count_all(),
			"recordsFiltered" => $this->zonasi->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}


	public function save()
	{
		if (level_user() == 'superadmin' || level_user() == 'admin' || (level_user() == 'sekolah' && configs()->zonasi->start <= date('Y-m-d') && configs()->zonasi->end >= date('Y-m-d'))) {
			cek_session();
			$npsn = $this->input->post('npsn');
			$countDaerah = count($this->input->post('daerah'));
			for ($i = 0; $i < $countDaerah; $i++) {
				$daerah = $this->input->post('daerah')[$i];
				$data = array('npsn_sekolah' => $npsn, 'id_daerah_zonasi' => $daerah);
				$this->zonasi->save($data);
			}
			$alert = urlencode('success');
			$message = urlencode('Berhasil Input Data');
			redirect(base_url('sekolah/zonasi?alert=' . $alert . '&message=' . $message));
		} else {
			redirect(base_url('sekolah/zonasi'));
		}
	}



	public function update()
	{
		if (level_user() == 'superadmin' || level_user() == 'admin' || (level_user() == 'sekolah' && configs()->zonasi->start <= date('Y-m-d') && configs()->zonasi->end >= date('Y-m-d'))) {
			cek_session();

			$npsn = $this->input->post('npsn');
			$this->db->query("DELETE FROM tbl_zonasi_sekolah WHERE npsn_sekolah = '$npsn'");

			$countDaerah = count($this->input->post('daerah'));
			for ($i = 0; $i < $countDaerah; $i++) {
				$daerah = $this->input->post('daerah')[$i];
				$data = array('npsn_sekolah' => $npsn, 'id_daerah_zonasi' => $daerah);
				$this->zonasi->save($data);
			}

			$alert = urlencode('info');
			$message = urlencode('Berhasil Update Data');
			redirect(base_url('sekolah/zonasi?alert=' . $alert . '&message=' . $message));
		} else {
			redirect(base_url('sekolah/zonasi'));
		}
	}



	public function ajax_delete($id)
	{
		$this->zonasi->delete_by_id($id);

		echo json_encode(array("status" => TRUE));
	}


	public function getDaerah()
	{
		if (!empty($this->input->get('act'))) {

			$id_sekolah = $this->input->post('sekolah');
			$daerah = $this->zonasi->get_all_daerah_zonasi();

			$lists = "<option value=''>Pilih Daerah Zonasi edit  </option>";
			foreach ($daerah as $data) {
				$dkec = $this->db->query("select * from kecamatan where id_kec='$data->kecamatan' limit 1")->row();
				$id_daerah_zonasi = $data->id_master_zonasi;
				$getSelected = $this->db->query("SELECT * FROM tbl_zonasi_sekolah  WHERE id_daerah_zonasi  = '$id_daerah_zonasi' AND npsn_sekolah = '$id_sekolah' ")->row();

				if ($data->id_master_zonasi == $getSelected->id_daerah_zonasi) {
					$selected = "selected";
				} else {
					$selected = "";
				}

				$lists .= "<option value='" . $data->id_master_zonasi . "' " . $selected . "  >" . $data->daerah_zonasi . ' - ' . strtoupper($dkec->nama_kec) . "  </option>"; // Tambahkan tag option ke variabel $lists
			}
		} else {

			$id_sekolah = $this->input->post('sekolah');
			$daerah = $this->zonasi->get_all_daerah_zonasi();

			$lists = "<option value=''>Pilih Daerah Zonasi  </option>";
			foreach ($daerah as $data) {
				$dkec = $this->db->query("select * from kecamatan where id_kec='$data->kecamatan' limit 1")->row();
				$lists .= "<option value='" . $data->id_master_zonasi . "'>" . $data->daerah_zonasi . ' - ' . strtoupper($dkec->nama_kec) . "</option>"; // Tambahkan tag option ke variabel $lists
			}
		}




		$callback = array('list_daerah' => $lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array
		echo json_encode($callback); // konversi varibael $callback menjadi JSON
	}


	public function getDaerahKecamatan()
	{

		$kecamatan = $this->input->post('kecamatan');
		$id_siswa = $this->input->post('id_siswa');
		$get_siswa = $this->siswa->profil($id_siswa);

		$daerah = $this->zonasi->get_daerah_zonasi($kecamatan);
		$lists = "<option value=''> Pilih </option>";
		foreach ($daerah as $data) {

			if ($get_siswa->dusun == $data->id_master_zonasi) {
				$selected = "selected";
			} else {
				$selected = "";
			}

			$lists .= "<option value='" . $data->id_master_zonasi . "' " . $selected . " >" . $data->daerah_zonasi . "</option>"; // Tambahkan tag option ke variabel $lists
		}


		$callback = array('list_daerah' => $lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array
		echo json_encode($callback); // konversi varibael $callback menjadi JSON
	}


	public function get_sekolah()
	{

		$jalur  = $this->input->post('jalur');
		$siswa  = $this->input->post('id_siswa');
		$daerah = $this->input->post('zonasi');

		$get_siswa = $this->siswa->profil($siswa);
		$tingkat = $get_siswa->tingkat_sekolah;

		if ($jalur == "zonasi") {
			$sekolah = $this->zonasi->get_sekolah($daerah, $tingkat);
		} else {
			$sekolah = $this->zonasi->get_sekolah_by_tingkat($tingkat);
		}


		$lists = "<option value=''>Pilih  </option>";

		foreach ($sekolah as $data) {
			if ($get_siswa->pilihan_sekolah_1 == $data->npsn) {
				$selected = "selected";
			} else {
				$selected = "";
			}

			$lists .= "<option value='" . $data->npsn . "' " . $selected . " >" . $data->nama . " </option>"; // Tambahkan tag option ke variabel $lists
		}

		$callback = array('list_sekolah' => $lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array
		echo json_encode($callback); // konversi varibael $callback menjadi JSON
	}


	public function get_sekolah_zonasi()
	{

		$jalur  = $this->input->post('jalur');
		$daerah = $this->input->post('zonasi');
		$siswa  = $this->input->post('id_siswa');
		$area   = $this->input->post('area');

		$get_siswa = $this->siswa->profil($siswa);

		$sekolah = $this->zonasi->get_sekolah($daerah);

		$lists = "<option value=''>-Pilih  </option>";

		foreach ($sekolah as $data) {
			if ($get_siswa->pilihan_sekolah_1 == $data->npsn) {
				$selected = "selected";
			} else {
				$selected = "";
			}

			$lists .= "<option value='" . $data->npsn . "' " . $selected . " >" . $data->nama . " " . $jalur . " - " . $area . " </option>"; // Tambahkan tag option ke variabel $lists
		}

		$callback = array('list_sekolah' => $lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array
		echo json_encode($callback); // konversi varibael $callback menjadi JSON
	}
}
