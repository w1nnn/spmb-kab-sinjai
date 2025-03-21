<form action="<?= base_url() ?>siswa/save" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?= $get->id_siswa ?>">
	<input type="hidden" name="ukuran_baju" value="<?= $get->ukuran_baju ?>">
	<input type="hidden" name="lanjut" value="selesai">
	<input type="hidden" name="page" value="lampiran">
	<input type="hidden" name="jalur" value="<?= $get->jalur ?>">

	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<tr class="iq-bg-primary text-center">
						<th width="25%"> Nama Dokumen</th>
						<th width="40%"> Pilih File</th>
						<th> #</th>
					</tr>

					<!-- Foto -->
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

					<!-- Kartu Keluarga -->
					<tr>
						<td><b onclick="$(this).closest('tr').find('input[type=file]').click()"> Kartu Keluarga <span class="text-danger">*</span></b></td>
						<td>File pdf / jpg, Max 500 kb<br>
							<input type="file" style="display: inline;width: auto" accept="image/jpeg,image/x-png,application/pdf" class="form-control-file" name="kk" <?= ($get->kk == "") ? "required" : ""; ?> onchange="previewFile(this, 'kkPreview')">
						</td>
						<td>
							<span class="text-danger"> <?= (!empty($this->session->flashdata('error_kk'))) ? " " . $this->session->flashdata('message') . " " : ""; ?> </span>
							<div id="kkPreview" style="display: <?= $get->kk ? 'block' : 'none'; ?>">
								<?php if ($get->kk && is_image($get->kk)) : ?>
									<img src="<?= base_url() ?>uploads/siswa/<?= $get->kk ?>" width="100px;" alt="">
								<?php elseif ($get->kk) : ?>
									<a href="<?= base_url() ?>uploads/siswa/<?= $get->kk ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat</a>
								<?php else : ?>
									Lampiran tidak tersedia
								<?php endif; ?>
							</div>
						</td>
					</tr>

					<!-- Akta Kelahiran -->
					<tr>
						<td><b onclick="$(this).closest('tr').find('input[type=file]').click()"> Akta Kelahiran Calon Siswa <span class="text-danger">*</span></b></td>
						<td>File pdf / jpg, Max 500 kb<br>
							<input type="file" style="display: inline;width: auto" accept="image/jpeg,image/x-png,application/pdf" class="form-control-file" name="akta" <?= ($get->akta_kelahiran_siswa == "") ? "required" : ""; ?> onchange="previewFile(this, 'aktaPreview')">
						</td>
						<td>
							<span class="text-danger"> <?= (!empty($this->session->flashdata('error_akta'))) ? " " . $this->session->flashdata('message') . " " : ""; ?> </span>
							<div id="aktaPreview" style="display: <?= $get->akta_kelahiran_siswa ? 'block' : 'none'; ?>">
								<?php if ($get->akta_kelahiran_siswa && is_image($get->akta_kelahiran_siswa)) : ?>
									<img src="<?= base_url() ?>uploads/siswa/<?= $get->akta_kelahiran_siswa ?>" width="100px;" alt="">
								<?php elseif ($get->akta_kelahiran_siswa) : ?>
									<a href="<?= base_url() ?>uploads/siswa/<?= $get->akta_kelahiran_siswa ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat</a>
								<?php else : ?>
									Lampiran tidak tersedia
								<?php endif; ?>
							</div>
						</td>
					</tr>

					<!-- Surat Keterangan Lulus -->
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
								<?php if ($get->skl && is_image($get->skl)) : ?>
									<img src="<?= base_url() ?>uploads/siswa/<?= $get->skl ?>" width="100px;" alt="">
								<?php elseif ($get->skl) : ?>
									<a href="<?= base_url() ?>uploads/siswa/<?= $get->skl ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat</a>
								<?php else : ?>
									Lampiran tidak tersedia
								<?php endif; ?>
							</div>
						</td>
					</tr>

					<!-- Surat Keterangan Tidak Mampu / Pindah Tugas -->
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
									<?php if ($get->suket && is_image($get->suket)) : ?>
										<img src="<?= base_url() ?>uploads/siswa/<?= $get->suket ?>" width="100px;" alt="">
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
	// Fungsi untuk memeriksa ukuran file dan menampilkan gambar jika file tidak melebihi 500KB
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

	// Fungsi untuk memverifikasi gambar atau dokumen PDF
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