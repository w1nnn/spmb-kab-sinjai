<?php
$eUsia = $this->session->flashdata('error');
$statusError = $this->session->flashdata('status');
$message = $this->session->flashdata('message');
?>
<?php if ($eUsia && $statusError == 'danger'): ?>
	<script>
		$(document).ready(function() {
			$('#uploadModal').modal('show');
		});
	</script>
<?php endif; ?>


<!-- Modal Upload File -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="uploadModalLabel">Upload File Bukti Surat Keterangan Psikolog</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?= base_url() ?>siswa/update_psikolog" method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<label for="fileUpload" style="color: red; font-style: italic;">
							<?= $message; ?> untuk melanjutkan proses pendaftaran silahkan buktikan surat keterangan dari psikolog:</label>
						<input type="hidden" name="id" value="<?= $get->id_siswa ?>">

						<input type="hidden" name="lanjut" value="sekolah">
						<input type="hidden" name="page" value="datadiri">
						<input name="lampiran" type="file" class="form-control-file" id="fileUpload" name="fileUpload" required accept=".jpg,.jpeg,.png,.pdf">
					</div>
					<div id="filePreview" class="form-group" style="display:none;">
						<div id="previewContainer"></div>
					</div>
					<hr>
					<p><input type="checkbox" required> Saya nyatakan data yang saya unggah benar-benar sesuai dengan data yang asli dan saya siap mendapatkan sanksi apabila dikemudian hari data yang saya unggah terbukti rekayasa. </p>
					<button type="submit" class="btn btn-primary" id="submitBtn">Upload</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Modal end -->
