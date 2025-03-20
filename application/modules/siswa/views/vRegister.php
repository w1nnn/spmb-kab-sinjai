<?php
$check = $this->session->flashdata('status');
if (!empty($check)) {
	$hp = $this->session->flashdata('email');
	$ps = $this->session->flashdata('password');
} else {
	$hp = "";
	$ps = "";
}
?>
<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Buat Akun - PPDB </title>
	<!-- Favicon -->
	<link rel="shortcut icon" href="<?= base_url() ?>assets/images/page-img/29.png" />
	<meta name="description" content="Selamat Datang Di Sistem Penerimaan Peserta Didik Baru Kabupaten Sinjai  ">
	<meta property='fb:app_id' content='1617259004961144' />
	<meta property='og:type' content='article' />
	<meta property='og:url' content='<?= base_url() ?>' />
	<meta property='og:title' content='Pendaftaran | Penerimaan Peserta Didik Baru Kabupaten Sinjai ' />
	<meta property='og:image' content='<?= base_url() ?>assets/images/page-img/29.png' />
	<meta property='og:description' content='Selamat Datang Di Sistem Penerimaan Peserta Didik Baru Kabupaten Sinjai '>
	<!-- Bootstrap CSS -->

	<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css">
	<!-- Typography CSS -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/typography.css">
	<!-- Style CSS -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
	<!-- Responsive CSS -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/responsive.css">

</head>

<body>

	<!-- Sign in Start -->
	<section class="sign-in-page bg-white">
		<div class="container-fluid p-0">
			<div class="row no-gutters">
				<div class="col-sm-6 align-self-center">
					<div class="sign-in-from">
						<a class="sign-in-logo mb-3" href="<?= base_url() ?>"><img src="<?= base_url() ?>assets/images/ppdb-logo-text.png" class="img-fluid" alt="logo"></a>

						<?php if (registerAccess() || (date('Y-m-d') >= configs()->daftar->start && date('Y-m-d') <= configs()->daftar->end)) : ?>
							<h2 class="mb-0">Buat Akun </h2>
							<p>Silahkan lengkapi form dibawah.</p>
							<form class="mt-4" action="<?= base_url() ?>siswa/createAccount" method="POST">
								<div class="form-group">
									<label for="exampleInputEmail1">Nama Calon Siswa </label>
									<input type="text" class="form-control mb-0" id="exampleInputEmail1" name="nama" placeholder="Andi Tenri" autocomplete="off" required>
								</div>
								<div class="form-group">
									<label for="exampleInputEmail1">Nomor Induk Kependudukan (NIK) </label>
									<input type="number" maxlength="16" oninput="this.value=this.value.slice(0,this.maxLength)" class="form-control mb-0" id="exampleInputEmail1" name="no_ktp" placeholder="Contoh: 7307022405040001" autocomplete="off" required>
								</div>

								<div class="form-group">
									<label for="exampleInputPassword1">Password</label>
									<input type="password" class="form-control mb-0" id="exampleInputPassword1" name="password" placeholder="Password" required>
								</div>
								<p class="text-danger">Harap password anda dicatat agar tidak dilupa. </p>
								<div class="d-inline-block w-100">
									<button type="submit" id="submit" class="btn btn-primary float-right"> Buat Akun </button>
								</div>
								<div class="sign-info">

									<span class="dark-color d-inline-block line-height-2">Sudah punya akun ? <a href="<?= base_url() ?>siswa/login">Masuk Disini </a></span>
								</div>
							</form>
						<?php elseif (date('Y-m-d') > configs()->daftar->end) : ?>
							<h4 class="text-danger">Maaf, Pendaftaran Peserta Didik Baru telah Berakhir!</h4>
							<div class="sign-info">

								<span class="dark-color d-inline-block line-height-2">Sudah punya akun ? <a href="<?= base_url() ?>siswa/login">Masuk Disini </a></span>
							</div>
						<?php elseif (date('Y-m-d') < configs()->daftar->start) : ?>
							<h4 class="text-primary">Pendaftaran Peserta Didik Baru akan Dibuka<br>pada Tanggal <?php echo (\Carbon\Carbon::parse(configs()->daftar->start)->locale('id')->translatedFormat('j F Y')) . ' s.d. ' . (\Carbon\Carbon::parse(configs()->daftar->end)->locale('id')->translatedFormat('j F Y')) ?></h4>
						<?php endif; ?>
					</div>
				</div>

				<div class="col-sm-6 text-center">
					<div class="sign-in-detail text-white" style="background: url(<?= base_url() ?>assets/images/login/2.jpg) no-repeat 0 0; background-size: cover; height:100vh;">
						<div class="owl-carousel" style="margin-top:100px;" data-autoplay="true" data-loop="true" data-nav="false" data-dots="true" data-items="1" data-items-laptop="1" data-items-tab="1" data-items-mobile="1" data-items-mobile-sm="1" data-margin="0">
						</div>
					</div>
				</div>


			</div>
		</div>
	</section>
	<!-- Sign in END -->
	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<!-- Appear JavaScript -->
	<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
	<script src="<?= base_url() ?>assets/js/popper.min.js"></script>
	<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>


	<script src="<?= base_url() ?>assets/js/jquery.appear.js"></script>
	<!-- Countdown JavaScript -->
	<script src="<?= base_url() ?>assets/js/countdown.min.js"></script>
	<!-- Counterup JavaScript -->
	<script src="<?= base_url() ?>assets/js/waypoints.min.js"></script>
	<script src="<?= base_url() ?>assets/js/jquery.counterup.min.js"></script>
	<!-- Wow JavaScript -->
	<script src="<?= base_url() ?>assets/js/wow.min.js"></script>
	<!-- Slick JavaScript -->
	<script src="<?= base_url() ?>assets/js/slick.min.js"></script>
	<!-- Select2 JavaScript -->
	<script src="<?= base_url() ?>assets/js/select2.min.js"></script>
	<!-- Owl Carousel JavaScript -->
	<script src="<?= base_url() ?>assets/js/owl.carousel.min.js"></script>
	<!-- Magnific Popup JavaScript -->
	<script src="<?= base_url() ?>assets/js/jquery.magnific-popup.min.js"></script>
	<!-- Smooth Scrollbar JavaScript -->
	<script src="<?= base_url() ?>assets/js/smooth-scrollbar.js"></script>
	<!-- Custom JavaScript -->
	<script src="<?= base_url() ?>assets/js/custom.js"></script>
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/toastr.min.css">
	<script src="<?= base_url() ?>assets/js/toastr.min.js"></script>


	<script>
		$(document).ready(function() {
			toastr.options = {
				'closeButton': false,
				'debug': false,
				'newestOnTop': false,
				'progressBar': false,
				'positionClass': 'toast-top-left',
				'preventDuplicates': false,
				'showDuration': '10000',
				'hideDuration': '10000',
				'timeOut': '10000',
				'extendedTimeOut': '10000',
				'showEasing': 'swing',
				'hideEasing': 'linear',
				'showMethod': 'fadeIn',
				'hideMethod': 'fadeOut',
			}
		});


		$(document).ready(function() {
			$('#submit').click(function() {
				// alert('clicked');

				$(this).val("Changed");
			});
		});​
	</script>
	<?php if (!empty($check)) { ?>
		<script>
			$(document).ready(function() {
				toastr.error('<?= $this->session->flashdata('message'); ?>');
			});
		</script>
	<?php }  ?>
</body>

</html>