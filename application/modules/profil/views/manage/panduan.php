
<div class="row ">
	<div class="col-sm-12">
		<form action="<?= base_url()?>profil/manage/update" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="act" value="panduan">
			<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
				<div class="iq-card-body">
					<div class="iq-advance-course ">
						<div class="form-group">
							<label for=""> Upload File Panduan Pendaftaran (PDF) </label>
							<input type="file" class="form-control-file" name="panduan">
						</div>
						<button type="submit" class="btn btn-primary">Simpan</button>
						<button type="reset" class="btn iq-bg-danger">Batal</button>
						<hr>
						<a href="<?= base_url()?>uploads/etc/<?= $get->panduan ?>" class="btn btn-primary" download> <i class="ri-download-2-fill"></i> Download Panduan  </a>
						<br>
						<iframe src="<?= base_url()?>uploads/etc/<?= $get->panduan ?>" width="100%" height="500px">
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
