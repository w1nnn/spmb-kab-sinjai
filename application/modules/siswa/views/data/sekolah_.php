<form action="<?= base_url() ?>siswa/save" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?= $get->id_siswa ?>">
	<input type="hidden" name="lanjut" value="lampiran">
	<input type="hidden" name="page" value="sekolah">
	<div class="row">
		<div class="col">
			<div class="card text-white iq-bg-primary iq-mb-3">
				<div class="card-body">
					<h4 class="card-title text-primary text-center">
						<i class="ri-user-2-fill fs-30"></i> <br>
						Data Diri
					</h4>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="card text-white iq-bg-primary iq-mb-3">
				<div class="card-body">
					<h4 class="card-title text-primary text-center">
						<i class="ri-user-2-fill fs-30"></i> <br>
						Orang Tua
					</h4>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="card text-white bg-primary iq-mb-3">
				<div class="card-body">
					<h4 class="card-title text-white text-center">
						<i class="ri-user-2-fill fs-30"></i> <br>
						Sekolah
					</h4>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="card text-white iq-bg-primary iq-mb-3">
				<div class="card-body">
					<h4 class="card-title text-primary text-center">
						<i class="ri-user-2-fill fs-30"></i> <br>
						Lampiran
					</h4>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="card text-white iq-bg-primary iq-mb-3">
				<div class="card-body">
					<h4 class="card-title text-primary text-center">
						<i class="ri-user-2-fill fs-30"></i> <br>
						Selesai
					</h4>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label for=""> Jalur Pendaftaran <span class="text-danger">*</span> </label>
				<select name="jalur" class="form-control" id="jalur">
					<option value=""> Pilih</option>
					<?php foreach ($jalur as $value) : $selected = ($value->id == $get->jalur) ? "selected" : ""; ?>
						<option value="<?= $value->id ?>" <?= $selected ?>> <?= $value->nama ?> </option>
					<?php endforeach; ?>
				</select>
			</div>
			<div id="zonasi">
				<div class="form-group">
					<label for=""> Jalur Zonasi <span class="text-danger">*</span> </label>
					<select name="area" class="form-control" id="area">
						<option value=""> Pilih</option>
						<option value="zonasi"> Area Domisili</option>
						<option value="all"> Area Jarak Terdekat</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for=""> Sekolah Pilihan 1 <span class="text-danger">*</span> </label>
				<select name="sekolah_pilihan_1" class="form-control select2 sekolah" id="sekolah_1" style="width: 100%;" required>
					<option value=""></option>
				</select>
			</div>

		</div>
	</div>
	<hr>
	<p class="text-danger">** Sekolah tampil berdasarkan jalur yang dipilih dan daerah tempat tinggal kecuali jalur
		prestasi </p>
	<button class="btn btn-primary pull-right " type="submit"> Selanjutnya <i class="ri-arrow-right-fill"></i></button>
	<a href="<?= base_url() ?>siswa/profil/orangtua" class="btn btn-warning pull-right mr-3 "> <i class="ri-arrow-left-fill"></i> Kembali </a>
</form>


<script>
	// $('#area').on('change', function () {
	//     const selectVal = $("#area option:selected").val();
	//     alert(selectVal);
	// });
	//

	$('#zonasi').hide();

	$(document).ready(function() {

		const jalurSelected = $('#jalur').find(":selected").val();
		if (jalurSelected == "114") {
			$('#zonasi').show();
		}
		$.ajax({
			type: "POST",
			url: "<?php echo base_url("sekolah/zonasi/get_sekolah"); ?>",
			data: {
				jalur: jalurSelected,
				'zonasi': '<?= $get->dusun ?>',
				'id_siswa': '<?= $get->id_siswa  ?>'
			}, // data yang akan dikirim ke file yang dituju
			dataType: "JSON",
			beforeSend: function(e) {
				if (e && e.overrideMimeType) {
					e.overrideMimeType("application/json;charset=UTF-8");
				}
			},
			success: function(response) {
				$("#sekolah_1").html(response.list_sekolah).show();

			},
			error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
				alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
			}
		});



		$("#jalur").change(function() {
			let jalur;
			let url;
			let areaSelected;

			url = "<?php echo base_url("sekolah/zonasi/get_sekolah"); ?>";
			jalur = $("#jalur").val();


			$.ajax({
				type: "POST",
				url: url,
				data: {
					'jalur': $("#jalur").val(),
					'zonasi': '<?= $get->dusun ?>',
					'id_siswa': '<?= $get->id_siswa ?>',
				}, // data yang akan dikirim ke file yang dituju
				dataType: "JSON",
				beforeSend: function(e) {
					if (e && e.overrideMimeType) {
						e.overrideMimeType("application/json;charset=UTF-8");
					}
				},
				success: function(response) {
					$("#sekolah_1").html(response.list_sekolah).show();
				},
				error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
					alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
				}
			});
		});



	});
</script>