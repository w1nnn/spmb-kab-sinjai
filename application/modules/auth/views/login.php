<!DOCTYPE html>
<html lang="id-ID">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login Administrator</title>

	<link rel="shortcut icon" href="<?= base_url() ?>assets/images/page-img/29.png" />
	<meta name="description" content="Selamat Datang Di Sistem Penerimaan Peserta Didik Baru Kabupaten Sinjai  ">
	<meta name="keyword" content="Penerimaan Peserta Didik Baru | Dinas Pendidikan Kabupaten Sinjai ">
	<meta name="author" content="Dinas Pendidikan Kabupaten Sinjai ">

	<meta property='fb:app_id' content='1617259004961144' />
	<meta property='og:type' content='article' />
	<meta property='og:url' content='<?= base_url() ?>' />
	<meta property='og:title' content='Pendaftaran | Penerimaan Peserta Didik Baru Kabupaten Sinjai ' />
	<meta property='og:image' content='<?= base_url() ?>assets/landing/slide1.jpg' />
	<meta property='og:description' content='Selamat Datang Di Sistem Penerimaan Peserta Didik Baru Kabupaten Sinjai '>


	<!-- browser color -->
	<meta name="theme-color" content="#037afb">
	<meta name="msapplication-navbutton-color" content="#037afb">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="#037afb">

	<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/landing/main.css" media="all">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/landing/robi.css" media="all">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
	<style>
		body {
			background-color: #FBAB7E;
			background-image: linear-gradient(62deg, #FBAB7E 0%, #68d9f7 100%);

		}
	</style>
</head>

<body>
	<!-- Gambar Slider -->
	<div class="carousel slide carousel-zoom" data-ride="carousel" data-interval="3500">
		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
			<div class="item active" style="background-image:url(<?= base_url() ?>assets/landing/bg-login.png);"></div>
		</div>
	</div>
	<!-- /Gambar Slider -->

	<section id="main-wrapper">

		<header id="header-portal" style="padding-top:20px;">
			<div class="container">
				<div class="row">

					<div class="col-md-4 col-md-offset-4" style="margin-top:100px;">
						<main style="background-color: #ffffffcf; border-radius:10px; padding:40px;">
							<a href="<?= base_url() ?>"><img src="<?= base_url() ?>assets/images/logo-brr.png" alt="" width="100%" style="margin-bottom:10px;"></a>
							<h3>Administrator</h3>

							<form action="<?= base_url() ?>auth/login/validate" method="POST">
								<div class="form-group">
									<label for=""> Username </label>
									<input type="text" class="form-control" value="<?= $username ?>" name="username" autocomplete="off">
								</div>
								<div class="form-group">
									<label for=""> Password </label>
									<input type="password" class="form-control" value="<?= $password ?>" name="password" autocomplete="off">
								</div>
								<button class="btn" style="background-color: #0d6efd; color: #fff;"> Masuk</button>
								<hr>
								<!-- <a href="#" style="color:#fff; text-shadow:1px 1px 3px rgba(0, 0, 0, 0.9);"> Lupa Password ? </a> -->
							</form>

						</main>
					</div>
				</div>
			</div>
		</header>


	</section>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>

	<?php if ($this->input->get('alert') && $this->input->get('message')): ?>
		<script>
			document.addEventListener("DOMContentLoaded", function() {
				const Toast = Swal.mixin({
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 3000,
					timerProgressBar: true
				});

				Toast.fire({
					icon: <?= json_encode($this->input->get('alert')) ?>,
					title: <?= json_encode(urldecode($this->input->get('message'))) ?>
				});

				if (history.pushState) {
					const url = new URL(window.location);
					url.searchParams.delete('alert');
					url.searchParams.delete('message');
					window.history.replaceState({}, document.title, url.toString());
				}
			});
		</script>
	<?php endif; ?>


	<script src="<?= base_url() ?>assets/landing/jquery.min.js"></script>
	<script src="<?= base_url() ?>assets/landing/bootstrap.min.js"></script>

</body>

</html>