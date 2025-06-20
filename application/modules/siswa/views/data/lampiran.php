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

	.progress-step.completed .progress-marker {
		background-color: rgba(var(--primary-rgb), 0.1);
		border-color: var(--primary);
	}

	.progress-step.completed .progress-marker i {
		color: var(--primary);
	}

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
<form action="<?= base_url() ?>siswa/save" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?= $get->id_siswa ?>">
	<input type="hidden" name="ukuran_baju" value="<?= $get->ukuran_baju ?>">
	<input type="hidden" name="lanjut" value="selesai">
	<input type="hidden" name="page" value="lampiran">
	<input type="hidden" name="jalur" value="<?= $get->jalur ?>">
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
    // NIK found in DTKS table, check status
    $dtks_data = $query->row();
    $status = $dtks_data->status;
    
    if ($status == 'Terdaftar') {
        // Status: Terdaftar
        echo '<div class="alert alert-primary" role="alert">
                <i class="ri-checkbox-circle-line mr-2"></i> Selamat NIK Anda Terdaftar di DTKS
              </div>';
    } else {
        // Status: Tidak Terdaftar
        echo '<div class="alert alert-danger" role="alert">
                <i class="ri-close-circle-line mr-2"></i> Mohon Maaf NIK Anda Tidak Terdaftar di DTKS
              </div>';
    }
} else {
    // NIK not found in DTKS table - need verification
    echo '<div class="alert alert-warning text-dark" role="alert">
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
					<li class="progress-step">
						<div class="progress-marker">
							<i class="ri-parent-fill"></i>
						</div>
						<div class="progress-text">
							<span class="step-number">4</span>
							<span class="step-title">Orang Tua</span>
						</div>
					</li>
					<li class="progress-step active">
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
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<tr class="iq-bg-primary text-center">
						<th width="25%"> Nama Dokumen</th>
						<th width="40%"> Pilih File</th>
						<th> #</th>
					</tr>
					<tr>
						<td><b onclick="$(this).closest('tr').find('input[type=file]').click()"> Foto <span class="text-danger">*</span> </b></td>
						<td>Foto ukuran 3x4 , file jpg, Max 500 kb<br>
							<input type="file" style="display: inline;width: auto" class="form-control-file" name="foto" <?= ($get->foto == "") ? "required" : ""; ?> accept="image/jpeg,image/x-png" onchange="previewImage(this, 'fotoPreview')">
						</td>
						<td>
							<span class="text-danger"> <?= (!empty($this->session->flashdata('error_foto'))) ? " " . $this->session->flashdata('message') . " " : ""; ?> </span>
							<img src="<?= base_url() ?>uploads/siswa/<?= $get->foto ?>" width="100px;" alt="" id="fotoPreview" style="display: <?= $get->foto ? 'block' : 'none'; ?>" required>
						</td>
					</tr>
					<tr>
						<td><b onclick="$(this).closest('tr').find('input[type=file]').click()"> Kartu Keluarga <span class="text-danger">*</span></b></td>
						<td>File pdf / jpg, Max 500 kb<br>
							<input type="file" style="display: inline;width: auto" accept="image/jpeg,image/x-png,application/pdf" class="form-control-file" name="kk" <?= ($get->kk == "") ? "required" : ""; ?> onchange="previewFile(this, 'kkPreview')">
						</td>
						<td>
							<span class="text-danger"> <?= (!empty($this->session->flashdata('error_kk'))) ? " " . $this->session->flashdata('message') . " " : ""; ?> </span>
							<div id="kkPreview" style="display: <?= $get->kk ? 'block' : 'none'; ?>">
								<?php if ($get->kk) : ?>
									<a href="<?= base_url() ?>uploads/siswa/<?= $get->kk ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat</a>
								<?php elseif ($get->kk) : ?>
									<a href="<?= base_url() ?>uploads/siswa/<?= $get->kk ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat</a>
								<?php else : ?>
									Lampiran tidak tersedia
								<?php endif; ?>
							</div>
						</td>
					</tr>
					<tr>
						<td><b onclick="$(this).closest('tr').find('input[type=file]').click()"> Akta Kelahiran Calon Siswa <span class="text-danger">*</span></b></td>
						<td>File pdf / jpg, Max 500 kb<br>
							<input type="file" style="display: inline;width: auto" accept="image/jpeg,image/x-png,application/pdf" class="form-control-file" name="akta" <?= ($get->akta_kelahiran_siswa == "") ? "required" : ""; ?> onchange="previewFile(this, 'aktaPreview')">
						</td>
						<td>
							<span class="text-danger"> <?= (!empty($this->session->flashdata('error_akta'))) ? " " . $this->session->flashdata('message') . " " : ""; ?> </span>
							<div id="aktaPreview" style="display: <?= $get->akta_kelahiran_siswa ? 'block' : 'none'; ?>">
								<?php if ($get->akta_kelahiran_siswa) : ?>
									<!-- <img src="<?= base_url() ?>uploads/siswa/<?= $get->akta_kelahiran_siswa ?>" width="100px;" alt=""><i class="fa fa-search" aria-hidden="true"></i> Lihat</a> -->
									<a href="<?= base_url() ?>uploads/siswa/<?= $get->akta_kelahiran_siswa ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat</a>
								<?php elseif ($get->akta_kelahiran_siswa) : ?>
									<a href="<?= base_url() ?>uploads/siswa/<?= $get->akta_kelahiran_siswa ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat</a>
								<?php else : ?>
									Lampiran tidak tersedia
								<?php endif; ?>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<b onclick="$(this).closest('tr').find('input[type=file]').click()"><?php echo ($get->tingkat_sekolah == "4") ? "Kartu Imunisasi" : "Surat Keterangan Lulus / Surat Tanda Selesai Belajar (STSB)"   ?></b>
						</td>
						<td>File pdf / jpg, Max 500 kb<br>
							<input type="file" style="display: inline;width: auto" accept="image/jpeg,image/x-png,application/pdf" class="form-control-file" name="skl" onchange="previewFile(this, 'sklPreview')">
						</td>
						<td>
							<span class="text-danger"> <?= (!empty($this->session->flashdata('error_skl'))) ? " " . $this->session->flashdata('message') . " " : ""; ?> </span>
							<div id="sklPreview" style="display: <?= $get->skl ? 'block' : 'none'; ?>">
								<?php if ($get->skl) : ?>
									<a href="<?= base_url() ?>uploads/siswa/<?= $get->skl ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat</a>
									<!-- <img src="<?= base_url() ?>uploads/siswa/<?= $get->skl ?>" width="100px;" alt=""> -->
								<?php elseif ($get->skl) : ?>
									<a href="<?= base_url() ?>uploads/siswa/<?= $get->skl ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat</a>
								<?php else : ?>
									Lampiran tidak tersedia
								<?php endif; ?>
							</div>
						</td>
					</tr>

					<?php if ($get->jalur != "114") {
						if ($get->jalur == "115") {
							$title = "Surat Keterangan Tidak Mampu";
						} else if ($get->jalur == "116") {
							$title = "Surat Keterangan Pindah Tugas Orang Tua";
						} else if ($get->jalur == "117") {
							$title = "Sertifikat / Rapor / Piagam ";
						}
					?>
						<tr>
							<td><b onclick="$(this).closest('tr').find('input[type=file]').click()"><?= $title ?> <span class="text-danger">*</span> </b></td>
							<td>File pdf / jpg, Max 500 kb<br><input type="file" accept="image/jpeg,image/x-png,application/pdf" style="display: inline;width: auto" class="form-control-file" name="suket" <?= ($get->suket == "") ? "required" : ""; ?> onchange="previewFile(this, 'suketPreview')"></td>
							<td>
								<span class="text-danger"> <?= (!empty($this->session->flashdata('error_suket'))) ? " " . $this->session->flashdata('message') . " " : "";  ?> </span>
								<div id="suketPreview" style="display: <?= $get->suket ? 'block' : 'none'; ?>">
									<?php if ($get->suket) : ?>
										<a href="<?= base_url() ?>uploads/siswa/<?= $get->suket ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat</a>
										<!-- <img src="<?= base_url() ?>uploads/siswa/<?= $get->suket ?>" width="100px;" alt=""> -->
									<?php elseif ($get->suket) : ?>
										<a href="<?= base_url() ?>uploads/siswa/<?= $get->suket ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat</a>
									<?php else : ?>
										Lampiran tidak tersedia
									<?php endif; ?>
								</div>
							</td>
						</tr>
					<?php } ?>

				</table>
			</div>
		</div>
	</div>

	<hr>
	<button class="btn btn-primary pull-right " type="submit"> Selanjutnya <i class="ri-arrow-right-fill"></i></button>
	<?php if (level_user() == "siswa") { ?>
		<a href="<?= base_url() ?>siswa/profil/orangtua" class="btn btn-warning pull-right mr-3 "> <i class="ri-arrow-left-fill"></i> Kembali </a>
	<?php } else { ?>
		<a href="<?= base_url() ?>siswa/edit/orangtua?id=<?= $get->id_siswa ?>" class="btn btn-warning pull-right mr-3 "> <i class="ri-arrow-left-fill"></i> Kembali </a>
	<?php } ?>
</form>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
	function previewImage(input, previewId) {
		var file = input.files[0];
		var maxSize = 500 * 1024; // 500KB dalam byte

		if (file.size <= maxSize) {
			var reader = new FileReader();
			reader.onload = function(e) {
				document.getElementById(previewId).style.display = 'block';
				document.getElementById(previewId).src = e.target.result;
			};
			reader.readAsDataURL(file);
		} else {
			Swal.fire({
				icon: 'error',
				title: 'Ukuran File Terlalu Besar',
				text: 'File tidak boleh melebihi 500KB!',
				confirmButtonText: 'Tutup'
			});
			input.value = ""; // Reset file input
		}
	}

	function previewFile(input, previewId) {
		var file = input.files[0];
		var maxSize = 500 * 1024; // 500KB dalam byte

		if (file.size <= maxSize) {
			var previewElement = document.getElementById(previewId);
			previewElement.style.display = 'block';

			if (file.type.includes("image")) {
				var reader = new FileReader();
				reader.onload = function(e) {
					previewElement.innerHTML = '<img src="' + e.target.result + '" width="100px">';
				};
				reader.readAsDataURL(file);
			} else {
				previewElement.innerHTML = '<a href="' + URL.createObjectURL(file) + '" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat</a>';
			}
		} else {
			Swal.fire({
				icon: 'error',
				title: 'Ukuran File Terlalu Besar',
				text: 'File tidak boleh melebihi 500KB!',
				confirmButtonText: 'Tutup'
			});
			input.value = ""; // Reset file input
		}
	}
</script>