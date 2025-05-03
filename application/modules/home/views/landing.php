<?php
// Konfigurasi database
$host = "localhost";
$user = "root";
$password = "";
$dbname = "ppdb";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "
    SELECT 
        level_sekolah,
        status,
        COUNT(*) as total
    FROM tbl_sekolah
    WHERE level_sekolah IN (4,5,6)
    GROUP BY level_sekolah, status WITH ROLLUP
";

$stmt = $conn->query($sql);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Siapkan array hasil
$totals = [
    4 => ['NEGERI' => 0, 'SWASTA' => 0, 'TOTAL' => 0], // TK
    5 => ['NEGERI' => 0, 'SWASTA' => 0, 'TOTAL' => 0], // SD
    6 => ['NEGERI' => 0, 'SWASTA' => 0, 'TOTAL' => 0], // SMP
];

// Proses hasil query
foreach ($results as $row) {
    $level = $row['level_sekolah'];
    $status = $row['status'];
    $count = $row['total'];

    if ($level !== null && $status !== null) {
        $totals[$level][$status] = $count;
    } elseif ($level !== null && $status === null) {
        $totals[$level]['TOTAL'] = $count;
    }
}

// Ambil hasilnya ke variabel
$total_tk         = $totals[4]['TOTAL'];
$total_tk_negeri  = $totals[4]['NEGERI'];
$total_tk_swasta  = $totals[4]['SWASTA'];

$total_sd         = $totals[5]['TOTAL'];
$total_sd_negeri  = $totals[5]['NEGERI'];
$total_sd_swasta  = $totals[5]['SWASTA'];

$total_smp        = $totals[6]['TOTAL'];
$total_smp_negeri = $totals[6]['NEGERI'];
$total_smp_swasta = $totals[6]['SWASTA'];

$sql = "
SELECT 
    kecamatan.nama_kec, 
    tbl_sekolah.level_sekolah, 
    COUNT(*) AS total
FROM tbl_sekolah
JOIN tbl_level_sekolah ON tbl_sekolah.level_sekolah = tbl_level_sekolah.id
JOIN kecamatan ON tbl_sekolah.kec = kecamatan.id_kec
WHERE tbl_sekolah.level_sekolah IN (4, 5, 6) -- 4=TK, 5=SD, 6=SMP
GROUP BY kecamatan.nama_kec, tbl_sekolah.level_sekolah
";

$stmt = $conn->query($sql);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Format hasil ke dalam array terstruktur
$data = [];
foreach ($results as $row) {
    $kec = $row['nama_kec'];
    $level = $row['level_sekolah'];
    $data[$level][$kec] = $row['total'];
}

// Contoh pengambilan data
$total_tk_pulau_sembilan = $data[4]['Pulau Sembilan'] ?? 0;
$total_tk_sinjai_barat = $data[4]['Sinjai Barat'] ?? 0;
$total_tk_sinjai_borong = $data[4]['Sinjai Borong'] ?? 0;
$total_tk_sinjai_selatan = $data[4]['Sinjai Selatan'] ?? 0;
$total_tk_sinjai_tengah = $data[4]['Sinjai Tengah'] ?? 0;
$total_tk_sinjai_timur = $data[4]['Sinjai Timur'] ?? 0;
$total_tk_sinjai_utara = $data[4]['Sinjai Utara'] ?? 0;
$total_tk_tellu_limpoe = $data[4]['Tellu Limpoe'] ?? 0;
$total_tk_bulupoddo = $data[4]['Bulupoddo'] ?? 0; // Menambahkan Bulupoddo

$total_sd_pulau_sembilan = $data[5]['Pulau Sembilan'] ?? 0;
$total_sd_sinjai_barat = $data[5]['Sinjai Barat'] ?? 0;
$total_sd_sinjai_borong = $data[5]['Sinjai Borong'] ?? 0;
$total_sd_sinjai_selatan = $data[5]['Sinjai Selatan'] ?? 0;
$total_sd_sinjai_tengah = $data[5]['Sinjai Tengah'] ?? 0;
$total_sd_sinjai_timur = $data[5]['Sinjai Timur'] ?? 0;
$total_sd_sinjai_utara = $data[5]['Sinjai Utara'] ?? 0;
$total_sd_tellu_limpoe = $data[5]['Tellu Limpoe'] ?? 0;
$total_sd_bulupoddo = $data[5]['Bulupoddo'] ?? 0; // Menambahkan Bulupoddo

