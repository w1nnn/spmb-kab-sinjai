<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">

<div class="row">
	<div class="col-sm-12">
		<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
			<div class="iq-card-body">
				<div class="row">
					<div class="col-md-3 col-12">
						<center>
							<img src="<?= base_url() ?>assets/images/<?= $get->logo ?>" alt="" width="60%">
						</center>
						<?php if (level_user() == "sekolah") { ?>
							<hr>
							<a href="#" data-toggle="modal" data-target="#edit" class="btn btn-sm btn-warning btn-block text-left "> <i class="ri-edit-2-line"></i> Edit Profil </a>
							<a href="#" data-toggle="modal" data-target="#kuota" class="btn btn-sm btn-success btn-block text-left "> <i class="ri-edit-2-line"></i> Edit Kuota Diterima </a>
							<a href="#" data-toggle="modal" data-target="#ubahPassword" class="btn btn-sm btn-primary btn-block text-left"> <i class="ri-lock-2-line "></i>Ubah Password </a>

						<?php } ?>
						<?php if (level_user() == "admin") { ?>
							<hr>
							<a href="#" data-toggle="modal" data-target="#edit" class="btn btn-sm btn-block btn-warning mb-1  text-left"> <i class="ri-edit-2-line"></i> Edit Profil </a>
							<a href="#" data-toggle="modal" data-target="#kuota" class="btn btn-sm btn-success btn-block text-left "> <i class="ri-edit-2-line"></i> Edit Kuota Diterima </a>
							<a href="#" data-toggle="modal" data-target="#reset" class="btn btn-sm btn-block btn-outline-primary mb-1 text-left"> <i class="ri-refresh-line "></i> Reset Password </a>

							<div class="modal fade " id="reset" tabindex="-1" role="dialog">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Reset Password</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">×</span>
											</button>
										</div>
										<div class="modal-body">
											<p>Anda yakin ingin melakukan reset password ? </p>
											<hr>
											Jika klik reset maka password akun pada sekolah <b><?= $get->nama ?> </b> akan berubah menjadi nomor NPSN nya <b class="text-primary">(<?= $get->npsn ?>)</b>
										</div>
										<div class="modal-footer">

											<a href="<?= base_url() ?>sekolah/resetpassword/<?= $get->id_sekolah ?>/<?= $get->npsn ?>" data class="btn btn-primary"> Reset Sekarang </a>
										</div>
									</div>
								</div>
							</div>

						<?php } ?>

						<?php if (level_user() == "superadmin") { ?>
							<hr>
							<a href="#" data-toggle="modal" data-target="#edit" class="btn btn-sm btn-block btn-warning mb-1  text-left"> <i class="ri-edit-2-line"></i> Edit Profil </a>
							<a href="#" data-toggle="modal" data-target="#kuota" class="btn btn-sm btn-success btn-block text-left "> <i class="ri-edit-2-line"></i> Edit Kuota Diterima </a>
							<a href="#" data-toggle="modal" data-target="#ubahPassword" class="btn btn-sm btn-block btn-primary mb-1 text-left"> <i class="ri-lock-2-line"></i> Ubah Password </a>
							<a href="#" data-toggle="modal" data-target="#reset" class="btn btn-sm btn-block btn-outline-primary mb-1 text-left"> <i class="ri-refresh-line "></i> Reset Password </a>
							<a href="#" data-toggle="modal" data-target="#hapus" class="btn  btn-sm btn-block  mb-1  btn-danger text-left"> <i class="ri-delete-bin-2-line "></i> Hapus Sekolah </a>

							<!--modal update password-->

							<div class="modal fade " id="hapus" tabindex="-1" role="dialog">
								<div class="modal-dialog modal-sm" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Hapus Sekolah </h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">×</span>
											</button>
										</div>
										<div class="modal-body">
											<p>Anda yakin ingin menghapus data sekolah ? </p>
										</div>
										<div class="modal-footer">

											<a href="<?= base_url() ?>sekolah/delete/<?= $get->id_sekolah ?>" data class="btn btn-danger"> Hapus Sekolah </a>
										</div>
									</div>
								</div>
							</div>

							<!--!modal-update-password-->


							<div class="modal fade " id="reset" tabindex="-1" role="dialog">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Reset Password</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">×</span>
											</button>
										</div>
										<div class="modal-body">
											<p>Anda yakin ingin melakukan reset password ? </p>
											<hr>
											Jika klik reset maka password akun pada sekolah <b><?= $get->nama ?> </b> akan berubah menjadi nomor NPSN nya <b class="text-primary">(<?= $get->npsn ?>)</b>
										</div>
										<div class="modal-footer">

											<a href="<?= base_url() ?>sekolah/resetpassword/<?= $get->id_sekolah ?>/<?= $get->npsn ?>" data class="btn btn-primary"> Reset Sekarang </a>
										</div>
									</div>
								</div>
							</div>

						<?php } ?>


					</div>
					<div class="col-md-9  col-12">

						<h5><?= $get->npsn ?> </h5>
						<h4><b> <?= $get->nama ?> </b></h4>
						<p>
							<i class="ri-map-pin-2-fill"></i> <?= capital($get->alamat) ?>
							Kelurahan <?= capital($get->kel) ?>, Kecamatan <?= capital($get->nama_kec) ?>
							, <?= capital($get->nama_kab) ?> <br>
							<i class="ri-mail-fill"></i> <a href="mailto:<?= $get->email ?> "> <?= $get->email ?> </a> <br>
							<i class="ri-phone-fill"></i> <a href="tel:<?= $get->no_hp ?>"> <?= $get->no_hp ?> </a> <br>
							<i class="ri-phone-fill"></i> <a href="tel:<?= $get->no_hp_kepsek ?>"> <?= $get->no_hp_kepsek ?> </a> <br>
							<i class="ri-bookmark-3-fill"></i> <?= $get->status ?> <br>
						</p>
						<div class="row">
							<div class="col-md-6">
								<div class="card text-white bg-primary  iq-mb-3">
									<div class="card-body">
										<p>Kuota Penerimaan </p>
										<h3 class="card-title text-white"><?= $get->kuota ?> Orang </h3>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="card text-white bg-success  iq-mb-3">
									<div class="card-body">
										<p>Telah Mendaftar </p>
										<h3 class="card-title text-white">
											<?= jumlahPendaftar($get->npsn) ?> Orang
											<?php if (level_user() == "admin" || level_user() == "superadmin") { ?>
												<span style="font-size:14px; font-weight:bold;" class=" pull-right "> <a href="<?= base_url() ?>sekolah/laporan?jalur=all&npsn=<?= $get->npsn ?>"> <i class="ri-user-search-line "></i> Lihat Pendaftar </a> </span>
												<div class="clearfix"></div>
											<?php } ?>
										</h3>



									</div>
								</div>
							</div>
							<div class="col-md-12">
								<h3>Area Zonasi </h3>
								<ol>
									<?php
									$this->load->model('zonasi_model', 'zonasi');

									$areaZonasis = $this->zonasi->get_daerah_sekolah($get->npsn);
									foreach ($areaZonasis as $value) {
										$dkec = $this->db->query("select * from kecamatan where id_kec='$value->kecamatan' limit 1")->row();
									?>
										<li> <?= $value->daerah_zonasi . ' - ' . strtoupper($dkec->nama_kec) ?> </li>
									<?php
									}
									?>
								</ol>
							</div>

						</div>

						<?php if ($this->session->userdata('isLogin') != TRUE) { ?>
							<hr>
							<a href="<?= base_url() ?>sekolah?level=<?= $get->id ?>" class="btn btn-warning">Cari
								Sekolah Lain <i class="ri-arrow-right-circle-line"></i></a>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!--modal update password-->
<form action="<?= base_url() ?>sekolah/updatePassword" method="POST">
	<input type="hidden" name="npsn" value="<?= $get->npsn ?>">

	<div class="modal fade " id="ubahPassword" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Ubah Password </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for=""> Password Lama </label>
						<input type="password" class="form-control" name="pwdLama" autocomplete="off">
					</div>
					<div class="form-group">
						<label for=""> Password Baru </label>
						<input type="password" class="form-control" name="pwdBaru" autocomplete="off">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary"> <i class="ri-refresh-line "></i> Update Password </button>
				</div>
			</div>
		</div>
	</div>
</form>
<!--!modal-update-password-->


<!--modal edit sekolah-->
<form action="<?= base_url() ?>sekolah/update" method="POST">
	<input type="hidden" name="id" value="<?= $get->id_sekolah ?>">
	<div class="modal fade " id="edit" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit Profil Sekolah </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for=""> NPSN </label>
								<input type="text" value="<?= $get->npsn ?>" class="form-control" name="npsn" autocomplete="off" required>
							</div>

							<div class="form-group">
								<label for=""> Nama Sekolah </label>
								<input type="text" value="<?= $get->nama ?>" class="form-control" name="nama" autocomplete="off" required>
							</div>

							<div class="form-group">
								<label for=""> Alamat </label>
								<input type="text" value="<?= $get->alamat ?>" class="form-control" name="alamat" autocomplete="off" required>
							</div>
							<div class="form-group">
								<label for=""> Kelurahan </label>
								<input type="text" class="form-control" name="kel" autocomplete="off" value="<?= $get->kel ?>" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for=""> Kecamatan </label>
								<select name="kec" class="form-control select2" id="" style="width:100%" required>
									<option value=""> Pilih </option>
									<?php foreach ($kecamatans as $value):  $selected = ($value->id_kec == $get->kec) ? "selected" : ""; ?>
										<option value="<?= $value->id_kec ?>" <?= $selected ?>> <?= $value->nama_kec ?> </option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group">
								<label for=""> Status </label>
								<select name="status" class="form-control" id="" required>
									<option value=""> Pilih </option>
									<option value="NEGERI" <?php echo ($get->status == "NEGERI") ? "selected" : ""; ?>>NEGERI</option>
									<option value="SWASTA" <?php echo ($get->status == "SWASTA") ? "selected" : ""; ?>>SWASTA</option>
								</select>
							</div>
							<div class="form-group">
								<label for=""> Email Sekolah </label>
								<input type="email" class="form-control" name="email" autocomplete="off" value="<?= $get->email ?>">
							</div>
							<div class="form-group">
								<label for=""> Nomor Handphone Kepala Sekolah </label>
								<input type="text" class="form-control" name="no_hp_kepsek" autocomplete="off" value="<?= $get->no_hp_kepsek ?>">
							</div>

							<div class="form-group">
								<label for=""> Nomor Handphone Operator </label>
								<input type="text" class="form-control" name="no_hp" autocomplete="off" value="<?= $get->no_hp ?>">
							</div>

						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary"> <i class="ri-refresh-line "></i> Update </button>
				</div>
			</div>
		</div>
	</div>
</form>
<!--!modal-edit-sekolah-->

<!--modal update password-->
<form action="<?= base_url() ?>sekolah/updateKuota" method="POST">
	<input type="hidden" name="npsn" value="<?= $get->npsn ?>">
	<div class="modal fade " id="kuota" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit Kuota </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for=""> Jumlah Kuota </label>
						<input type="number" class="form-control" name="kuota" autocomplete="off" value="<?= $get->kuota; ?>">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary"> <i class="ri-refresh-line "></i> Update Kuota </button>
				</div>
			</div>
		</div>
	</div>
</form>
<!--!modal-update-password-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>

<?php if ($this->input->get('alert')): ?>
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
				icon: '<?= $this->input->get('alert') ?>',
				title: '<?= $this->input->get('message') ?>'
			});

			// Hapus parameter alert & message dari URL tanpa reload
			if (history.pushState) {
				const url = new URL(window.location);
				url.searchParams.delete('alert');
				url.searchParams.delete('message');
				window.history.replaceState({}, document.title, url.toString());
			}
		});
	</script>
<?php endif; ?>