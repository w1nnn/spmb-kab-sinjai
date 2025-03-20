<?php
$eUsia = $this->session->flashdata('error');
?>
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
				<input type="number" maxlength="16" oninput="this.value=this.value.slice(0,this.maxLength)" value="<?= $get->no_ktp ?>" class="form-control" name="no_ktp" required>
			</div>
			<div class="form-group">
				<label for=""> Nama Calon Siswa <span class="text-danger">*</span> </label>
				<input type="text" value="<?= $get->nama_siswa ?>" class="form-control" name="nama_siswa" required>
			</div>
			<div class="form-group">
				<label for=""> Tempat Lahir <span class="text-danger">*</span> </label>
				<input type="text" value="<?= $get->tempat_lahir ?>" class="form-control" name="tempat_lahir" required>
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
					<input type="text" class="form-control" name="asal_sekolah" value="<?= $get->asal_sekolah ?>">
				</div>
			<?php } ?>
			<div class="form-group">
				<label for=""> Alamat Rumah <span class="text-danger">*</span> </label>
				<textarea name="alamat" class="form-control" required><?= $get->alamat ?> </textarea>
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