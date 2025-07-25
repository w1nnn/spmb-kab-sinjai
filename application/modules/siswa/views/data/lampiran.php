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
				$nik = $get->no_ktp;

				$this->db->where('nik', $nik);
				$query_dtks = $this->db->get('tbl_status_dtks');

				$this->db->where('no_ktp', $nik);
				$query_siswa = $this->db->get('tbl_siswa');

				$is_proses_pemadanan = false;
				if ($query_siswa->num_rows() > 0) {
					$siswa_data = $query_siswa->row();
					if (isset($siswa_data->sts_dtks) && $siswa_data->sts_dtks == 5) {
						$is_proses_pemadanan = true;
					}
				}

				if ($is_proses_pemadanan) {
					echo '<div class="alert alert-warning text-dark" role="alert">
							<i class="ri-time-line mr-2"></i> Proses Pemadanan Data
						</div>';
				} elseif ($query_dtks->num_rows() > 0) {
					$dtks_data = $query_dtks->row();
					$status = $dtks_data->status;
					
					if ($status == 'Terdaftar') {
						echo '<div class="alert alert-success" role="alert">
								<i class="ri-checkbox-circle-line mr-2"></i> Selamat NIK Anda Terdaftar di DTKS
							</div>';
					} elseif ($status == 'Tidak Terdaftar') {
						echo '<div class="alert alert-danger" role="alert">
								<i class="ri-close-circle-line mr-2"></i> Mohon Maaf NIK Anda Tidak Terdaftar di DTKS
							</div>';
					} elseif ($status == 'NIK Tidak Valid') {
						echo '<div class="alert alert-warning text-dark" role="alert">
								<i class="ri-error-warning-line mr-2"></i> NIK Anda Tidak Valid di DTKS
							</div>';
					} else {
						echo '<div class="alert alert-info" role="alert">
								<i class="ri-information-line mr-2"></i> Proses Verifikasi DTKS
							</div>';
					}
				} else {
					echo '<div class="alert alert-secondary" role="alert">
							<i class="ri-question-line mr-2"></i> Proses Verifikasi DTKS
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
	<div class="row mb-3">
	<div class="col-md-12">
		<div class="alert alert-info text-dark" role="alert">
			<i class="ri-information-line mr-2"></i> Silahkan download panduan surat keterangan tidak mampu (SKTM)
		</div>
		<?php
		$this->db->select('lampiran');
		$this->db->from('tbl_dokumen');
		$this->db->where('jenis_file', 'sktm');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$lampiran = $row->lampiran;
			if ($lampiran) {
				echo '<a href="' . base_url('uploads/lampiran/' . $lampiran) . '" class="btn btn-warning mb-3" style="width:100%;" target="_blank"><i class="ri-download-2-fill"></i> Download Panduan SKTM</a>';
			} else {
				echo '<div class="alert alert-warning text-dark">Panduan SKTM tidak tersedia.</div>';
			}
		} else {
			echo '<div class="alert alert-warning text-dark">Dokumen SKTM belum di upload oleh administrator.</div>';
		}
		?>
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
				<!-- Upload SKTM -->
				<tr>
					<td><b>SKTM/KIP/KKS <span class="text-danger">*</span></b></td>
					<td>
						<div class="mb-2">
							<label for="jenisLampiran" class="form-label">Pilih Jenis Dokumen <span class="text-danger">*</span></label>
							<select class="form-control" name="jenis_lampiran" id="jenisLampiran" onchange="toggleSktmFileInput()">
								<option value="">-- Pilih Jenis Dokumen --</option>
								<option value="sktm" <?= ($get->jenis_lampiran == 'sktm') ? 'selected' : '' ?>>SKTM (Surat Keterangan Tidak Mampu)</option>
								<option value="kip" <?= ($get->jenis_lampiran == 'kip') ? 'selected' : '' ?>>KIP (Kartu Indonesia Pintar)</option>
								<option value="kks" <?= ($get->jenis_lampiran == 'kks') ? 'selected' : '' ?>>KKS (Kartu Keluarga Sejahtera)</option>
							</select>
						</div>
						<div id="sktmFileContainer" style="display: <?= $get->jenis_lampiran ? 'block' : 'none'; ?>">
							<label class="form-label">Upload File</label><br>
							<small class="text-muted">File pdf / jpg, Max 500 kb</small><br>
							<input type="file" style="display: inline;width: auto" accept="image/jpeg,image/x-png,application/pdf" class="form-control-file" name="sktm" id="sktmFile" onchange="previewSktmFile(this)" disabled>
						</div>
					</td>
					<td>
						<div id="sktmPreview" style="display: <?= $get->sktm ? 'block' : 'none'; ?>">
							<?php if ($get->sktm) : ?>
								<a href="<?= base_url() ?>uploads/siswa/<?= $get->sktm ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat</a>
								<br><small class="text-info">Jenis: <?= $get->jenis_lampiran ? strtoupper($get->jenis_lampiran) : 'Belum dipilih' ?></small>
							<?php else : ?>
								Lampiran tidak tersedia
							<?php endif; ?>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>

