<div class="row ">
	<div class="col-sm-12">
		<form action="<?= base_url() ?>profil/manage/update" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="act" value="sambutan">
			<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
				<div class="iq-card-body">
					<div class="iq-advance-course ">
						<div class="form-group">
							<label for=""> Sambutan Kepala Dinas </label>
							<textarea class="form-control" id="" cols="30" name="sambutan"> <?= $get->sambutan ?> </textarea>
						</div>
						<div class="form-group">
							<label for=""> Nama Kepala Dinas </label>
							<input type="text" class="form-control" name="nama_kadis" value="<?= $get->nama_kadis ?>">
						</div>
						<div class="form-group">
							<label for=""> Foto Kepala Dinas </label> <br>

							<img src="<?= base_url() ?>uploads/etc/<?= $get->foto_kadis ?>" class="rounded-circle" alt="" style="width:150px; height:150px;">
							<br>
							<input type="file" class="form-control-file" name="fotokadis">
						</div>
						<button type="submit" class="btn btn-primary">Simpan</button>
						<button type="reset" class="btn iq-bg-danger">Batal</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<script src="https://cdn.tiny.cloud/1/1e7071suorrjx5e8l8vbnasbwuu0yhtrqqdsnmtnvit9u0xo/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script>
	tinymce.init({
		selector: "textarea",
		height: 200,
		plugins: [
			"advlist autolink lists link image charmap print preview anchor",
			"searchreplace visualblocks code ",
			"insertdatetime media table contextmenu paste code"
		],
		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
		content_css: [
			"//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css",
			"//www.tinymce.com/css/codepen.min.css"
		]
	});
</script>