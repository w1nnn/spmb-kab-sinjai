<div class="row ">
	<div class="col-sm-12">
		<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
			<div class="iq-card-body">
				<a href="#" onclick="goBack()" class="btn btn-sm btn-warning mb-2 "> <i class="ri-arrow-go-back-line "></i> Kembali </a>
				<div class="clearfix"></div>
				<div class="iq-advance-course ">

					<form action="<?= base_url()?>jalur/manage/update" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="id" value="<?= $get->id ?>">
						<div class="form-group">
							<label for=""> Judul <span class="text-danger">*</span> </label>
							<input type="text" value="<?= $get->nama ?>" class="form-control" name="nama" autocomplete="off" required>
						</div>
						<div class="form-group">
							<label for=""> Deskripsi <span class="text-danger">*</span>  </label>
							<textarea name="deskripsi"  id="" class="form-control" ><?= $get->deskripsi ?></textarea>
						</div>
						<div class="form-group">
							<label for=""> Lampiran (jpg/pdf) </label>
							<input type="file" class="form-control-file" name="lampiran" autocomplete="off">
						</div>
						<hr>
						
						<button class="btn btn-primary pull-right" type="submit"> <i class="ri-refresh-line "></i>  Update  </button>
						<div class="clearfix"></div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: "textarea",
        height: 200,
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code ",
            "insertdatetime media table contextmenu paste code"
        ],
        toolbar:
            "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        content_css: [
            "//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css",
            "//www.tinymce.com/css/codepen.min.css"
        ]
    });

</script>
