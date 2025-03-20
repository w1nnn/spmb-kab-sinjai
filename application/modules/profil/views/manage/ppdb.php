<div class="row">
	<div class="col-sm-12">
		<form action="<?= base_url() ?>profil/manage/update" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="act" value="ppdb">
			<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
				<div class="iq-card-body">
					<div class="iq-advance-course ">
						<div class="form-group">
							<label for=""> Penjelasan Singkat SPMB </label>
							<textarea name="ppdb" class="form-control" id="tempalte"> <?= $get->ppdb ?> </textarea>
						</div>
						<div class="form-group">
							<label for=""> Lampiran File PDF </label>
							<a href="<?= base_url() ?>uploads/etc/<?= $get->lampiran ?> " target="_blank"> Lihat Lampiran </a>
							<input type="file" class="form-control-file" name="lampiran">
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