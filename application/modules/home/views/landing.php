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
			top: 15%;
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
				top: 30%;
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
					</div>
					<div class="d-flex m-3 me-0">
						<!-- <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search text-primary"></i></button> -->
						<!-- <a href="#" class="position-relative me-4 my-auto">
							<i class="fa fa-shopping-bag fa-2x"></i>
							<span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;">3</span>
						</a> -->
						<!-- <a href="<?= base_url() ?>login" class="my-auto">
							<i class="fas fa-user fa-1x"></i>
						</a> -->
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
					<!-- <div class="position-relative mx-auto">
						<input class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill" type="number" placeholder="Search">
						<button type="submit" class="btn btn-primary border-2 border-secondary py-3 px-4 position-absolute rounded-pill text-white h-100" style="top: 0; right: 25%;">Submit Now</button>
					</div> -->
				</div>
				<div class="col-md-12 col-lg-9" style="margin-top: -52px;">
					<div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
						<div class="carousel-inner" role="listbox">
							<div class="carousel-item active rounded">
								<img src="<?= base_url() ?>assets/landing/s1.jpg" class="img-fluid w-100 h-100 bg-secondary rounded" alt="First slide">
								<a href="<?= base_url() ?>siswa/register" class="daftar btn text-white rounded" style="background-color:rgb(255, 0, 0); font-size: 14px; box-shadow: rgba(0, 0, 0, 0.2) 0px 60px 40px -7px;
">Daftar</a>
							</div>
							<div class="carousel-item rounded">
								<img src="<?= base_url() ?>assets/landing/s22.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
								<a href="<?= base_url() ?>siswa/register" class="daftar btn text-dark rounded" style="background-color:rgb(200, 255, 0); font-size: 14px; box-shadow: rgba(0, 0, 0, 0.2) 0px 60px 40px -7px;
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