$total_smp_pulau_sembilan = $data[6]['Pulau Sembilan'] ?? 0;
$total_smp_sinjai_barat = $data[6]['Sinjai Barat'] ?? 0;
$total_smp_sinjai_borong = $data[6]['Sinjai Borong'] ?? 0;
$total_smp_sinjai_selatan = $data[6]['Sinjai Selatan'] ?? 0;
$total_smp_sinjai_tengah = $data[6]['Sinjai Tengah'] ?? 0;
$total_smp_sinjai_timur = $data[6]['Sinjai Timur'] ?? 0;
$total_smp_sinjai_utara = $data[6]['Sinjai Utara'] ?? 0;
$total_smp_tellu_limpoe = $data[6]['Tellu Limpoe'] ?? 0;
$total_smp_bulupoddo = $data[6]['Bulupoddo'] ?? 0; // Menambahkan Bulupoddo

} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
    die();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>SPMB - KAB SINJAI</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta content="" name="keywords">
	<meta content="" name="description">

	<!-- Google Web Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="shortcut icon" href="<?= base_url() ?>assets/images/page-img/29.png" />
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

	<!-- Icon Font Stylesheet -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

	<!-- Libraries Stylesheet -->
	<link href="<?= base_url() ?>assets/landing/lib/lightbox/css/lightbox.min.css" rel="stylesheet">
	<link href="<?= base_url() ?>assets/landing/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


	<!-- Customized Bootstrap Stylesheet -->
	<link href="<?= base_url() ?>assets/landing/css/bootstrap.min.css" rel="stylesheet">

	<!-- Template Stylesheet -->
	<!-- <link href="css/style.css" rel="stylesheet"> -->
	<link href="<?= base_url() ?>assets/landing/css/style.css" rel="stylesheet">
	<style>
		body {
			background-color: #fff;
			position: relative;
			overflow-x: hidden;
			/* Menonaktifkan scroll horizontal */
			overflow-y: auto;
			/* Scroll vertikal tetap aktif */
		}

		body::before {
			content: "";
			position: absolute;
			width: 30vw;
			/* Ukuran lingkaran responsif */
			height: 30vw;
			/* Ukuran lingkaran responsif */
			background: linear-gradient(to right, #21d4fd, #b721ff);
			border-radius: 50%;
			filter: blur(80px);
			top: 4%;
			left: 30px;
			opacity: 0.7;
			z-index: -1;
		}

		.navbar-nav .nav-link {
			color: black;
			/* Warna default */
			transition: color 0.3s ease;
		}

		.navbar-nav .nav-link:hover,
		.navbar-nav .nav-link.active {
			color: #072ac8 !important;
			/* Warna biru saat hover dan aktif */
		}

		/* Dropdown menu */
		.dropdown-menu {
			background-color: #fff;
			/* Warna latar belakang dropdown */
			border: 1px solid #fff;
			/* Opsional: memberi border agar terlihat lebih jelas */
		}

		/* Mengubah warna teks dropdown item saat hover */
		.dropdown-menu .dropdown-item:hover {
			color: blue !important;
			background-color: white !important;
		}

		.carousel-control-prev,
		.carousel-control-next {
			background-color: #1976d2 !important;
		}

		.navbar-nav .nav-link {
			position: relative;
			padding-bottom: 3px;
			/* Bisa disesuaikan */
			transition: color 0.3s ease-in-out;
		}

		.navbar-nav .nav-link::after {
			content: "";
			position: absolute;
			left: 50%;
			bottom: 0;
			width: 0;
			height: 2px;
			/* Ketebalan garis */
			background-color: blue;
			/* Warna garis */
			transition: width 0.3s ease-in-out;
			transform: translateX(-50%);
		}

		.navbar-nav .nav-link:hover::after,
		.navbar-nav .nav-link.active::after {
			width: 40%;
			/* Kurangi panjang garis */
		}

		@media (max-width: 991px) {

			/* Bootstrap breakpoints: tablet & mobile */
			.navbar-nav .nav-link::after {
				display: none;
			}
		}


		@media (max-width: 768px) {
			.col-md-12.col-lg-9 {
				margin-top: 20px !important;
			}

			body::before {
				content: "";
				position: absolute;
				width: 70vw;
				/* Ukuran lingkaran responsif */
				height: 70vw;
				/* Ukuran lingkaran responsif */
				background: linear-gradient(to right, #21d4fd, #b721ff);
				border-radius: 50%;
				filter: blur(80px);
				top: 1%;
				left: 100px;
				opacity: 0.7;
				z-index: -1;
			}

			.navbar-nav .nav-link::after {
				display: none;
			}
		}
	</style>
</head>

<body>

	<!-- Spinner Start -->
	<div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
		<div class="spinner-grow text-info" role="status"></div>
	</div>
	<!-- Spinner End -->


	<!-- Navbar start -->
	<div class="container-fluid fixed-top">
		<div class="container topbar d-none d-lg-block" style="background-color: #fff; 
">
			<div class="d-flex justify-content-between">
				<div class="top-info ps-2">
					<small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-dark">Jl. RA Kartini, Biringere, Kec. Sinjai Utara</a></small>
					<small class="me-3"><i class="fas fa-phone me-2 text-secondary"></i><a href="#" class="text-dark">(+62) 85240884732</a></small>
				</div>
				<div class="top-link pe-2">
					<!-- <a href="#" class="text-white"><small class="text-white mx-2">Privacy Policy</small>/</a>
					<a href="#" class="text-white"><small class="text-white mx-2">Terms of Use</small>/</a> -->
					<a href="https://github.com/w1nnn/spmb-kab-sinjai" target="_blank" class="text-white"><small class="text-dark ms-1">SPMB V2.0</small></a>
				</div>
			</div>
		</div>
		<div class="container px-0">
			<nav class="navbar navbar-light bg-white navbar-expand-xl">
				<a href="" class="navbar-brand">
					<img src="<?= base_url() ?>assets/images/logo-br.jpg" class="img-fluid" alt="" style="width: 160px; height: auto;">
				</a>
				<button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
					<span class="fa fa-bars"></span>
				</button>
				<div class="collapse navbar-collapse bg-white" id="navbarCollapse">
					<div class="navbar-nav mx-auto">
						<a href="<?= base_url() ?>home/dashboard" class="nav-item nav-link active">Beranda</a>
						<div class="nav-item dropdown">
							<a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Siswa</a>
							<div class="dropdown-menu m-0 bg-secondary rounded-0">
								<a href="<?= base_url() ?>siswa/register" class="dropdown-item">Daftar</a>
								<a href="<?= base_url() ?>siswa/login" class="dropdown-item">Login</a>
							</div>
						</div>
						<a href="<?= base_url() ?>sekolah" class="nav-item nav-link">Sekolah</a>
						<a href="<?= base_url() ?>profil/panduan" class="nav-item nav-link">Panduan</a>
						<a href="<?= base_url() ?>siswa/pengumuman" class="nav-item nav-link">Pengumuman</a>
						<a href="<?= base_url() ?>login" class="nav-item nav-link">Admin</a>
						<a href="https://bit.ly/Formpengaduanspmb" target="_blank" class="nav-item nav-link">Pengaduan SPMB</a>
					</div>
				</div>
			</nav>
		</div>
	</div>
	<!-- Navbar End -->


	<!-- Modal Search Start -->
	<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-fullscreen">
			<div class="modal-content rounded-0">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body d-flex align-items-center">
					<div class="input-group w-75 mx-auto d-flex">
						<input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
						<span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal Search End -->


	<!-- Hero Start -->
	<div class="container-fluid py-5 mb-5 hero-header">
		<div class="container py-5">
			<div class="row g-5 align-items-center">
				<div class="col-md-12 col-lg-3">
					<h4 class="mb-3 text-secondary" id="title">Selamat Datang di Platform SPMB</h4>
					<h3 class="mb-5 display-5" id="sub-title">Sistem Penerimaan Murid Baru</h3>
				</div>
				<div class="col-md-12 col-lg-9" style="margin-top: -52px;">
					<div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
						<div class="carousel-inner" role="listbox">
							<div class="carousel-item active rounded">
								<img src="<?= base_url() ?>assets/landing/s1.jpg" class="img-fluid w-100 h-100 rounded" alt="First slide">
								<a href="<?= base_url() ?>siswa/register" class="daftar btn text-white rounded" style="background-color: #0d1b2a; font-size: 14px; box-shadow: rgba(0, 0, 0, 0.2) 0px 60px 40px -7px;
">Daftar</a>
							</div>
							<div class="carousel-item rounded">
								<img src="<?= base_url() ?>assets/landing/s22.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
								<a href="<?= base_url() ?>siswa/register" class="daftar btn text-white rounded" style="background-color: #0d1b2a; font-size: 14px; box-shadow: rgba(0, 0, 0, 0.2) 0px 60px 40px -7px;
">Daftar</a>
							</div>
						</div>
						<button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="visually-hidden">Previous</span>
						</button>
						<button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="visually-hidden">Next</span>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- end -->
<!-- Insert this code right after your Hero section and before the Copyright section -->

<!-- School Data Stats Start -->
<div class="container-fluid py-2 bg-white">
  <div class="container">
    <div class="text-center mx-auto mb-5" style="max-width: 700px;">
      <h1 class="display-5 mb-4">Data Sekolah <span class="text-primary">Kabupaten Sinjai</span></h1>
      <p class="fs-5">Informasi mengenai jumlah sekolah di berbagai jenjang pendidikan</p>
      <div style="width: 70px; height: 3px; background: linear-gradient(90deg, transparent, rgba(0,0,0,0.1), transparent); margin: 15px auto;"></div>
    </div>
    
    <!-- Added CSS for animations -->
    <style>
      .stat-card {
        transition: all 0.4s ease;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        border: 1px solid rgba(255,255,255,0.18);
        background: white;
      }
      
      .stat-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
      }
      
      .stat-number {
        background: linear-gradient(135deg, #666, #333);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 700;
        transition: all 0.3s ease;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s forwards;
        animation-delay: 0.3s;
      }
      
      .card-icon {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        margin-bottom: 15px;
        background: rgba(255,255,255,0.2);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        backdrop-filter: blur(4px);
        transition: all 0.3s ease;
      }
      
      .stat-card:hover .card-icon {
        transform: rotate(10deg) scale(1.1);
      }
      
      .stat-details {
        display: flex;
        justify-content: space-around;
        animation: fadeIn 1s forwards;
        animation-delay: 0.5s;
        opacity: 0;
      }
      
      .stat-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 10px;
        background: linear-gradient(135deg, #333, #666);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
      }
      
      .divider {
        height: 3px;
        width: 50px;
        margin: 15px auto;
        background: linear-gradient(90deg, transparent, rgba(0,0,0,0.1), transparent);
        transition: all 0.3s ease;
      }
      
      .stat-card:hover .divider {
        width: 80px;
      }
      
      .stat-tag {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
        margin-top: 10px;
        transition: all 0.3s ease;
      }
      
      .stat-card:hover .stat-tag {
        transform: scale(1.05);
      }
      
      .tk-card {
        background: linear-gradient(145deg, #fff, #f5f7ff);
        border-top: 5px solid #3b5af5;
      }
      
      .sd-card {
        background: linear-gradient(145deg, #fff, #fff5f0);
        border-top: 5px solid #ff7043;
      }
      
      .smp-card {
        background: linear-gradient(145deg, #fff, #f0f7ff);
        border-top: 5px solid #43a8ff;
      }
      
      .tk-tag {
        background-color: rgba(59, 90, 245, 0.1);
        color: #3b5af5;
      }
      
      .sd-tag {
        background-color: rgba(255, 112, 67, 0.1);
        color: #ff7043;
      }
      
      .smp-tag {
        background-color: rgba(67, 168, 255, 0.1);
        color: #43a8ff;
      }
      
      @keyframes fadeInUp {
        from {
          opacity: 0;
          transform: translateY(20px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }
      
      @keyframes fadeIn {
        from {
          opacity: 0;
        }
        to {
          opacity: 1;
        }
      }
      
      .counter {
        display: inline-block;
        animation: countUp 2s forwards;
      }
      
      @keyframes countUp {
        from {
          opacity: 0;
        }
        to {
          opacity: 1;
        }
      }
    </style>
    
    <div class="row g-4">
      <!-- TK Card -->
      <div class="col-lg-4 col-md-6">
        <div class="stat-card tk-card h-100 p-4">
          <div class="text-center">
            <div class="card-icon" style="background: rgba(59, 90, 245, 0.1);">
              <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 21H21" stroke="#3b5af5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M5 21V7L13 3V21" stroke="#3b5af5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M19 21V11L13 7" stroke="#3b5af5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M9 9V9.01" stroke="#3b5af5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M9 13V13.01" stroke="#3b5af5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M9 17V17.01" stroke="#3b5af5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
            <h3 class="stat-title">Taman Kanak-Kanak</h3>
            <div class="divider"></div>
            <h2 class="display-2 stat-number counter">
              <?= $total_tk ?>
            </h2>
            <div class="stat-details mb-3">
              <div>
                <h6 class="text-secondary mb-1">Negeri</h6>
                <h4>
                  <?= $total_tk_negeri ?>
                </h4>
              </div>
              <div>
                <h6 class="text-secondary mb-1">Swasta</h6>
                <h4>
                  <?= $total_tk_swasta ?>
                </h4>
              </div>
            </div>
            <span class="stat-tag tk-tag">Pendidikan Anak Usia Dini</span>
          </div>
        </div>
      </div>
      
      <!-- SD Card -->
      <div class="col-lg-4 col-md-6">
        <div class="stat-card sd-card h-100 p-4">
          <div class="text-center">
            <div class="card-icon" style="background: rgba(255, 112, 67, 0.1);">
              <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 21H21" stroke="#ff7043" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M5 21V7L13 3V21" stroke="#ff7043" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M19 21V11L13 7" stroke="#ff7043" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M9 9V9.01" stroke="#ff7043" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M9 13V13.01" stroke="#ff7043" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M9 17V17.01" stroke="#ff7043" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
            <h3 class="stat-title">Sekolah Dasar</h3>
            <div class="divider"></div>
            <h2 class="display-2 stat-number counter">
              <?= $total_sd ?>
            </h2>
            <div class="stat-details mb-3">
              <div>
                <h6 class="text-secondary mb-1">Negeri</h6>
                <h4>
                  <?= $total_sd_negeri ?>
                </h4>
              </div>
              <div>
                <h6 class="text-secondary mb-1">Swasta</h6>
                <h4>
                  <?= $total_sd_swasta ?>
                </h4>
              </div>
            </div>
            <span class="stat-tag sd-tag">Pendidikan Dasar</span>
          </div>
        </div>
      </div>
      
      <!-- SMP Card -->
      <div class="col-lg-4 col-md-6 mx-auto">
        <div class="stat-card smp-card h-100 p-4">
          <div class="text-center">
            <div class="card-icon" style="background: rgba(67, 168, 255, 0.1);">
             <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 21H21" stroke="#fdd835" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M5 21V7L13 3V21" stroke="#fdd835" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M19 21V11L13 7" stroke="#fdd835" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M9 9V9.01" stroke="#fdd835" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M9 13V13.01" stroke="#fdd835" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M9 17V17.01" stroke="#fdd835" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
            <h3 class="stat-title">SMP</h3>
            <div class="divider"></div>
            <h2 class="display-2 stat-number counter">
              <?= $total_smp ?>
            </h2>
            <div class="stat-details mb-3">
              <div>
                <h6 class="text-secondary mb-1">Negeri</h6>
                <h4>
                  <?= $total_smp_negeri ?>
                </h4>
              </div>
              <div>
                <h6 class="text-secondary mb-1">Swasta</h6>
                <h4>
                  <?= $total_smp_swasta ?>
                </h4>
              </div>
            </div>
            <span class="stat-tag smp-tag">Pendidikan Menengah Pertama</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- School Data Stats End -->

<!-- School Data Chart Start -->
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f8f9fa, #f0f2f5);">
  <div class="container py-3">
    <!-- <div class="text-center mx-auto mb-5" style="max-width: 700px;">
      <h2 class="display-6" style="background: linear-gradient(135deg, #333, #666); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Perbandingan Data Sekolah Kabupaten Sinjai</h2>
      <p class="text-muted">Visualisasi distribusi sekolah per jenjang berdasarkan data PPDB</p>
      <div style="width: 70px; height: 3px; background: linear-gradient(90deg, transparent, rgba(0,0,0,0.1), transparent); margin: 15px auto;"></div>
    </div> -->
    
    <style>
      .chart-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border: 1px solid rgba(255,255,255,0.8);
        transition: all 0.4s ease;
        background: white;
        position: relative;
      }
      
      .chart-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
      }
      
      .chart-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, #3b5af5, #43a8ff, #ff7043);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.4s ease;
      }
      
      .chart-card:hover::before {
        transform: scaleX(1);
      }
      
      .chart-container {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInChart 1s forwards;
        animation-delay: 0.2s;
      }
      
      @keyframes fadeInChart {
        from {
          opacity: 0;
          transform: translateY(20px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }
      
      .chart-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
        position: relative;
        display: inline-block;
        padding-bottom: 10px;
      }
      
      .chart-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 40px;
        height: 2px;
        background: linear-gradient(90deg, #3b5af5, #43a8ff);
      }
      
      .stats-row {
        margin-bottom: 2rem;
      }
      
      .stats-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        text-align: center;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
      }
      
      .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
      }
      
      .stats-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, rgba(59, 90, 245, 0.1), rgba(59, 90, 245, 0.2));
      }
      
      .stats-icon i {
        font-size: 28px;
        color: #3b5af5;
      }
      
      .stats-number {
        font-size: 2.2rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.5rem;
      }
      
      .stats-title {
        font-size: 1rem;
        color: #777;
        margin-bottom: 0;
      }
    </style>
    

    
    <div class="row g-4 align-items-center">
      <div class="col-lg-6 mb-4">
        <div class="chart-card h-100">
          <div class="card-body p-4">
            <h4 class="chart-title text-center mb-4">Distribusi Jenjang Pendidikan</h4>
            <div class="chart-container" style="height: 300px;">
              <canvas id="schoolDistributionChart"></canvas>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-lg-6">
        <div class="chart-card h-100">
          <div class="card-body p-4">
            <h4 class="chart-title text-center mb-4">Status Sekolah di Kabupaten Sinjai</h4>
            <div class="chart-container" style="height: 300px;">
              <canvas id="schoolStatusChart"></canvas>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-12 mt-4">
        <div class="chart-card">
          <div class="card-body p-4">
            <h4 class="chart-title text-center mb-4">Distribusi Sekolah per Kecamatan</h4>
            <div class="chart-container" style="height: 350px;">
              <canvas id="districtDistributionChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- School Data Chart End -->

<!-- Tambahkan Font Awesome untuk ikon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Tambahkan anime.js untuk animasi -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
<!-- Add Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Ganti dengan data yang diambil dari PHP
    <?php
    // Outputkan variabel PHP ke JavaScript
    ?>
    
    // Data total per jenjang
    const totalTK = <?php echo $total_tk; ?>;
    const totalSD = <?php echo $total_sd; ?>;
    const totalSMP = <?php echo $total_smp; ?>;
    
    // Data status per jenjang
    const tkNegeri = <?php echo $total_tk_negeri; ?>;
    const tkSwasta = <?php echo $total_tk_swasta; ?>;
    const sdNegeri = <?php echo $total_sd_negeri; ?>;
    const sdSwasta = <?php echo $total_sd_swasta; ?>;
    const smpNegeri = <?php echo $total_smp_negeri; ?>;
    const smpSwasta = <?php echo $total_smp_swasta; ?>;
    
    // Data per kecamatan
    const kecamatan = ['Pulau Sembilan', 'Sinjai Barat', 'Sinjai Borong', 'Sinjai Selatan', 
                      'Sinjai Tengah', 'Sinjai Timur', 'Sinjai Utara', 'Tellu Limpoe', 'Bulupoddo'];
    
    const dataTK = [
      <?php echo $total_tk_pulau_sembilan; ?>,
      <?php echo $total_tk_sinjai_barat; ?>,
      <?php echo $total_tk_sinjai_borong; ?>,
      <?php echo $total_tk_sinjai_selatan; ?>,
      <?php echo $total_tk_sinjai_tengah; ?>,
      <?php echo $total_tk_sinjai_timur; ?>,
      <?php echo $total_tk_sinjai_utara; ?>,
      <?php echo $total_tk_tellu_limpoe; ?>,
      <?php echo $total_tk_bulupoddo; ?>
    ];
    
    const dataSD = [
      <?php echo $total_sd_pulau_sembilan; ?>,
      <?php echo $total_sd_sinjai_barat; ?>,
      <?php echo $total_sd_sinjai_borong; ?>,
      <?php echo $total_sd_sinjai_selatan; ?>,
      <?php echo $total_sd_sinjai_tengah; ?>,
      <?php echo $total_sd_sinjai_timur; ?>,
      <?php echo $total_sd_sinjai_utara; ?>,
      <?php echo $total_sd_tellu_limpoe; ?>,
      <?php echo $total_sd_bulupoddo; ?>
    ];
    
    const dataSMP = [
      <?php echo $total_smp_pulau_sembilan; ?>,
      <?php echo $total_smp_sinjai_barat; ?>,
      <?php echo $total_smp_sinjai_borong; ?>,
      <?php echo $total_smp_sinjai_selatan; ?>,
      <?php echo $total_smp_sinjai_tengah; ?>,
      <?php echo $total_smp_sinjai_timur; ?>,
      <?php echo $total_smp_sinjai_utara; ?>,
      <?php echo $total_smp_tellu_limpoe; ?>,
      <?php echo $total_smp_bulupoddo; ?>
    ];
    
    // Tidak perlu update elemen HTML karena card telah dihapus
    
    // Counter animation for stats
    function animateCounter(el, target) {
      const counter = { val: 0 };
      const duration = 2000;
      anime({
        targets: counter,
        val: target,
        round: 1,
        duration: duration,
        easing: 'easeOutExpo',
        update: function() {
          el.innerHTML = counter.val;
        }
      });
    }
    
    // Tidak perlu lagi menganimasikan counter karena card sudah dihapus
    
    // Distribution Chart with enhanced aesthetics
    const distributionCtx = document.getElementById('schoolDistributionChart').getContext('2d');
    const distributionChart = new Chart(distributionCtx, {
      type: 'doughnut',
      data: {
        labels: ['TK', 'SD', 'SMP'],
        datasets: [{
          data: [totalTK, totalSD, totalSMP],
          backgroundColor: [
            'rgba(59, 90, 245, 0.8)',
            'rgba(255, 112, 67, 0.8)',
            'rgba(67, 168, 255, 0.8)'
          ],
          borderColor: [
            'rgba(59, 90, 245, 1)',
            'rgba(255, 112, 67, 1)',
            'rgba(67, 168, 255, 1)'
          ],
          borderWidth: 2,
          hoverOffset: 10
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '65%',
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              font: {
                family: 'Arial',
                size: 12,
                weight: 'bold'
              },
              padding: 20,
              usePointStyle: true,
              pointStyle: 'circle'
            }
          },
          tooltip: {
            backgroundColor: 'rgba(255, 255, 255, 0.9)',
            titleColor: '#333',
            bodyColor: '#555',
            titleFont: {
              size: 14,
              weight: 'bold'
            },
            bodyFont: {
              size: 13
            },
            borderColor: 'rgba(200, 200, 200, 0.5)',
            borderWidth: 1,
            padding: 12,
            displayColors: true,
            callbacks: {
              label: function(context) {
                const label = context.label || '';
                const value = context.raw || 0;
                const total = context.dataset.data.reduce((acc, data) => acc + data, 0);
                const percentage = Math.round((value / total) * 100);
                return `${label}: ${value} (${percentage}%)`;
              }
            }
          }
        },
        animation: {
          animateScale: true,
          animateRotate: true,
          duration: 2000,
          easing: 'easeOutQuart'
        }
      }
    });
    
    // Status Chart (Negeri vs Swasta)
    const statusCtx = document.getElementById('schoolStatusChart').getContext('2d');
    const statusChart = new Chart(statusCtx, {
      type: 'bar',
      data: {
        labels: ['TK', 'SD', 'SMP'],
        datasets: [
          {
            label: 'Negeri',
            data: [tkNegeri, sdNegeri, smpNegeri],
            backgroundColor: 'rgba(75, 192, 192, 0.7)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 2
          },
          {
            label: 'Swasta',
            data: [tkSwasta, sdSwasta, smpSwasta],
            backgroundColor: 'rgba(153, 102, 255, 0.7)',
            borderColor: 'rgba(153, 102, 255, 1)',
            borderWidth: 2
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
            labels: {
              font: {
                family: 'Arial',
                size: 12
              },
              usePointStyle: true,
              padding: 20
            }
          },
          tooltip: {
            backgroundColor: 'rgba(255, 255, 255, 0.9)',
            titleColor: '#333',
            bodyColor: '#555',
            titleFont: {
              size: 14,
              weight: 'bold'
            },
            bodyFont: {
              size: 13
            },
            borderColor: 'rgba(200, 200, 200, 0.5)',
            borderWidth: 1,
            padding: 12,
            displayColors: true
          }
        },
        scales: {
          x: {
            grid: {
              display: false
            }
          },
          y: {
            beginAtZero: true,
            grid: {
              color: 'rgba(200, 200, 200, 0.2)'
            },
            ticks: {
              precision: 0
            }
          }
        },
        animation: {
          delay: function(context) {
            return context.dataIndex * 300;
          },
          duration: 1000,
          easing: 'easeOutQuart'
        },
        barPercentage: 0.7,
        categoryPercentage: 0.7
      }
    });
    
    // Distribusi per Kecamatan
    const districtCtx = document.getElementById('districtDistributionChart').getContext('2d');
    const districtChart = new Chart(districtCtx, {
      type: 'bar',
      data: {
        labels: kecamatan,
        datasets: [
          {
            label: 'TK',
            data: dataTK,
            backgroundColor: 'rgba(59, 90, 245, 0.7)',
            borderColor: 'rgba(59, 90, 245, 1)',
            borderWidth: 1
          },
          {
            label: 'SD',
            data: dataSD,
            backgroundColor: 'rgba(255, 112, 67, 0.7)',
            borderColor: 'rgba(255, 112, 67, 1)',
            borderWidth: 1
          },
          {
            label: 'SMP',
            data: dataSMP,
            backgroundColor: 'rgba(67, 168, 255, 0.7)',
            borderColor: 'rgba(67, 168, 255, 1)',
            borderWidth: 1
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
            labels: {
              font: {
                family: 'Arial',
                size: 12
              },
              usePointStyle: true,
              padding: 20
            }
          },
          tooltip: {
            backgroundColor: 'rgba(255, 255, 255, 0.9)',
            titleColor: '#333',
            bodyColor: '#555',
            borderColor: 'rgba(200, 200, 200, 0.5)',
            borderWidth: 1,
            padding: 12,
            displayColors: true
          }
        },
        scales: {
          x: {
            grid: {
              display: false
            },
            ticks: {
              maxRotation: 45,
              minRotation: 45
            }
          },
          y: {
            beginAtZero: true,
            grid: {
              color: 'rgba(200, 200, 200, 0.2)'
            },
            ticks: {
              precision: 0
            }
          }
        },
        animation: {
          delay: function(context) {
            return context.dataIndex * 100;
          },
          duration: 1000,
          easing: 'easeOutQuart'
        },
        barPercentage: 0.8,
        categoryPercentage: 0.8
      }
    });
  });
