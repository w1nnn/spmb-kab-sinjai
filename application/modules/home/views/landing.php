<!DOCTYPE html>
<html lang="id-ID">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SPMB - Kabupaten Sinjai </title>

	<link rel="shortcut icon" href="<?= base_url() ?>assets/images/page-img/29.png" />
	<meta name="description" content="Selamat Datang Di Sistem Penerimaan Peserta Didik Baru Kabupaten Sinjai  ">
	<meta property='fb:app_id' content='1617259004961144' />
	<meta property='og:type' content='article' />
	<meta property='og:url' content='<?= base_url() ?>' />
	<meta property='og:title' content='Pendaftaran | Penerimaan Peserta Didik Baru Kabupaten Sinjai ' />
	<meta property='og:image' content='<?= base_url() ?>assets/landing/slide1.png' />
	<meta property='og:description' content='Selamat Datang Di Sistem Penerimaan Peserta Didik Baru Kabupaten Sinjai '>


	<meta name="theme-color" content="#037afb">
	<meta name="msapplication-navbutton-color" content="#037afb">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="#037afb">


	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/landing/main.css" media="all">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/landing/robi.css" media="all">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
	<style>
		/* Extra small devices (phones, 600px and down) */
		@media only screen and (max-width: 600px) {
			.desktop {
				display: none;
			}

			.mobile {
				display: block;
			}

			.marg {
				margin-top: 220px;
			}
		}

		/* Small devices (portrait tablets and large phones, 600px and up) */
		@media only screen and (min-width: 600px) {
			.desktop {
				display: none;
			}

			.mobile {
				display: block;
			}

			.marg {
				margin-top: 220px;
			}

		}

		/* Large devices (laptops/desktops, 992px and up) */
		@media only screen and (min-width: 992px) {
			.desktop {
				display: block;
			}

			.mobile {
				display: none;
			}

			.marg {
				margin-top: 350px;
			}

		}

		/* Extra large devices (large laptops and desktops, 1200px and up) */
		@media only screen and (min-width: 1200px) {
			.desktop {
				display: block;
			}

			.mobile {
				display: none;
			}

			.marg {
				/* margin-top:60px; */
				margin-top: 350px;
			}

		}
	</style>
</head>

<body>

	<!-- Gambar Slider -->
	<div class="desktop">
		<div class="carousel slide carousel-zoom" data-ride="carousel" data-interval="3500">
			<div class="carousel-inner" role="listbox">
				<div class="item active" style="background-image:url(<?= base_url() ?>assets/landing/s1.jpg);"></div>
				<div class="item" style="background-image:url(<?= base_url() ?>assets/landing/s2.jpg);"></div>
			</div>
		</div>
	</div>
	<!-- /Gambar Slider -->
	<div class="mobile">

		<div id="myCarousel" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				<li data-target="#myCarousel" data-slide-to="1"></li>
				<li data-target="#myCarousel" data-slide-to="2"></li>
			</ol>

			<!-- Wrapper for slides -->
			<div class="carousel-inner">
				<div class="item active">
					<img src="<?= base_url() ?>assets/landing/s1.jpg" alt="" style="border-radius:0% 0% 10% 10%;  box-shadow:2px 2px 12px #4bb4e6;">
				</div>

				<div class="item">
					<img src="<?= base_url() ?>assets/landing/s2.jpg" alt="" style="border-radius:0% 0% 10% 10%; box-shadow:2px 2px 12px #4bb4e6; ">
				</div>
			</div>

		</div>

	</div>
	<section id="main-wrapper" style="position: relative">
		<a href="https://disdik.macca.id/aduan-ppdb" class="btn btn-primary px-1 py-3" style="position: fixed;z-index: 1000;bottom: 10px; right: 13px;" target="_blank"><i class="fa fa-fw fa-question-circle"></i> Laporkan Masalah</a>

		<header id="header-portal" style="padding-top:20px;">
			<div class="container">

				<div class="row">

					<div class="col-md-8 col-md-offset-2 marg">
						<main id="main-portal">

							<div class="mobile" style="margin-bottom:10px; margin-top:-5px;">
								<center>
									<img src="<?= base_url() ?>assets/images/ppdb-logo-text-white.png" width="50%" alt="">
								</center>
							</div>
							<div class="row d-flex justify-content-center">
								<div class="col-sm-4 col-xs-4" style="margin-bottom:15px;">
									<a href="<?= base_url() ?>home/dashboard" style="text-decoration:none;">
										<div class="box">
											<img src="<?= base_url() ?>assets/landing/icon/home.svg" alt="" width="60px">
											<h5> Beranda </h5>
										</div>
									</a>
								</div>
								<div class="col-sm-4 col-xs-4" style="margin-bottom:15px;">
									<a href="<?= base_url() ?>sekolah" style="text-decoration:none;">
										<div class="box">
											<img src="<?= base_url() ?>assets/landing/icon/school.svg" alt="" width="60px">
											<h5> Sekolah </h5>
										</div>
									</a>
								</div>
								<div class="col-sm-4 col-xs-4" style="margin-bottom:15px;">
									<a href="<?= base_url() ?>profil/panduan" style="text-decoration:none;">
										<div class="box">
											<img src="<?= base_url() ?>assets/landing/icon/notebook.svg" alt="" width="60px">
											<h5> Panduan & Aplikasi </h5>
										</div>
									</a>
								</div>
								<div class="col-sm-4 col-xs-4" style="margin-bottom:15px;">
									<a href="<?= base_url() ?>siswa/register" style="text-decoration:none;">
										<div class="box">
											<img src="<?= base_url() ?>assets/landing/icon/daftar.svg" alt="" width="60px">
											<h5> Daftar </h5>
										</div>
									</a>
								</div>
								<div class="col-sm-4 col-xs-4" style="margin-bottom:15px;">
									<a href="<?= base_url() ?>siswa/login" style="text-decoration:none;">
										<div class="box">
											<img src="<?= base_url() ?>assets/landing/icon/profil.svg" alt="" width="60px">
											<h5> Masuk Siswa </h5>
										</div>
									</a>
								</div>
								<div class="col-sm-4 col-xs-4" style="margin-bottom:15px;">
									<a href="<?= base_url() ?>login" style="text-decoration:none;">
										<div class="box">
											<img src="<?= base_url() ?>assets/landing/icon/admin.png" alt="" width="60px">
											<h5> Masuk Admin </h5>
										</div>
									</a>
								</div>
								<div class="col-sm-4 col-xs-4" style="margin-bottom:15px;">
									<a href="<?= base_url() ?>siswa/pengumuman" style="text-decoration:none;">
										<div class="box">
											<img src="<?= base_url() ?>assets/landing/icon/pengumuman.svg" alt="" width="60px">
											<h5> Pengumuman </h5>
										</div>
									</a>
								</div>
							</div>

							<div class="row desktop">
								<div class="col-md-12">
									<p class="copyright text-center ">
										Copyright &copy <?php echo date('Y') ?> Dinas Pendidikan Kabupaten Sinjai <br>
										Sistem Aplikasi PPDB Versi 1.2 <br>
										<!-- <a href="http://linyjayainformatika.co.id/" target="_blank">
									<img src="<?= base_url() ?>assets/images/logo-liny.png" width="120px;" alt="">
									</a> -->
									</p>

								</div>
							</div>


						</main>
					</div>
				</div>
			</div>
		</header>
	</section>
	<script src="https://dprd.semarangkota.go.id/assets/portal/js/jquery.min.js"></script>
	<script src="https://dprd.semarangkota.go.id/assets/portal/js/bootstrap.min.js"></script>

</body>

</html>