<!-- Checkbox validasi bahwa file sktm yang telah saya upload sesuai dengan format dan apabila tidak saya siapkan sanksi -->
<div class="form-group">
	<div class="form-check">
		<input class="form-check-input" type="checkbox" name="validasi_sktm" id="validasi_sktm" required>
		<label class="form-check-label" for="validasi_sktm">
			Saya menyatakan dengan sebenar-benarnya bahwa file Surat Keterangan Tidak Mampu (SKTM) yang saya unggah telah sesuai dengan format yang telah ditentukan. Apabila terbukti tidak sesuai, saya siap menerima segala bentuk sanksi yang berlaku.
		</label>
	</div>
</div>
<!-- End Checkbox validasi -->
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
			input.value = ""; 
		}
	}

	function toggleSktmFileInput() {
	var jenisLampiran = document.getElementById('jenisLampiran').value;
	var fileContainer = document.getElementById('sktmFileContainer');
	var fileInput = document.getElementById('sktmFile');
	
	if (jenisLampiran) {
		// Tampilkan input file dan aktifkan
		fileContainer.style.display = 'block';
		fileInput.disabled = false;
		
	} else {
		// Sembunyikan input file dan nonaktifkan
		fileContainer.style.display = 'none';
		fileInput.disabled = true;
		fileInput.value = ""; // Reset file input
		
		// Sembunyikan preview
		document.getElementById('sktmPreview').style.display = 'none';
	}
}

	function previewSktmFile(input) {
		var file = input.files[0];
		var maxSize = 500 * 1024; // 500KB dalam byte
		
		// Validasi ukuran file
		if (file.size > maxSize) {
			Swal.fire({
				icon: 'error',
				title: 'Ukuran File Terlalu Besar',
				text: 'File tidak boleh melebihi 500KB!',
				confirmButtonText: 'Tutup'
			});
			input.value = ""; // Reset file input
			return;
		}
		
		var previewElement = document.getElementById('sktmPreview');
		previewElement.style.display = 'block';
		
		var jenisLampiran = document.getElementById('jenisLampiran').value;
		
		if (file.type.includes("image")) {
			var reader = new FileReader();
			reader.onload = function(e) {
				previewElement.innerHTML = '<img src="' + e.target.result + '" width="100px"><br><small class="text-info">Jenis: ' + jenisLampiran.toUpperCase() + '</small>';
			};
			reader.readAsDataURL(file);
		} else {
			previewElement.innerHTML = '<a href="' + URL.createObjectURL(file) + '" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat</a><br><small class="text-info">Jenis: ' + jenisLampiran.toUpperCase() + '</small>';
		}
	}

	// Inisialisasi saat halaman dimuat
	document.addEventListener('DOMContentLoaded', function() {
		toggleSktmFileInput();
	});
</script>