</script>

	<!-- Copyright Start -->
	<div class="container-fluid copyright bg-white py-4 text-dark" style="background-color: #fff; color: #000;">
		<div class="container">
			<div class="row">
				<div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
					<p class="text-dark"><a href="https://github.com/w1nnn/spmb-kab-sinjai" target="_blank"><i class="fas fa-copyright text-dark me-2"></i>SPMB</a>, All right reserved.</p>
				</div>
				<div class="col-md-6 my-auto text-center text-md-end text-dark" style="text-align: center;">
					Copyright &copy <?php echo date('Y') ?> Dinas Pendidikan Kabupaten Sinjai <br>
				</div>
			</div>
		</div>
	</div>
	<!-- Copyright End -->



	<!-- Back to Top -->
	<!-- <a href="<?= base_url() ?>login" class="btn btn-sm btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-sign-in-alt"></i></a> -->


	<!-- JavaScript Libraries -->
	</script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src="<?= base_url() ?>assets/landing/lib/easing/easing.min.js"></script>
	<script src="<?= base_url() ?>assets/landing/lib/waypoints/waypoints.min.js"></script>
	<script src="<?= base_url() ?>assets/landing/lib/lightbox/js/lightbox.min.js"></script>
	<script src="<?= base_url() ?>assets/landing/lib/owlcarousel/owl.carousel.min.js"></script>
	<!-- Template Javascript -->
	<script src="<?= base_url() ?>assets/landing/js/main.js"></script>
</body>

</html>