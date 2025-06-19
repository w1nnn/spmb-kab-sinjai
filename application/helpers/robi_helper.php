<?php
function jumlahPendaftar($npsn)
{
	$ci = &get_instance();
	$ci->db->from('tbl_siswa');
	$ci->db->where('lock', 'y');
	$ci->db->where('pilihan_sekolah_1', $npsn);
	$result = $ci->db->get()->num_rows();
	return $result;
}


function nomorUrut()
{
	date_default_timezone_set('Asia/Jakarta');
	$ci = &get_instance();
	$ci->db->select('RIGHT (tbl_siswa.no_pendaftaran,5) AS kode ', FALSE);
	$ci->db->order_by('no_pendaftaran', 'DESC');
	$ci->db->limit(1);

	$query = $ci->db->get('tbl_siswa');
	$tahun = date('Y');
	if ($query->num_rows() <> 0) {
		$data = $query->row();
		$kode = intval($data->kode) + 1;
	} else {
		$kode = 1;
	}
	$kode_max = str_pad($kode, 5, "0", STR_PAD_LEFT);
	$kode_jadi = "SPMB-KAB-SINJAI-{$tahun}-" . $kode_max;

	return $kode_jadi;
}



function totalByJalur($id)
{
	$ci = &get_instance();
	if (level_user() == "sekolah") {
		$npsn = $ci->session->userdata('npsn');
		$query = $ci->db->get_where('tbl_siswa', array('jalur' => $id, 'pilihan_sekolah_1' => $npsn, 'lock' => 'y'));
		return $query->num_rows();
	} else {
		$query = $ci->db->get_where('tbl_siswa', array('jalur' => $id, 'lock' => 'y'));
		return $query->num_rows();
	}
}

function totalByTingkatan($jalur, $tingkat)
{
	$ci = &get_instance();

	if ($jalur == "") {


		$ci = &get_instance();
		$ci->db->select('tingkat_sekolah,jalur, COUNT(id_siswa) AS total , lock ');
		$ci->db->from('tbl_siswa');
		$ci->db->where('tingkat_sekolah', $tingkat);
		$ci->db->where('lock', 'y');
		$query = $ci->db->get();
		return $query->row()->total;
	} else {

		if (level_user() == "sekolah") {
			$npsn = $ci->session->userdata('npsn');
			$ci = &get_instance();
			$ci->db->select('tingkat_sekolah,jalur, COUNT(id_siswa) AS total , lock ');
			$ci->db->from('tbl_siswa');
			$ci->db->where('jalur', $jalur);
			$ci->db->where('tingkat_sekolah', $tingkat);
			$ci->db->where('pilihan_sekolah_1', $npsn);
			$ci->db->where('lock', 'y');
			$query = $ci->db->get();
			return $query->row()->total;
		} else {
			$ci = &get_instance();
			$ci->db->select('tingkat_sekolah,jalur, COUNT(id_siswa) AS total , lock ');
			$ci->db->from('tbl_siswa');
			$ci->db->where('jalur', $jalur);
			$ci->db->where('tingkat_sekolah', $tingkat);
			$ci->db->where('lock', 'y');
			$query = $ci->db->get();
			return $query->row()->total;
		}
	}
}


function tingkat($id)
{
	$ci = &get_instance();
	$query = $ci->db->get_where('tbl_level_sekolah', array('id' => $id));
	return $query->row();
}

function dusun($id)
{
	$ci = &get_instance();
	$query = $ci->db->get_where('tbl_daerah_zonasi', array('id_master_zonasi' => $id));
	return $query->row();
}


function kecamatan($id)
{
	$ci = &get_instance();
	$query = $ci->db->get_where('kecamatan', array('id_kec' => $id));
	return $query->row();
}


function sekolah($npsn)
{
	$ci = &get_instance();
	$query = $ci->db->get_where('tbl_sekolah', array('npsn' => $npsn));
	return $query->row();
}

function jalur($id)
{
	$ci = &get_instance();
	$query = $ci->db->get_where('tbl_jalur', array('id' => $id));
	return $query->row();
}


function jk($jk)
{
	if ($jk == "L") {
		$kelamin = "Laki - Laki";
	} else if ($jk == "P") {
		$kelamin = "Perempuan";
	}
	return $kelamin;
}

function capital($text)
{
	return ucwords(strtolower($text));
}

function codeRandom()
{
	$code = rand(1, 100);
	return $code . "" . date('mdHi');
}

function random($length, $chars = '')
{
	if (!$chars) {
		$chars = implode(range('a', 'f'));
		$chars .= implode(range('0', '9'));
	}
	$shuffled = str_shuffle($chars);
	return substr($shuffled, 0, $length);
}

function randomCode()
{
	return random(4) . '-' . random(4) . '-' . random(4) . '-' . random(4);
}


