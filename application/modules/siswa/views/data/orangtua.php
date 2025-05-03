<style>
	.progress-tracker {
		margin-bottom: 2rem;
		position: relative;
	}

	.progress-tracker ul::after {
		content: '';
		position: absolute;
		top: 25px;
		left: 0;
		width: 100%;
		height: 3px;
		background-color: #e0e0e0;
		z-index: 1;
	}

	.progress-step {
		position: relative;
		text-align: center;
		z-index: 2;
		width: 16.666%;
	}

	.progress-marker {
		position: relative;
		display: flex;
		height: 50px;
		width: 50px;
		margin: 0 auto 12px;
		background-color: #f5f7fa;
		border: 3px solid #e0e0e0;
		border-radius: 50%;
		justify-content: center;
		align-items: center;
		z-index: 3;
		transition: all 0.3s ease;
	}

	.progress-marker i {
		font-size: 20px;
		color: #6c757d;
		transition: all 0.3s ease;
	}

	.progress-text {
		padding: 0 8px;
	}

	.step-number {
		display: block;
		font-size: 12px;
		font-weight: 600;
		color: #6c757d;
	}

	.step-title {
		display: block;
		font-size: 14px;
		font-weight: 500;
		color: #6c757d;
	}

	/* Completed step */
	.progress-step.completed .progress-marker {
		background-color: rgba(var(--primary-rgb), 0.1);
		border-color: var(--primary);
	}

	.progress-step.completed .progress-marker i {
		color: var(--primary);
	}

	/* Active step */
	.progress-step.active .progress-marker {
		background-color: var(--primary);
		border-color: var(--primary);
		transform: scale(1.05);
		box-shadow: 0 0 12px rgba(var(--primary-rgb), 0.4);
	}

	.progress-step.active .progress-marker i {
		color: white;
	}

	.progress-step.active .step-number,
	.progress-step.active .step-title {
		color: var(--primary);
		font-weight: 700;
	}

	@media (max-width: 768px) {
		.progress-marker {
			height: 40px;
			width: 40px;
		}

		.progress-marker i {
			font-size: 16px;
		}

		.step-title {
			font-size: 12px;
		}

		.progress-tracker ul::after {
			top: 20px;
		}
	}
