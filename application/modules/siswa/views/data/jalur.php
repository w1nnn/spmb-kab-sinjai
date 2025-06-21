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
	<input type="hidden" name="lanjut" value="datadiri">
	<input type="hidden" name="page" value="jalur">
	<div class="row mb-0">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<?php
$nik = $get->no_ktp;
$this->db->where('nik', $nik);
$query = $this->db->get('tbl_status_dtks');

if ($query->num_rows() > 0) {
    $dtks_data = $query->row();
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
                <i class="ri-error-warning-line mr-2"></i> NIK Tidak Valid, Silakan Periksa Kembali
              </div>';
    } else {
        echo '<div class="alert alert-info" role="alert">
                <i class="ri-information-line mr-2"></i> Proses Verifikasi DTKS
              </div>';
    }
} else {
    echo '<div class="alert alert-secondary" role="alert">
            <i class="ri-question-line mr-2"></i> Data Tidak Ditemukan - Proses Verifikasi DTKS
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
					<li class="progress-step completed active">
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
				<label for=""> Tingkatan Sekolah <span class="text-danger">*</span> </label>
				<select name="tingkat" class="form-control" id="" required>
					<option value=""> Pilih </option>
					<?php foreach ($tingkat as $value): $selected = ($value->id == $get->tingkat_sekolah) ? "selected" : "";    ?>
						<option value="<?= $value->id ?>" <?= $selected ?>> <?= $value->level_sekolah ?> </option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label for=""> Jalur Pendaftaran <span class="text-danger">*</span> </label>
				<select name="jalur" class="form-control" id="" required>
					<option value=""> Pilih </option>
					<?php foreach ($jalur as $value): $selected = ($value->id == $get->jalur) ? "selected" : "";    ?>
						<option value="<?= $value->id ?>" <?= $selected ?>> <?= $value->nama ?> </option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>

	</div>
	<hr>
	<button class="btn btn-primary pull-right " type="submit"> Selanjutnya <i class="ri-arrow-right-fill"></i></button>

</form>