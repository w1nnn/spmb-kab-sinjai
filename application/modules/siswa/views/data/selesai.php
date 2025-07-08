<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">

<style>
	.h1,
	.h2,
	.h3,
	.h4,
	.h5,
	.h6,
	h1,
	h2,
	h3,
	h4,
	h5,
	h6 {
		margin-bottom: 0px;
	}

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
<form action="<?= base_url() ?>siswa/save" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?= $get->id_siswa ?>">
	<input type="hidden" name="lanjut" value="detail">
	<input type="hidden" name="page" value="selesai">

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
					<li class="progress-step">
						<div class="progress-marker">
							<i class="ri-booklet-fill"></i>
						</div>
						<div class="progress-text">
							<span class="step-number">5</span>
							<span class="step-title">Dokumen</span>
						</div>
					</li>
					<li class="progress-step active">
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
			<ul class="list-group">
				<li class="list-group-item active">
					<h5> Data Diri </h5>
				</li>
			</ul>
			<div class="row">
				<div class="col-md-10">
					<div class="table-responsive">
						<table class="table table-hover">
							<tr>
								<td width="30%">Nama Calon Siswa </td>
								<td width="2%">: </td>
								<td> <b><?= $get->nama_siswa  ?> </b> </td>
							</tr>
							<tr>
								<td>Nomor Induk Kependudukan (NIK)</td>
								<td>: </td>
								<td> <?= $get->no_ktp  ?> </td>
							</tr>
							<tr>
								<td>Tempat / Tanggal Lahir </td>
								<td>: </td>
								<td> <?= $get->tempat_lahir  ?> / <?= tgl_indo($get->tgl_lahir) ?> (<?= \Carbon\Carbon::parse($get->tgl_lahir)->age . ' Tahun'  ?>) </td>
							</tr>
							<tr>
								<td>Jenis Kelamin </td>
								<td>: </td>
								<td> <?= jk($get->jk)  ?> </td>
							</tr>
							<tr>
								<td>Agama </td>
								<td>: </td>
								<td> <?= $get->agama  ?> </td>
							</tr>
							<?php
							if ($get->tingkat_sekolah != "4") {
							?>
								<tr>
									<td>Asal Sekolah </td>
									<td>: </td>
									<td> <?= $get->asal_sekolah  ?> </td>
								</tr>
							<?php } ?>
							<tr>
								<td>Alamat </td>
								<td>: </td>
								<td> <?= $get->alamat  ?> </td>
							</tr>
							<tr>
								<td>Kecamatan </td>
								<td>: </td>
								<td> <?= kecamatan($get->kec)->nama_kec;  ?> </td>
							</tr>

							<tr>
								<td>Desa / Dusun / Lingkungan </td>
								<td>: </td>
								<td> <?= dusun($get->dusun)->daerah_zonasi;  ?> </td>
							</tr>
							<tr>
								<td>Ukuran Baju </td>
								<td>: </td>
								<td> <?= $get->ukuran_baju  ?> </td>
							</tr>

						</table>
					</div>
				</div>
				<div class="col-md-2">
					<img src="<?= base_url() ?>uploads/siswa/<?= $get->foto ?>" width="100%;" alt="" class="mt-3 rounded">
				</div>
			</div>



			<ul class="list-group">
				<li class="list-group-item active">
					<h5> Data Orang Tua </h5>
				</li>
			</ul>
			<div class="table-responsive">
				<table class="table table-hover">
					<tr>
						<td width="20%">Nomor KK </td>
						<td width="2%">: </td>
						<td> <?= $get->no_kk  ?> </td>
					</tr>
					<tr>
						<td width="20%">Nama Ayah </td>
						<td width="2%">: </td>
						<td> <?= $get->nm_ayah  ?> </td>
					</tr>
					<tr>
						<td>Pekerjaan Ayah </td>
						<td>: </td>
						<td> <?= $get->pekerjaan_ayah  ?> </td>
					</tr>
					<tr>
						<td>Nama Ibu </td>
						<td>: </td>
						<td> <?= $get->nm_ibu  ?> </td>
					</tr>
					<tr>
						<td>Pekerjaan Ibu </td>
						<td>: </td>
						<td> <?= $get->pekerjaan_ibu  ?> </td>
					</tr>
					<tr>
						<td>Nama Wali </td>
						<td>: </td>
						<td> <?= $get->nm_wali  ?> </td>
					</tr>
					<tr>
						<td>Pekerjaan Wali </td>
						<td>: </td>
						<td> <?= $get->pekerjaan_wali  ?> </td>
					</tr>
					<tr>
						<td>No Handphone </td>
						<td>: </td>
						<td> <?= $get->no_hp_ortu  ?> </td>
					</tr>

				</table>

			</div>

			<ul class="list-group">
				<li class="list-group-item active">
					<h5> Sekolah Tujuan </h5>
				</li>
			</ul>
			<div class="table-responsive">
				<table class="table table-hover">
					<tr>
						<td width="20%">Jalur </td>
						<td width="2%">: </td>
						<td> <?= jalur($get->jalur)->nama  ?> </td>
					</tr>

					<?php if ($get->jalur == "117") { ?>
						<tr>
							<td width="20%">
								Bidang Prestasi
							</td>
							<td width="2%">:</td>
							<td> <?= $get->bidang_prestasi  ?> </td>
						</tr>
					<?php } ?>

					<tr>
						<td>Sekolah Pilihan </td>
						<td>: </td>
						<td> <b> <?= sekolah($get->pilihan_sekolah_1)->nama  ?> </b> </td>
					</tr>


				</table>
			</div>



			<ul class="list-group">
				<li class="list-group-item active">
					<h5> Lampiran Dokumen </h5>
				</li>
			</ul>
			<div class="table-responsive">
				<table class="table table-hover">

					<tr>
						<td>KK </td>
						<td>: </td>
						<td>
							<?php if ($get->kk) : ?>
								<a href="<?= base_url() ?>uploads/siswa/<?= $get->kk ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat Lampiran</a>
							<?php else : ?>
								Lampiran tidak tersedia
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td>Akta Kelahiran </td>
						<td>: </td>
						<td>
							<?php if ($get->akta_kelahiran_siswa) : ?>
								<a href="<?= base_url() ?>uploads/siswa/<?= $get->akta_kelahiran_siswa ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat Lampiran</a>
							<?php else : ?>
								Lampiran tidak tersedia
							<?php endif; ?>
						</td>
					</tr>
					<?php if ($get->lampiran_psikolog) : ?>
						<tr>
							<td>Surat Keterangan Psikolog</td>
							<td>: </td>
							<td>
								<a href="<?= base_url() ?>uploads/siswa/psikolog/<?= $get->lampiran_psikolog ?>" target="_blank" class="btn btn-sm btn-primary">
									<i class="fa fa-search" aria-hidden="true"></i> Lihat Lampiran
								</a>
							</td>
						</tr>
					<?php endif; ?>
					<?php
					if ($get->jalur != "114") {
						if ($get->jalur == "115") {
							$title = "Surat Keterangan Tidak Mampu";
						} elseif ($get->jalur == "116") {
							$title = "Surat Keterangan Pindah Tugas Orang Tua";
						} elseif ($get->jalur == "117") {
							$title = "Sertifikat / Piagam / Rapor";
						}
					?>

						<tr>
							<td><b><?= $title  ?> </b> </td>
							<td>:</td>
							<td>
								<?php if ($get->suket) : ?>
									<a href="<?= base_url() ?>uploads/siswa/<?= $get->suket ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat Lampiran</a>
								<?php else : ?>
									Lampiran tidak tersedia
								<?php endif; ?>
							</td>
						</tr>
					<?php } ?>
					<tr>
						<td width="20%">
							<?php echo ($get->tingkat_sekolah == "4") ? "Kartu Imunisasi" : "Surat Keterangan Lulus"   ?>
						</td>
						<td width="2%">: </td>
						<td>
							<?php if ($get->skl) : ?>
								<a href="<?= base_url() ?>uploads/siswa/<?= $get->skl ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat Lampiran</a>
							<?php else : ?>
								Lampiran tidak tersedia
							<?php endif; ?>
						</td>
					</tr>


					<?php if ($get->jalur == "117") { ?>

						<tr>
							<td width="20%">
								Lampiran Bukti Prestasi Lainnya
							</td>
							<td width="2%">:</td>
							<td>
								<?php if ($get->suket_prestasi) : ?>
									<a href="<?= base_url() ?>uploads/siswa/<?= $get->suket_prestasi ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat Lampiran</a>
								<?php else : ?>
									Lampiran tidak tersedia
								<?php endif; ?>
							</td>
						</tr>
					<?php } ?>
				</table>
			</div>
			<hr>
			<p><input type="checkbox" required> Saya nyatakan data yang saya isi benar-benar sesuai dengan data yang sesungguhnya dan saya siap mendapatkan sanksi apabila dikemudian hari ada data yg terbukti saya rekayasa. </p>
			<p> <input type="checkbox" required> Dengan mengisi formulir pendaftaran ini saya nyatakan bersedia mengikuti seluruh peraturan yang berlaku pada sekolah dan tidak menuntut apabila dikemudian hari saya melanggar dan diberi sanksi atau dikeluarkan dari sekolah</p>
		</div>
	</div>
	<hr>
	<button class="btn btn-success pull-right " type="submit"> Simpan </button>
	<?php if (level_user() == "siswa") { ?>
	<?php } else { ?>
		<a href="<?= base_url() ?>siswa/edit/lampiran?id=<?= $get->id_siswa ?>" class="btn btn-warning pull-right mr-3 "> <i class="ri-arrow-left-fill"></i> Kembali </a>
	<?php } ?>
</form>

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

			if (history.pushState) {
				const url = new URL(window.location);
				url.searchParams.delete('alert');
				url.searchParams.delete('message');
				window.history.replaceState({}, document.title, url.toString());
			}
		});
	</script>
<?php endif; ?>