</style>
<form action="<?= base_url() ?>siswa/save" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
	<input type="hidden" name="id" value="<?= $get->id_siswa ?>">
	<input type="hidden" name="lanjut" value="lampiran">
	<input type="hidden" name="page" value="orangtua">

	<div class="row mb-0">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<?php
					// Query to check if NIK exists in tbl_status_dtks
					$nik = $get->no_ktp;
					$this->db->where('nik', $nik);
					$query = $this->db->get('tbl_status_dtks');

					if ($query->num_rows() > 0) {
						// NIK found in DTKS table
						echo '<div class="alert alert-primary" role="alert">
                            <i class="ri-checkbox-circle-line mr-2"></i> Terdata di DTKS
                          </div>';
					} else {
						// NIK not found in DTKS table
						echo '<div class="alert alert-warning" role="alert">
        <i class="ri-error-warning-line mr-2"></i> Proses Verifikasi DTKS
    </div>';
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="row mb-4">
		<div class="col-12">
			<div class="progress-tracker">
				<ul class="d-flex justify-content-between list-unstyled position-relative">
					<li class="progress-step">
						<div class="progress-marker">
							<i class="ri-guide-fill"></i>
						</div>
						<div class="progress-text">
							<span class="step-number">1</span>
							<span class="step-title">Jalur</span>
						</div>
					</li>
					<li class="progress-step ">
						<div class="progress-marker">
							<i class="ri-user-2-fill"></i>
						</div>
						<div class="progress-text">
							<span class="step-number">2</span>
							<span class="step-title">Data Diri</span>
						</div>
					</li>
					<li class="progress-step">
						<div class="progress-marker">
							<i class="ri-building-fill"></i>
						</div>
						<div class="progress-text">
							<span class="step-number">3</span>
							<span class="step-title">Sekolah</span>
						</div>
					</li>
					<li class="progress-step active">
						<div class="progress-marker">
							<i class="ri-parent-fill"></i>
						</div>
						<div class="progress-text">
							<span class="step-number">4</span>
							<span class="step-title">Orang Tua</span>
						</div>
					</li>
					<li class="progress-step">
						<div class="progress-marker">
							<i class="ri-booklet-fill"></i>
						</div>
						<div class="progress-text">
							<span class="step-number">5</span>
							<span class="step-title">Dokumen</span>
						</div>
					</li>
					<li class="progress-step">
						<div class="progress-marker">
							<i class="ri-folder-chart-fill"></i>
						</div>
						<div class="progress-text">
							<span class="step-number">6</span>
							<span class="step-title">Selesai</span>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label for=""> Nomor Kartu Keluarga <span class="text-danger">*</span> </label>
				<input autocomplete="off" type="number" maxlength="16" name="no_kk" class="form-control" value="<?= $get->no_kk ?>" required>
			</div>
			<div class="form-group">
				<label for=""> Nomor Handphone Ayah / Ibu <span class="text-danger">*</span> </label>
				<input autocomplete="off" type="number" maxlength="14" name="no_hp_ortu" class="form-control" value="<?= $get->no_hp_ortu ?>" required>
			</div>
			<div class="form-group">
				<label for=""> Nama Ayah <span class="text-danger">*</span> </label>
				<input autocomplete="off" type="text" name="nama_ayah" class="form-control" value="<?= $get->nm_ayah ?>" required>
			</div>
			<div class="form-group">
				<label for=""> Pekerjaan Ayah <span class="text-danger">*</span> </label>
				<input autocomplete="off" type="text" name="pekerjaan_ayah" class="form-control" value="<?= $get->pekerjaan_ayah ?>" required>
			</div>

			<div class="form-group">
				<label for=""> Nama Ibu <span class="text-danger">*</span> </label>
				<input autocomplete="off" type="text" name="nama_ibu" class="form-control" value="<?= $get->nm_ibu ?> " required>
			</div>
			<div class="form-group">
				<label for=""> Pekerjaan Ibu <span class="text-danger">*</span> </label>
				<input autocomplete="off" type="text" name="pekerjaan_ibu" class="form-control" value="<?= $get->pekerjaan_ibu ?> " required>
			</div>

			<div class="form-group">
				<label for=""> Nama Wali </label>
				<input autocomplete="off" type="text" name="nama_wali" class="form-control" value="<?= $get->nm_wali ?> ">
			</div>
			<div class="form-group">
				<label for=""> Pekerjaan Wali </label>
				<input autocomplete="off" type="text" name="pekerjaan_wali" class="form-control" value="<?= $get->pekerjaan_wali ?> ">
			</div>
		</div>

	</div>
	<hr>
	<button class="btn btn-primary pull-right " type="submit"> Selanjutnya <i class="ri-arrow-right-fill"></i></button>

	<?php if (level_user() == "siswa") { ?>
		<a href="<?= base_url() ?>siswa/profil/sekolah" class="btn btn-warning pull-right mr-3 "> <i class="ri-arrow-left-fill"></i> Kembali </a>
	<?php } else { ?>
		<a href="<?= base_url() ?>siswa/edit/sekolah?id=<?= $get->id_siswa ?>" class="btn btn-warning pull-right mr-3 "> <i class="ri-arrow-left-fill"></i> Kembali </a>

	<?php } ?>

	<!-- <a href="<?= base_url() ?>siswa/profil" class="btn btn-warning pull-right mr-3 " > <i class="ri-arrow-left-fill"></i> Kembali </a> -->

</form>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
	function validateForm() {
		// Get the value of the "no_kk" field
		var noKk = document.querySelector('input[name="no_kk"]').value;

		// Check if the length of the No. KK is not 16 digits
		if (noKk.length !== 16) {
			// Display SweetAlert message
			Swal.fire({
				icon: 'error',
				title: 'Invalid Nomor Kartu Keluarga',
				text: 'Nomor Kartu Keluarga harus terdiri dari 16 digit.',
				confirmButtonText: 'Ok'
			});
			return false; // Prevent form submission
		}
		return true; // Allow form submission if validation passes
	}
</script>