<?php if (level_user() == 'superadmin' || level_user() == 'admin' || (level_user() == 'sekolah' && configs()->zonasi->start <= date('Y-m-d') && configs()->zonasi->end >= date('Y-m-d'))) : ?>
	<div class="row ">
		<div class="col-sm-12">
			<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
				<div class="iq-card-body">
					<a href="#" onclick="goBack()" class="btn btn-sm btn-warning mb-2 "> <i class="ri-arrow-go-back-line "></i> Kembali </a>
					<div class="clearfix"></div>
					<div class="iq-advance-course ">

						<form action="<?= base_url() ?>sekolah/zonasi/save" method="POST" enctype="multipart/form-data">
							<?php if (level_user() == "sekolah") { ?>
								<input type="hidden" class="form-control sekolahSelected" name="npsn" autocomplete="off" value="<?= $this->session->userdata('npsn') ?>" required>
								<div class="form-group">
									<label for=""> Sekolah <span class="text-danger">*</span> </label>
									<input type="text" class="form-control" name="" autocomplete="off" value="<?= $this->session->userdata('nama') ?>" readonly>
								</div>
							<?php } else if (level_user() == "admin" || level_user() == "superadmin") { ?>
								<div class="form-group">
									<label for=""> Sekolah <span class="text-danger">*</span> </label>
									<select name="npsn" class="form-control sekolah select2" required>
										<option value=""> Pilih Sekolah</option>
										<?php foreach ($sekolah as $getSekolah) : ?>
											<option value="<?= $getSekolah->npsn ?>"> <?= $getSekolah->nama ?> </option>
										<?php endforeach; ?>
									</select>
								</div>

							<?php } ?>

							<div class="form-group">
								<label for="zonasi"> Daerah Zonasi <span class="text-danger">*</span> </label>
								<select name="daerah[]" class="form-control select2-multi" multiple="multiple" id="zonasi" required>
									<option value=""> Pilih </option>
								</select>

							</div>

							<hr>
							<button class="btn btn-primary pull-right" type="submit"><i class="ri-save-line"></i> Simpan
							</button>
							<div class="clearfix"></div>
						</form>
						<br>
						<div class="alert alert-success  alert-dismissible text-dark">
							<a href="#" class="close text-dark" data-dismiss="alert" aria-label="close">&times;</a>

							<p style=""> Lihat referensi tentang zonasi sesuai Peraturan Bupati Sinjai Nomor 4 Tahun 2020 Pedoman Pelaksanaan Penerimaan Peserta Didik Baru Pada Satuan Pendidikan <a href="<?= base_url() ?>uploads/lampiran/lampiran_perbup.pdf" target="blank"> disini </a> </p>
						</div>


					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {


			let sekolahSelected;
			sekolahSelected = $(".sekolahSelected").val()

			$.ajax({
				type: "POST",
				url: "<?php echo base_url("sekolah/zonasi/getDaerah"); ?>",
				data: {
					sekolah: sekolahSelected
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



			$(".sekolah").change(function() {

				$.ajax({
					type: "POST",
					url: "<?php echo base_url("sekolah/zonasi/getDaerah"); ?>",
					data: {
						sekolah: $(".sekolah").val()
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
<?php else : ?>
	<div class="row ">
		<div class="col-sm-12">
			<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
				<div class="iq-card-body">
					<span class="h4 text-center"><i class="fa fa-fw fa-lock"></i> Manajemen Zonasi Sekolah telah Berakhir!</span>
				</div>
			</div>
		</div>
	</div>
	<script>
		setTimeout(() => {
			location.href = '/sekolah/zonasi';
		}, 3000)
	</script>
<?php endif; ?>