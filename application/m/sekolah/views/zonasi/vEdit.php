<?php if (level_user() == 'superadmin' || level_user() == 'admin' || (level_user() == 'sekolah' && configs()->zonasi->start <= date('Y-m-d') && configs()->zonasi->end >= date('Y-m-d'))) : ?>
	<div class="row ">
		<div class="col-sm-12">
			<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
				<div class="iq-card-body">
					<a href="#" onclick="goBack()" class="btn btn-sm btn-warning mb-2 "> <i class="ri-arrow-go-back-line "></i> Kembali </a>
					<div class="clearfix"></div>
					<div class="iq-advance-course ">

						<form action="<?= base_url() ?>sekolah/zonasi/update" method="POST" enctype="multipart/form-data">

							<?php if (level_user() == "sekolah") { ?>
								<input type="hidden" class="form-control" name="npsn" autocomplete="off" value="<?= $this->session->userdata('npsn') ?>" required>
								<div class="form-group">
									<label for=""> Sekolah <span class="text-danger">*</span> </label>
									<!-- <input type="text" class="form-control" name="" autocomplete="off"
										value="<?= $this->session->userdata('nama') ?>" readonly> -->
									<select class="form-control sekolah" disabled>
										<option selected value="<?= $this->session->userdata('npsn') ?>"> <?= $this->session->userdata('nama') ?> </option>
									</select>
								</div>
							<?php } elseif (level_user() == "admin" || level_user() == "superadmin") { ?>
								<div class="form-group">
									<label for=""> Sekolah <span class="text-danger">*</span> </label>
									<select name="npsn" class="form-control select2 sekolah" required>
										<option value=""> Pilih Sekolah </option>
										<?php foreach ($sekolah as $getSekolah) :  $selected = ($getSekolah->npsn == $get->npsn_sekolah) ? "selected" : ""; ?>
											<option value="<?= $getSekolah->npsn ?>" <?= $selected ?>> <?= $getSekolah->nama ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>

							<?php } ?>

							<div class="form-group">
								<label for=""> Daerah Zonasi <span class="text-danger">*</span> </label>
								<select name="daerah[]" class="form-control select2-multi " multiple="multiple" id="zonasi" required>
									<option value=""> Pilih </option>
								</select>

							</div>

							<hr>
							<button class="btn btn-primary pull-right" type="submit"> <i class="ri-save-line"></i> Update
							</button>
							<div class="clearfix"></div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {



			const sekolahSelected = $('.sekolah').find(":selected").val();

			$.ajax({
				type: "POST",
				url: "<?php echo base_url("sekolah/zonasi/getDaerah?act=edit"); ?>",
				data: {
					sekolah: sekolahSelected
				},
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
					alert(xhr.status + "\n" + xhr.responseText + "\n" +
						thrownError); // Munculkan alert error
				}
			});



			$(".sekolah").change(function() {

				$.ajax({
					type: "POST",
					url: "<?php echo base_url("sekolah/zonasi/getDaerah?act=edit"); ?>",
					data: {
						sekolah: $(".sekolah").val()
					},
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
						alert(xhr.status + "\n" + xhr.responseText + "\n" +
							thrownError); // Munculkan alert error
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