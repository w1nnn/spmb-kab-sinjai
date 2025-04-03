<div class="iq-top-navbar" style="background-color: #2e859a; background-image: linear-gradient(62deg, #2e859a 0%, #F7CE68 100%)">
	<div class="iq-navbar-custom">
		<div class="navbar-breadcrumb">
			<h5 class="mb-0 text-white"> Penerimaan Murid Baru </h5>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item text-white" aria-current="page"> <?= $subtitle ?> </li>
					<!-- <?php
							var_dump($subtitle);
							?> -->
				</ol>
			</nav>
		</div>
		<nav class="navbar navbar-expand-lg navbar-light p-0">
			<div class="iq-menu-bt align-self-center">
				<div class="wrapper-menu">
					<div class="line-menu half start"></div>
					<div class="line-menu"></div>
					<div class="line-menu half end"></div>
				</div>
			</div>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ml-auto navbar-list">
				</ul>
			</div>
			<ul class="navbar-list">
				<li>
					<!-- <a href="https://disdik.macca.id/aduan-ppdb" target="_blank"><i class="fa fa-fw fa-question-circle"></i> Laporkan Masalah</a> -->
				</li>
				<?php if ($this->session->userdata('isLogin') == 1) { ?>
					<li>
						<a href="#" class="search-toggle iq-waves-effect text-white" style="#F7CE68">
							<i class="fa fa-fw fa-user-circle"></i>
							<span class="utext"><?= $this->session->userdata('nama'); ?></span>
						</a>
						<div class="iq-sub-dropdown iq-user-dropdown">
							<div class="iq-card shadow-none m-0">
								<div class="iq-card-body p-0 ">
									<div class="bg-primary p-3">
										<h5 class="mb-0 text-white line-height text-center"><?= $this->session->userdata('nama') ?></h5>
									</div>
									<div class="d-inline-block w-100 text-center p-3">
										<a class="iq-bg-danger iq-sign-btn" href="<?= base_url() ?>logout" role="button">Sign out<i class="ri-login-box-line ml-2"></i></a>
									</div>
								</div>
							</div>
						</div>
					</li>
				<?php } else { ?>
					<li>
						<a href="#" class="search-toggle iq-waves-effect text-white" style="#F7CE68">
							<i class="ri-login-box-fill "></i>
						</a>
						<div class="iq-sub-dropdown iq-user-dropdown">
							<div class="iq-card shadow-none m-0">
								<div class="iq-card-body p-0 ">

									<a href="<?= base_url() ?>siswa/register" class="iq-sub-card iq-bg-primary-hover">
										<div class="media align-items-center">
											<div class="rounded iq-card-icon iq-bg-primary">
												<i class="ri-file-user-line"></i>
											</div>
											<div class="media-body ml-3">
												<h6 class="mb-0 ">Buat Akun </h6>
												<p class="mb-0 font-size-12">Klik Disini </p>
											</div>
										</div>
									</a>
									<a href="<?= base_url() ?>siswa/login" class="iq-sub-card iq-bg-primary-success-hover">
										<div class="media align-items-center">
											<div class="rounded iq-card-icon iq-bg-success">
												<i class="ri-profile-line"></i>
											</div>
											<div class="media-body ml-3">
												<h6 class="mb-0 ">Masuk </h6>
												<p class="mb-0 font-size-12">Klik Disini</p>
											</div>
										</div>
									</a>
								</div>
							</div>
						</div>
					</li>
				<?php  } ?>
			</ul>
		</nav>
	</div>
</div>