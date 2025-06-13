<div class="row ">
	<div class="col-sm-12">
		<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
			<div class="iq-card-body">
				<a href="#" onclick="goBack()" class="btn btn-sm btn-warning mb-2 "> <i class="ri-arrow-go-back-line "></i> Kembali </a>
				<div class="clearfix"></div>
				<div class="iq-advance-course ">

					<form action="<?= base_url()?>dtks/manage/update" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="id" value="<?= $get->id ?>">
						<div class="form-group">
							<label for=""> NIK <span class="text-danger">*</span> </label>
							<input type="text" value="<?= $get->nik ?>" class="form-control" name="nik" autocomplete="off" required>
						</div>
						<!-- Status -->
						<div class="form-group">
							<label for=""> Status <span class="text-danger">*</span> </label>
							<select name="status" class="form-control" required>
								<option value="">-- Pilih Status --</option>
								<option value="Terdaftar" <?= $get->status == 'Terdaftar' ? 'selected' : '' ?>>Terdaftar</option>
								<option value="Tidak Terdaftar" <?= $get->status == 'Tidak Terdaftar' ? 'selected' : '' ?>>Tidak Terdaftar</option>
							</select>
						</div>
						<button class="btn btn-primary pull-right" type="submit"> <i class="ri-refresh-line "></i>  Update  </button>
						<div class="clearfix"></div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	document.querySelector('input[name="nik"]').addEventListener('input', function() {
    this.value = this.value.replace(/[^0-9]/g, '').substring(0, 16);
});
</script>
