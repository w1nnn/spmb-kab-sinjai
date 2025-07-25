<!-- CKEditor 5 CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

<div class="row ">
	<div class="col-sm-12">
		<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
			<div class="iq-card-body">
				<a href="#" onclick="goBack()" class="btn btn-sm btn-warning mb-2 ">
					<i class="ri-arrow-go-back-line"></i> Kembali
				</a>
				<div class="clearfix"></div>
				<div class="iq-advance-course ">
					<form action="<?= base_url() ?>jalur/manage/save" method="POST" enctype="multipart/form-data">
						<div class="form-group">
							<label for=""> Nama <span class="text-danger">*</span> </label>
							<input type="text" class="form-control" name="nama" autocomplete="off" required>
						</div>
						<div class="form-group">
							<label for=""> Deskripsi <span class="text-danger">*</span> </label>
							<textarea name="deskripsi" id="editor" class="form-control"></textarea>
						</div>
						<div class="form-group">
							<label for=""> Lampiran (jpg/pdf) </label>
							<input type="file" class="form-control-file" name="lampiran" autocomplete="off">
						</div>
						<hr>
						<button class="btn btn-primary pull-right" type="submit">
							<i class="ri-save-line"></i> Simpan
						</button>
						<div class="clearfix"></div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- CKEditor Initialization -->
<script>
	ClassicEditor
		.create(document.querySelector('#editor'))
		.catch(error => {
			console.error(error);
		});
</script>