function file_get_contents_curl($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
	curl_setopt($ch, CURLOPT_URL, $url);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

function covidIna()
{
	$ci = &get_instance();
	$url = "https://api.kawalcorona.com/indonesia/";
	$get = file_get_contents_curl($url);
	$data = json_decode($get, TRUE);
	return $data[0];
}

function covidPapua()
{
	$ci = &get_instance();
	$url = "https://api.kawalcorona.com/indonesia/provinsi";
	$get = file_get_contents_curl($url);
	$data = json_decode($get, TRUE);
	$result = $data['attributes'];

	foreach ($data as $value) {
		if ($value['attributes']['FID'] == 30) {
			return $value['attributes'];
		}
	}
}


function percentageOf($number, $everything, $decimals = 0)
{
	$result = round($number / $everything * 100, $decimals);
	if (is_nan($result)) {
		$percent = "0";
	} else {
		$percent = $result;
	}
	return $percent;
}


function level_user()
{
	$ci = &get_instance();
	$level = $ci->session->userdata('level');
	return $level;
}

function getSession($key)
{
	$ci = &get_instance();
	return $ci->session->userdata($key);
}

function alert()
{
	$ci = &get_instance();
	$check = $ci->session->flashdata('status');
	if (!empty($check)) {
		$status = $ci->session->flashdata('status');
		$message = $ci->session->flashdata('message');
		$alert = '
		<div class="alert alert-' . $status . '" role="alert">
               <div class="iq-alert-icon">
                    <i class="ri-alert-line"></i>
               </div>
               <div class="iq-alert-text">  ' . $message . '  </div>
        </div>';
	} else {
		$alert = '';
	}

	return $alert;
}

function notification()
{
	$ci = &get_instance();
	$check = $ci->session->flashdata('status');

	if (!empty($check)) {

		echo '<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">'; // css
		echo '<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>'; // js

		$status = $ci->session->flashdata('status');
		$message = $ci->session->flashdata('message');

		echo "
			  <script type='text/javascript'>
		        // Default Configuration
		        $(document).ready(function() {
		            toastr.options = {
		                'closeButton': true,
		                'debug': false,
		                'newestOnTop': false,
		                'progressBar': true,
		                'positionClass': 'toast-bottom-right',
		                'preventDuplicates': false,
		                'showDuration': '1000',
		                'hideDuration': '1000',
		                'timeOut': '4000',
		                'extendedTimeOut': '1000',
		                'showEasing': 'swing',
		                'hideEasing': 'linear',
		                'showMethod': 'fadeIn',
		                'hideMethod': 'fadeOut',
		            }
		        });
		        </script>";

		if ($status == "success") {
			echo "
				<script>
			         $(document).ready(function() {
				        toastr.success('" . $message . "');
				     });
		        </script>
		        ";
		} else if ($status == "warning") {
			echo "
				<script>
			         $(document).ready(function() {
				        toastr.warning('" . $message . "');
				     });
		        </script>
		        ";
		} else if ($status == "danger") {
			echo "
				<script>
			         $(document).ready(function() {
				        toastr.error('" . $message . "');
				     });
		        </script>
		        ";
		} else if ($status == "info") {
			echo "
				<script>
			         $(document).ready(function() {
				        toastr.info('" . $message . "');
				     });
		        </script>
		        ";
		}
	}
}


function clean($str)
{
	echo htmlentities($str, ENT_QUOTES, 'UTF-8');
}


function flashNotif()
{
	$ci = &get_instance();
	$alert = $ci->session->flashdata('alert');
	$message = $ci->session->flashdata('message');
	if (isset($alert)) {
		$notif = notification($alert, $message);
	} else {
		$notif = "";
	}
	return $notif;
}

// function notificatioxn($type, $message)
// {
// 	// external link
// 	// <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.3/animate.min.css">
// 	// <script src="https://cdnjs.cloudflare.com/ajax/libs/mouse0270-bootstrap-notify/3.1.5/bootstrap-notify.min.js"></script>
//
//
// 	$success = "
//     <script>
//     var successNotification = function(){
//         $.notify({
//           // options
//           title: '<strong>Success</strong>',
//           message: '<br>" . $message . "  ',
//         icon: 'icon ion-md-done-all',
//           url: '#',
//           target: '_blank'
//       },{
//           // settings
//           element: 'body',
//           //position: null,
//           type: 'success',
//           allow_dismiss: true,
//           newest_on_top: true,
//           showProgressbar: false,
//           placement: {
//               from: 'top',
//               align: 'right'
//           },
//           offset: 20,
//           spacing: 10,
//           z_index: 1031,
//           delay: 3300,
//           timer: 1000,
//           url_target: '_blank',
//           mouse_over: null,
//           animate: {
//               enter: 'animated fadeInDown',
//               exit: 'animated fadeOutRight'
//           },
//           onShow: null,
//           onShown: null,
//           onClose: null,
//           onClosed: null,
//           icon_type: 'class',
//       });
//       }
//
//
//       window.onload = function() {
//           successNotification();
//           }
//     </script>
//     ";
//
// 	return $success;
// }


function validateParsley($fieldName)
{
	$classParsley = "data-parsley-required  data-parsley-required-message= ";
	$message = "'Wajib Mengisi " . $fieldName . "'";

	$result = $classParsley . "" . $message;

	return $result;
}

function hashRobi($string)
{
	return hash('sha512', $string . config_item('encryption_key'));
}


function xss($str)
{
	echo htmlentities($str, ENT_QUOTES, 'UTF-8');
}


function strip_tags_content($text)
{

	return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
}

function slug($text)
{
	// replace non letter or digits by -
	$text = preg_replace('~[^\pL\d]+~u', '-', $text);

	// transliterate
	// $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

	// remove unwanted characters
	$text = preg_replace('~[^-\w]+~', '', $text);

	// trim
	$text = trim($text, '-');

	// remove duplicate -
	$text = preg_replace('~-+~', '-', $text);

	// lowercase
	$text = strtolower($text);

	return $text;
}


function meta_data($title, $description, $image)
{
	$copyright = "PT. Abhati Meraki Teknologi";
	if ($title == "") {
		$titles = " " . $copyright . "";
	} else {
		$titles = $title . " | " . $copyright . "";
	}

	if ($description == "") {
		$descriptions = "Amtek | " . $copyright . "";
	} else {
		$descriptions = $description;
	}

	if ($image == "") {
		$images = base_url('assets/static/img/logo.png');
	} else {
		$images = base_url() . 'assets/img/' . $image . '';
	}

	$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


	$meta = array('title' => $titles, 'description' => $descriptions, 'image' => $images, 'url' => $url);
	return $meta;
}


function kirim_email($to_email, $subject, $message)
{
	// Konfigurasi email
	$ci = &get_instance();
	$config = [
		'mailtype' => 'html',
		'charset' => 'iso-8859-1',
		'protocol' => 'smtp',
		'smtp_host' => 'ssl://smtp.gmail.com',
		'smtp_user' => 'uki.paulus.apps@gmail.com',    // Ganti dengan email gmail kamu
		'smtp_pass' => 'Informatika12',      // Password gmail kamu
		'smtp_port' => 465,
		'crlf' => "\r\n",
		'newline' => "\r\n"
	];
	// Load library email dan konfigurasinya
	$ci->load->library('email', $config);
	$ci->email->from('uki.paulus.apps@gmail.com', 'noreply | UKI Paulus'); // email asal
	$ci->email->to($to_email); // Ganti dengan email tujuan kamu
	$ci->email->subject($subject); // subjek email
	$ci->email->message($message); // isi pesan email

	$send = $ci->email->send();
	if ($send) {
		$message = "Sukses";
	} else {
		$message = "Gagal";
	}

	return $message;
}

function cek_session()
{
	$ci = &get_instance();
	$session = $ci->session->userdata('isLogin');
	if ($session == '') {
		redirect(base_url());
	}
}

function tgl_indo($tgl)
{
	$tanggal = substr($tgl, 8, 2);
	$bulan = getBulan(substr($tgl, 5, 2));
	$tahun = substr($tgl, 0, 4);
	return $tanggal . ' ' . $bulan . ' ' . $tahun;
}


function getBulan($bln)
{
	switch ($bln) {
		case 1:
			return "Januari";
			break;
		case 2:
			return "Februari";
			break;
		case 3:
			return "Maret";
			break;
		case 4:
			return "April";
			break;
		case 5:
			return "Mei";
			break;
		case 6:
			return "Juni";
			break;
		case 7:
			return "Juli";
			break;
		case 8:
			return "Agustus";
			break;
		case 9:
			return "September";
			break;
		case 10:
			return "Oktober";
			break;
		case 11:
			return "November";
			break;
		case 12:
			return "Desember";
			break;
	}
}

function registerAccess()
{
	$all = false;
	$allow = [
		// 69867959, //SMPN 39
		// 40304535, //SMPN 7
		// 40304701, //SDN 173
		// 40314327, //SMPN 32
	];

	return $all || in_array(getSession('npsn'), $allow);
}
function verifyAccess()
{
	$all = false;
	$allow = [
		// 69867959, //SMPN 39
		// 40304535, //SMPN 7
		// 40304701, //SDN 173
		// 40314327, //SMPN 32
	];

	return $all || in_array(getSession('npsn'), $allow);
}

function isValidJSON($string)
{
	json_decode($string);
	return (json_last_error() == JSON_ERROR_NONE);
}

function configs()
{
	$data = [
		'zonasi' => [
			'start' => null,
			'end' => null,
		],
		'daftar' => [
			'start' => null,
			'end' => null,
		],
		'seleksi' => [
			'start' => null,
			'end' => null,
		],
		'pengumuman' => [
			'start' => null,
			'end' => null,
		],
		'kuota' => [
			'start' => null,
			'end' => null,
		],
		'edit_siswa' => [
			'start' => null,
			'end' => null,
		],
	];

	$jadwal_file = FCPATH . '/uploads/jadwal.json';
	if (is_file($jadwal_file)) {
		$jadwal = file_get_contents($jadwal_file);
		if (isValidJSON($jadwal)) {
			$data = json_decode($jadwal);
		}
	}

	return $data;
}
