<?php
$check = $this->session->flashdata('status');
if (!empty($check)) {
	$hp = $this->session->flashdata('email');
	$ps =  $this->session->flashdata('password');
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
	<title>Login </title>
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
	<style>
		/* Media query untuk menyembunyikan gambar pada layar mobile */
		@media (max-width: 768px) {
			#bg {
				background-image: none !important;
				/* Menghilangkan gambar latar belakang */
			}
		}
	</style>
</head>

<body>

	<!-- Sign in Start -->
	<section class="sign-in-page bg-white">
		<div class="container-fluid p-0">
			<div class="row no-gutters" style="background-color: #e5e5e5;">
				<div class="col-sm-6 align-self-center">
					<div class="sign-in-from">
						<a class="sign-in-logo mb-3" href="<?= base_url() ?>"><img src="<?= base_url() ?>assets/images/logo-brr.png" class="img-fluid" alt="logo"></a>

						<h2 class="mb-0 mt-3">Masuk </h2>
						<p>Silahkan masukkan nomor induk kependudukan (NIK) dan password Anda.</p>
						<form class="mt-4" action="<?= base_url() ?>siswa/auth" method="POST" onsubmit="return validateForm()">
							<div class="form-group">
								<label for="exampleInputEmail1">Nomor Induk Kependudukan (NIK) </label>
								<input type="number" maxlength="16" oninput="this.value=this.value.slice(0,this.maxLength)" class="form-control mb-0" id="exampleInputEmail1" name="no_ktp" placeholder="Contoh: 7307022405040001" autocomplete="off" value="<?= $hp  ?>" required>
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Password</label>
								<div class="input-group">
									<input type="password" class="form-control mb-0" id="exampleInputPassword1" name="password" placeholder="Password" required>
									<div class="input-group-append">
										<span class="input-group-text" id="togglePassword" onclick="togglePassword()">
											<img id="togglePasswordIcon" src="https://img.icons8.com/ios-filled/50/000000/invisible.png" width="20" height="20">
										</span>
									</div>
								</div>
							</div>
							<div class="d-inline-block w-100">
								<button type="submit" class="btn btn-primary float-right">Masuk </button>
							</div>
							<div class="sign-info">
								<a href="#" class="float-right" data-toggle="modal" data-target="#modalForgot">Lupa Password ?</a>
								<span class="dark-color d-inline-block line-height-2">Belum punya akun ? <a href="<?= base_url() ?>siswa/register">Daftar Disini </a></span>
							</div>
						</form>
					</div>
				</div>

				<div class="col-sm-6 text-center">
					<div id="bg" class="sign-in-detail text-white" style="background: url(<?= base_url() ?>assets/landing/logban.jpg) no-repeat 0 0; background-size: cover; height:100vh;">
						<div class="owl-carousel" style="margin-top:100px;" data-autoplay="true" data-loop="true" data-nav="false" data-dots="true" data-items="1" data-items-laptop="1" data-items-tab="1" data-items-mobile="1" data-items-mobile-sm="1" data-margin="0">
						</div>
					</div>
				</div>


			</div>
		</div>
	</section>
	<div class="modal fade" id="modalForgot" tabindex="-1" role="dialog" aria-labelledby="modalForgot" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalForgotTitle">Reset Password Login</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="form-reset">
					<div class="modal-body">
						<div class="form-group">
							<label for="nik">Nomor Induk Kependudukan (NIK)</label>
							<input type="number" name="nik" class="form-control" id="nik" placeholder="Masukkan Nomor Induk Kependudukan (NIK)" required>
						</div>
						<div class="form-group">
							<label for="tgl_lahir">Tanggal Lahir</label>
							<input type="date" name="tgl_lahir" class="form-control" id="tgl_lahir" placeholder="Masukkan Tanggal Lahir">
						</div>
						<div class="form-group">
							<label for="new_password">Password Baru</label>
							<input type="password" name="new_password" class="form-control" id="new_password" placeholder="Masukkan Password Baru" required>
						</div>
						<div class="form-group">
							<label for="new_password1">Ulang Password Baru</label>
							<input type="password" name="new_password1" class="form-control" id="new_password1" placeholder="Masukkan Ulang Password Baru" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
						<button type="submit" class="btn btn-primary">Reset Password</button>
					</div>
				</form>
			</div>
		</div>
	</div>
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

	<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css"> -->
	<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script>
		function validateForm() {
			// Get the value of the "no_kk" field
			var noKk = document.querySelector('input[name="no_ktp"]').value;

			// Check if the length of the No. KK is not 16 digits
			if (noKk.length !== 16) {
				// Display SweetAlert message
				Swal.fire({
					icon: 'error',
					title: 'Invalid Nomor Induk Kependudukan',
					text: 'Nomor Induk Kependudukan harus terdiri dari 16 digit.',
					confirmButtonText: 'Ok'
				});
				return false; // Prevent form submission
			}
			return true; // Allow form submission if validation passes
		}

		function togglePassword() {
			var passwordField = document.getElementById("exampleInputPassword1");
			var toggleIcon = document.getElementById("togglePasswordIcon");

			if (passwordField.type === "password") {
				passwordField.type = "text"; // Menampilkan password
				toggleIcon.src = "https://img.icons8.com/ios-filled/50/000000/visible.png"; // Ikon mata terbuka
			} else {
				passwordField.type = "password"; // Menyembunyikan password
				toggleIcon.src = "https://img.icons8.com/ios-filled/50/000000/invisible.png"; // Ikon mata tertutup
			}
		}
	</script>
	<script>
		$("#form-reset").unbind().submit(function(e) {
			e.preventDefault();
			var _f = $(this);
			var data = _f.serialize();
			_f.find("input").prop('disabled', true);
			_f.find("button[type=submit]").prop('disabled', true);
			$.ajax({
				url: '/siswa/reset',
				dataType: 'json',
				type: 'post',
				data: data,
				success: function(res) {
					_f.find("input").prop('disabled', false);
					_f.find("button[type=submit]").prop('disabled', false);
					if (res.status == 'success') {
						_f.find("input").val("");
						$("#modalForgot").modal('hide');
						toastr.success(res.message);
						setTimeout(() => {
							$("#exampleInputEmail1").focus();
						}, 250);
					} else {
						toastr.error(res.message);
					}
				},
				error: function(err) {
					_f.find("input").prop('disabled', false);
					_f.find("button[type=submit]").prop('disabled', false);
				}
			});
		});
		$(document).ready(function() {
			toastr.options = {
				'closeButton': true,
				'debug': false,
				'newestOnTop': false,
				'progressBar': true,
				'positionClass': 'toast-top-center mt-3',
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
	</script>
	<?php if (!empty($check)) { ?>
		<script>
			$(document).ready(function() {
				toastr.error('NIK atau Password Salah, Coba Lagi ! ');
			});
		</script>
	<?php }  ?>
</body>

</html>