<form action="<?= base_url() ?>siswa/save" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?= $get->id_siswa ?>">
	<input type="hidden" name="ukuran_baju" value="<?= $get->ukuran_baju ?>">
	<input type="hidden" name="lanjut" value="selesai">
	<input type="hidden" name="page" value="lampiran">
	<input type="hidden" name="jalur" value="<?= $get->jalur ?>">
	<div class="row">
		<div class="col">
			<div class="card text-white iq-bg-primary iq-mb-3">
				<div class="card-body">
					<h5 class="card-title text-primary text-center">
						<i style="font-size:30px;" class="ri-guide-fill fs-30"></i> <br>
						1. Jalur
					</h5>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="card text-white iq-bg-primary iq-mb-3">
				<div class="card-body">
					<h5 class="card-title text-primary text-center">
						<i style="font-size:30px;" class="ri-user-2-fill fs-30"></i> <br>
						2. Data Diri
					</h5>
				</div>
			</div>
		</div>

		<div class="col">
			<div class="card text-white iq-bg-primary iq-mb-3">
				<div class="card-body">
					<h5 class="card-title text-primary text-center">
						<i style="font-size:30px;" class="ri-building-fill fs-30"></i> <br>
						3. Sekolah
					</h5>
				</div>
			</div>
		</div>


		<div class="col">
			<div class="card text-white iq-bg-primary iq-mb-3">
				<div class="card-body">
					<h5 class="card-title text-primary text-center">
						<i style="font-size:30px;" class="ri-parent-fill fs-30"></i> <br>
						4. Orang Tua
					</h5>
				</div>
			</div>
		</div>

		<div class="col">
			<div class="card text-white bg-primary iq-mb-3">
				<div class="card-body">
					<h5 class="card-title text-white text-center">
						<i style="font-size:30px;" class="ri-booklet-fill fs-30"></i> <br>
						5. Dokumen
					</h5>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="card text-white iq-bg-primary iq-mb-3">
				<div class="card-body">
					<h5 class="card-title text-primary text-center">
						<i style="font-size:30px;" class="ri-folder-chart-fill fs-30"></i> <br>
						6. Selesai
					</h5>
				</div>
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
						<td>Foto ukuran 3x4 , file jpg, max 500 kb<br><input type="file" style="display: inline;width: auto" class="form-control-file" name="foto" <?= ($get->foto == "") ? "required" : ""; ?> accept="image/jpeg,image/x-png"></td>
						<td>
							<span class="text-danger"> <?= (!empty($this->session->flashdata('error_foto'))) ? " " . $this->session->flashdata('message') . " " : "";  ?> </span>
							<img src="<?= base_url() ?>uploads/siswa/<?= $get->foto ?>" width="100px;" alt="" required>
						</td>
					</tr>
					<tr>
						<td><b onclick="$(this).closest('tr').find('input[type=file]').click()"> Kartu Keluarga <span class="text-danger">*</span></b></td>
						<td>File pdf / jpg, max 500 kb<br><input type="file" style="display: inline;width: auto" accept="image/jpeg,image/x-png,application/pdf" class="form-control-file" name="kk" <?= ($get->kk == "") ? "required" : ""; ?>></td>
						<td>
							<span class="text-danger"> <?= (!empty($this->session->flashdata('error_kk'))) ? " " . $this->session->flashdata('message') . " " : "";  ?> </span>

							<?php if ($get->kk) : ?>
								<a href="<?= base_url() ?>uploads/siswa/<?= $get->kk ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat</a>
							<?php else : ?>
								Lampiran tidak tersedia
							<?php endif; ?>
						</td>

					</tr>
					<tr>
						<td><b onclick="$(this).closest('tr').find('input[type=file]').click()"> Akta Kelahiran Calon Siswa <span class="text-danger">*</span></b></td>
						<td>File pdf / jpg, max 500 kb<br><input type="file" style="display: inline;width: auto" accept="image/jpeg,image/x-png,application/pdf" class="form-control-file" name="akta" <?= ($get->akta_kelahiran_siswa == "") ? "required" : ""; ?>></td>
						<td>
							<span class="text-danger"> <?= (!empty($this->session->flashdata('error_akta'))) ? " " . $this->session->flashdata('message') . " " : "";  ?> </span>
							<?php if ($get->akta_kelahiran_siswa) : ?>
								<a href="<?= base_url() ?>uploads/siswa/<?= $get->akta_kelahiran_siswa ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat</a>
							<?php else : ?>
								Lampiran tidak tersedia
							<?php endif; ?>
						</td>
					</tr>


					<tr>
						<td>
							<b onclick="$(this).closest('tr').find('input[type=file]').click()"><?php echo ($get->tingkat_sekolah == "4") ? "Kartu Imunisasi" : "Surat Keterangan Lulus / Surat Tanda Selesai Belajar (STSB)"   ?></b>
						</td>
						<td>File pdf / jpg, max 500 kb<br><input type="file" style="display: inline;width: auto" accept="image/jpeg,image/x-png,application/pdf" class="form-control-file" name="skl"></td>
						<td>
							<span class="text-danger"> <?= (!empty($this->session->flashdata('error_skl'))) ? " " . $this->session->flashdata('message') . " " : "";  ?> </span>
							<?php if ($get->skl) : ?>
								<a href="<?= base_url() ?>uploads/siswa/<?= $get->skl ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat</a>
							<?php else : ?>
								Lampiran tidak tersedia
							<?php endif; ?>
						</td>
					</tr>

					<?php
					if ($get->jalur != "114") {
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
							<td>File pdf / jpg, max 500 kb<br><input type="file" accept="image/jpeg,image/x-png,application/pdf" style="display: inline;width: auto" class="form-control-file" name="suket" <?= ($get->suket == "") ? "required" : ""; ?>></td>
							<td>
								<span class="text-danger"> <?= (!empty($this->session->flashdata('error_suket'))) ? " " . $this->session->flashdata('message') . " " : "";  ?> </span>
								<?php if ($get->suket) : ?>
									<a href="<?= base_url() ?>uploads/siswa/<?= $get->suket ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat</a>
								<?php else : ?>
									Lampiran tidak tersedia
								<?php endif; ?>
							</td>
						</tr>
					<?php } ?>

					<?php if ($get->jalur == "117") { ?>
						<tr>
							<td><b onclick="$(this).closest('tr').find('input[type=file]').click()"> Lampiran Bukti Prestasi Lainnya </b></td>
							<td>File pdf / jpg, max 500 kb<br><input type="file" accept="image/jpeg,image/x-png,application/pdf" style="display: inline;width: auto" class="form-control-file" name="suket_prestasi"></td>
							<td>
								<span class="text-danger"> <?= (!empty($this->session->flashdata('error_suket'))) ? " " . $this->session->flashdata('message') . " " : "";  ?> </span>
								<?php if ($get->suket_prestasi) : ?>
									<a href="<?= base_url() ?>uploads/siswa/<?= $get->suket_prestasi ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat</a>
								<?php else : ?>
									Lampiran tidak tersedia
								<?php endif; ?>
							</td>
						</tr>
						<tr>
							<td><b> Bidang Prestasi </b></td>
							<td><input type="text" class="form-control" name="bidang_prestasi" placeholder="Contoh : Bidang Seni, Olahraga, Iptek, Lingkungan hidup dll.. " value="<?= $get->bidang_prestasi ?>"> </td>
							<td>
								<?= $get->bidang_prestasi ?>
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

	<!-- <a href="<?= base_url() ?>siswa/profil/sekolah" class="btn btn-warning pull-right mr-3 "> <i
				class="ri-arrow-left-fill"></i> Kembali </a> -->
</form>