<form action="<?= base_url() ?>siswa/save" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?= $get->id_siswa ?>">
	<input type="hidden" name="lanjut" value="sekolah">
	<input type="hidden" name="page" value="datadiri">

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
			<div class="card text-white bg-primary iq-mb-3">
				<div class="card-body">
					<h5 class="card-title text-white text-center">
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
			<div class="card text-white iq-bg-primary iq-mb-3">
				<div class="card-body">
					<h5 class="card-title text-primary text-center">
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
		<div class="col-md-6">
			<div class="form-group">
				<label for=""> Nomor Induk Kependudukan <span class="text-danger">*</span> </label>
				<input type="number" readonly maxlength="16" oninput="this.value=this.value.slice(0,this.maxLength)" value="<?= $get->no_ktp ?>" class="form-control" name="no_ktp" required>
			</div>
			<div class="form-group">
				<label for=""> Nama Calon Siswa <span class="text-danger">*</span> </label>
				<input type="text" readonly value="<?= $get->nama_siswa ?>" class="form-control" name="nama_siswa" required>
			</div>
			<div class="form-group">
				<label for=""> Tempat Lahir <span class="text-danger">*</span> </label>
				<input autocomplete="off" type="text" value="<?= $get->tempat_lahir ?>" class="form-control" name="tempat_lahir" required>
			</div>
			<div class="form-group">
				<label for=""> Tanggal Lahir <span class="text-danger">*</span> </label>
				<input type="date" value="<?= $get->tgl_lahir ?>" class="form-control" name="tgl_lahir" required>
			</div>
			<div class="form-group">
				<label for=""> Jenis Kelamin <span class="text-danger">*</span> </label>
				<select name="jk" class="form-control" id="" required>
					<option value=""> Pilih</option>
					<option value="L" <?= ($get->jk == "L") ? "selected" : ""; ?>> Laki - Laki</option>
					<option value="P" <?= ($get->jk == "P") ? "selected" : ""; ?>> Perempuan</option>
				</select>
			</div>
			<div class="form-group">
				<label for=""> Agama <span class="text-danger">*</span> </label>
				<select name="agama" class="form-control" id="" required>
					<option value=""> Pilih</option>
					<option value="Islam" <?= ($get->agama == "Islam") ? "selected" : ""; ?>> Islam</option>
					<option value="Katolik" <?= ($get->agama == "Katolik") ? "selected" : ""; ?>> Katolik</option>
					<option value="Protestan" <?= ($get->agama == "Protestan") ? "selected" : ""; ?>> Protestan
					</option>
					<option value="Hindu" <?= ($get->agama == "Hindu") ? "selected" : ""; ?>> Hindu</option>
					<option value="Budha" <?= ($get->agama == "Budha") ? "selected" : ""; ?>> Budha</option>
				</select>
			</div>
		</div>
		<div class="col-md-6">

			<div class="form-group">
				<label for=""> Ukuran Baju <span class="text-danger">*</span> </label>
				<!-- <input type="text" name="ukuran_baju" class="form-control" value="<?= $get->ukuran_baju ?>" required> -->
				<select class="form-control" name="ukuran_baju" required>
					<option value="">Pilih Ukuran Baju</option>
					<?php
					$ub = ['S', 'M', 'L', 'XL', 'XXL'];
					?>
					<?php foreach ($ub as $key => $vb) : ?>
						<option <?php echo $vb == $get->ukuran_baju ? 'selected' : '' ?> value="<?php echo $vb ?>"><?php echo $vb ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<?php if ($get->tingkat_sekolah != "4") {  ?>
				<div class="form-group">
					<label for=""> Asal Sekolah <span class="text-danger">*</span> </label>
					<input autocomplete="off" type="text" class="form-control" name="asal_sekolah" value="<?= $get->asal_sekolah ?>">
				</div>
			<?php } ?>
			<div class="form-group">
				<label for=""> Alamat Rumah <span class="text-danger">*</span> </label>
				<textarea autocomplete="off" name="alamat" class="form-control" required><?= $get->alamat ?> </textarea>
			</div>
			<div class="form-group">
				<label for=""> Kecamatan <span class="text-danger">*</span> </label>
				<select name="kec" class="form-control select2 kecamatan" id="kecamatan" required>
					<option value="">Pilih Kecamatan</option>
					<?php foreach ($kecamatan as $value) : $selected = ($get->kec == $value->id_kec) ? "selected" : ""; ?>
						<option value="<?= $value->id_kec ?>" <?= $selected ?>> <?= $value->nama_kec ?> </option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label for=""> Desa / Dusun / Jalan / Lingkungan Tempat Tinggal <span class="text-danger">*</span>
				</label>
				<select name="dusun" class="form-control select2" id="zonasi" required>
					<option value=""></option>
				</select>
			</div>
		</div>
	</div>
	<hr>
	<button class="btn btn-primary pull-right " type="submit"> Selanjutnya <i class="ri-arrow-right-fill"></i></button>
	<?php if (level_user() == "siswa") { ?>
		<a href="<?= base_url() ?>siswa/profil" class="btn btn-warning pull-right mr-3 "> <i class="ri-arrow-left-fill"></i> Kembali </a>
	<?php } else { ?>
		<a href="<?= base_url() ?>siswa/edit?id=<?= $get->id_siswa ?>" class="btn btn-warning pull-right mr-3 "> <i class="ri-arrow-left-fill"></i> Kembali </a>

	<?php } ?>
</form>
<!-- Menambahkan SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>

<script>
	// alert($('.kecamatan').find(":selected").val());
	$(document).ready(function() {
		if ('<?php echo $eUsia ?>' == 'usia') {
			$("input[name='tgl_lahir']").focus();
		}
		const kecamatanDefault = $('.kecamatan').find(":selected").val();

		$.ajax({
			type: "POST",
			url: "<?php echo base_url("sekolah/zonasi/getDaerahKecamatan"); ?>",
			data: {
				kecamatan: kecamatanDefault,
				'id_siswa': '<?= $get->id_siswa  ?>'
			}, // data yang akan dikirim ke file yang dituju
			dataType: "JSON",
			beforeSend: function(e) {
				if (e && e.overrideMimeType) {
					e.overrideMimeType("application/json;charset=UTF-8");
				}
			},
			success: function(response) {
				$("#zonasi").html(response.list_daerah).show();

			},
			error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
				alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
			}
		});

		$("#kecamatan").change(function() {

			const kecamatanValue = $('.kecamatan').val();

			$.ajax({
				type: "POST",
				url: "<?php echo base_url("sekolah/zonasi/getDaerahKecamatan"); ?>",
				data: {
					kecamatan: kecamatanValue,
					'id_siswa': '<?= $get->id_siswa  ?>'
				}, // data yang akan dikirim ke file yang dituju
				dataType: "JSON",
				beforeSend: function(e) {
					if (e && e.overrideMimeType) {
						e.overrideMimeType("application/json;charset=UTF-8");
					}
				},
				success: function(response) {
					$("#zonasi").html(response.list_daerah).show();

				},
				error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
					alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
				}
			});
		});
	});
</script>
<!-- <script>
	// Menampilkan preview dan validasi file
	$(document).ready(function() {
		// Menampilkan modal upload file jika ada error dan status 'danger'
		<?php if ($eUsia && $statusError == 'danger'): ?>
			$('#uploadModal').modal('show');
		<?php endif; ?>

		// File input change handler
		$('#fileUpload').change(function() {
			// Get the file input value and file size
			var file = this.files[0];
			var fileSize = file.size / 1024; // Size in KB
			var fileName = file.name;
			var fileExtension = fileName.split('.').pop().toLowerCase();

			// Validasi file extension (hanya gambar dan pdf)
			var validExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
			if ($.inArray(fileExtension, validExtensions) == -1) {
				alert("File harus berupa gambar (JPG, JPEG, PNG) atau PDF.");
				$('#fileUpload').val(''); // Clear the input
				$('#filePreview').hide(); // Hide preview
				return;
			}

			// Validasi ukuran file (maksimal 500 KB)
			if (fileSize > 500) {
				alert("Ukuran file maksimal 500 KB.");
				$('#fileUpload').val(''); // Clear the input
				$('#filePreview').hide(); // Hide preview
				return;
			}

			// Menampilkan preview file berdasarkan jenis file
			if (fileExtension == 'pdf') {
				// Jika file PDF
				$('#filePreview').show();
				$('#previewContainer').html('<embed src="' + URL.createObjectURL(file) + '" width="100%" height="400px" type="application/pdf">');
			} else if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
				// Jika file gambar
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#filePreview').show();
					$('#previewContainer').html('<img src="' + e.target.result + '" class="img-fluid" alt="Preview">');
				};
				reader.readAsDataURL(file);
			}
		});
	});
</script> -->
<script>
	// Menampilkan preview dan validasi file
	$(document).ready(function() {
		// Menampilkan modal upload file jika error dan status 'danger'
		<?php if ($eUsia && $statusError == 'danger'): ?>
			$('#uploadModal').modal('show');
		<?php endif; ?>

		// File input change handler
		$('#fileUpload').change(function() {
			// Get the file input value and file size
			var file = this.files[0];
			var fileSize = file.size / 1024; // Size in KB
			var fileName = file.name;
			var fileExtension = fileName.split('.').pop().toLowerCase();

			// Validasi file extension (hanya gambar dan pdf)
			var validExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
			if ($.inArray(fileExtension, validExtensions) == -1) {
				// Menampilkan alert menggunakan SweetAlert2
				Swal.fire({
					icon: 'error',
					title: 'File tidak valid!',
					text: 'File harus berupa gambar (JPG, JPEG, PNG) atau PDF.'
				});
				$('#fileUpload').val(''); // Clear the input
				$('#filePreview').hide(); // Hide preview
				return;
			}

			// Validasi ukuran file (maksimal 500 KB)
			if (fileSize > 500) {
				// Menampilkan alert menggunakan SweetAlert2
				Swal.fire({
					icon: 'error',
					title: 'Ukuran file terlalu besar!',
					text: 'Ukuran file maksimal 500 KB.'
				});
				$('#fileUpload').val(''); // Clear the input
				$('#filePreview').hide(); // Hide preview
				return;
			}

			// Menampilkan preview file berdasarkan jenis file
			if (fileExtension == 'pdf') {
				// Jika file PDF
				$('#filePreview').show();
				$('#previewContainer').html('<embed src="' + URL.createObjectURL(file) + '" width="100%" height="400px" type="application/pdf">');
			} else if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
				// Jika file gambar
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#filePreview').show();
					$('#previewContainer').html('<img src="' + e.target.result + '" class="img-fluid" alt="Preview">');
				};
				reader.readAsDataURL(file);
			}
		});
	});
</script>